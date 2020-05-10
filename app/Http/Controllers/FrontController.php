<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Movielist;
use DB;

class FrontController extends Controller
{
    public function index(Request $request)
    {
      // 3回繰り返し
      for ($i = 1; $i < 4; $i++) {

          //
          // データベースからランダムに1レコード選び、タグ情報を取得する
          //
          $movie = Movie::orderByRaw("RAND()")->first();
          $prekey = $movie->tag;

          //
          // タグを配列化し、ランダムに1つ選ぶ
          //
          $prekey = mb_convert_kana($prekey, 's');
          $keywords = preg_split('/[\s]+/', $prekey, -1, PREG_SPLIT_NO_EMPTY);

          $keyword = $keywords[ array_rand( $keywords,1 ) ] ;

          //
          // データベースを検索
          //
          $search = Movie::where('tag', 'like', '%'.$keyword.'%');
          $results = $search->orderByRaw("RAND()")->take(3)->get();

          //
          // 検索結果のうち3つについて、動画情報を配列化する
          //
          // $k = 1;
          foreach ($results as $result) {
            // if ( $k > 3) {
            //   break;
            // } else {
              $value0 = $result->id;
              // $value1 = $result->tag;
              // $value2 = $result->user_id;
              $video_url = $result->movieurl;

              // Video ID, API
              parse_str( parse_url( $video_url, PHP_URL_QUERY ), $pre_video_id );
              $video_id = $pre_video_id['v'];
              $api_key = "AIzaSyCDB8zK2rgqLcorcYgwAuax0BbOB7pjn9Q";

              $get_api_url = "https://www.googleapis.com/youtube/v3/videos?id=$video_id&key=$api_key&part=snippet,contentDetails,statistics,status";
              $json = file_get_contents($get_api_url);
              $getData = json_decode( $json , true);

              // 動画情報の取得
              foreach((array)$getData['items'] as $key => $gDat){
                $video_title = $gDat['snippet']['title'];
                // $description = $gDat['snippet']['description'];
                $thumnail_url = $gDat['snippet']['thumbnails']['medium']['url'];
              }

              // 配列化
              ${"results".$i}[] = array ('id' => $value0, 'thumnail_url' => $thumnail_url, 'video_title' => $video_title, 'keyword' => $keyword, 'movieurl' => $video_url);
          }
          // $k++;
          // }
    }

      //
      // Taglist ランダムID->検索 3個
      //

      // Movielist からランダムに取得
      $movielist = Movielist::orderByRaw("RAND()")->first();

      // Taglist ->配列化 ->SQL文の構築 ->検索
      $prekey2 = $movielist->taglist;
      $prekey2 = mb_convert_kana($prekey2, 's');
      $keywords2 = preg_split('/[\s]+/', $prekey2, -1, PREG_SPLIT_NO_EMPTY);

      $keywordCondition2=[];
      foreach( $keywords2 as $keyword ){
        $keywordCondition2[] = 'tag LIKE "%' . $keyword . '%"';
      }

      // $keywordCondition2 = implode(' AND ', $keywordCondition2);
      $keywordCondition2 = implode(' OR ', $keywordCondition2);

      $prekeyword2 = "SELECT * FROM movietags.movies WHERE " . $keywordCondition2 . "LIMIT 6";
      $listresults = DB::select("$prekeyword2");

      // movie information
      if ( $listresults != null ) {

          foreach ($listresults as $result) {
            $value0 = $result->id;
            $value1 = $result->tag;
            // $value2 = $result->user_id;
            $value3 = $result->movieurl;

            // 動画IDの抽出（とりあえず正規表現のみ）
            $video_url2 = $result->movieurl;

            parse_str( parse_url( $video_url2, PHP_URL_QUERY ), $pre_video_id2 );
            $video_id2 = $pre_video_id2['v'];

            // Youtube API Key
            $api_key = "AIzaSyCDB8zK2rgqLcorcYgwAuax0BbOB7pjn9Q";

            // 動画情報の取得
            $get_api_url2 = "https://www.googleapis.com/youtube/v3/videos?id=$video_id2&key=$api_key&part=snippet,contentDetails,statistics,status";
            $json = file_get_contents($get_api_url2);
            $getData = json_decode( $json , true);

            // タイトル、サムネイルURLの抽出
            foreach((array)$getData['items'] as $key => $gDat){
            	$video_title = $gDat['snippet']['title'];
            	// $description = $gDat['snippet']['description'];
            	$thumnail_url = $gDat['snippet']['thumbnails']['medium']['url'];
            }
            // 配列化
            $listinfos[]=array('id' => $value0, 'thumnail_url' => $thumnail_url, 'video_title' => $video_title,  'tag' => $value1, 'prekey2' => $prekey2, 'movieurl' => $value3 );
          }
      } else {
            $listinfos = [];
      }

      return view('/index', ['results1' => $results1, 'results2' => $results2, 'results3' => $results3, 'listinfos' => $listinfos ]);
    }
}
