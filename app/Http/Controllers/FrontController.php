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
      //
      // Tag 抽出 -> 3個 検索 x 3組
      //
      // 3回繰り返し
      for ($i = 1; $i < 4; $i++) {

          // データベースからランダムに1レコード選び、タグ情報を取得する
          $movie = Movie::orderByRaw("RAND()")->first();
          $prekey = $movie->tag;

          // 全角スペースを半角化->配列化->ランダムに1つ選ぶ
          $prekey = mb_convert_kana($prekey, 's');
          $keywords = preg_split('/[\s]+/', $prekey, -1, PREG_SPLIT_NO_EMPTY);
          $keyword = $keywords[ array_rand( $keywords,1 ) ] ;

          // データベースを検索->ランダムに3つ選ぶ
          $search = Movie::where('tag', 'like', '%'.$keyword.'%');
          $results = $search->orderByRaw("RAND()")->limit(3)->get();

          // 検索結果のうち3つについて、動画情報を配列化する
          foreach ($results as $result) {
              $value0 = $result->id;
              // $value1 = $result->tag;
              // $value2 = $result->user_id;
              $video_url = $result->movieurl;

              // Video ID, API->jsonを取得するURLを構築->json get->decode
              parse_str( parse_url( $video_url, PHP_URL_QUERY ), $pre_video_id );
              $video_id = $pre_video_id['v'];
              $api_key = config('app.yt_key');
              // dd($api_key);

              $get_api_url = "https://www.googleapis.com/youtube/v3/videos?id=$video_id&key=$api_key&part=snippet,contentDetails,statistics,status";
              // dd($get_api_url);
              $json = file_get_contents($get_api_url);
              $getData = json_decode( $json , true);

              // 動画情報の抽出
              foreach((array)$getData['items'] as $key => $gDat){
                  $video_title = $gDat['snippet']['title'];
                  // $description = $gDat['snippet']['description'];
                  $thumnail_url = $gDat['snippet']['thumbnails']['medium']['url'];
              }

              // 配列化
              ${"results".$i}[] = array ('id' => $value0, 'thumnail_url' => $thumnail_url, 'video_title' => $video_title, 'keyword' => $keyword, 'movieurl' => $video_url);
          } // foreachここまで
      } // forここまで

      //
      // Taglist ランダムレコード 1個 -> 検索 3個
      //
      // Movielist からランダムに取得
      $movielist = Movielist::orderByRaw("RAND()")->first();

      // Taglistの取得->全角スペースを半角化->配列化
      $prekey2 = $movielist->taglist;
      $prekey2 = mb_convert_kana($prekey2, 's');
      $keywords2 = preg_split('/[\s]+/', $prekey2, -1, PREG_SPLIT_NO_EMPTY);

      // 検索文（SQL）の一部構築
      $keywordCondition2=[];
      foreach( $keywords2 as $keyword ){
        $keywordCondition2[] = 'tag LIKE "%' . $keyword . '%"';
      }

      // AND検索か OR検索か（現状、登録数少ないのでOR検索に）
      // $keywordCondition2 = implode(' AND ', $keywordCondition2);
      $keywordCondition2 = implode(' OR ', $keywordCondition2);

      // SQL文の構築->検索
      $prekeyword2 = "SELECT * FROM movietags.movies WHERE " . $keywordCondition2 . "LIMIT 6";
      $listresults = DB::select("$prekeyword2");

      // 動画情報の配列化
      if ( $listresults != null ) {
          foreach ($listresults as $result) {
              $value0 = $result->id;
              $value1 = $result->tag;
              // $value2 = $result->user_id;
              $value3 = $result->movieurl;

              // Video ID, API->jsonを取得するURLを構築->json get->decode
              $video_url2 = $result->movieurl;
              parse_str( parse_url( $video_url2, PHP_URL_QUERY ), $pre_video_id2 );
              $video_id2 = $pre_video_id2['v'];

              // $api_key = "AIzaSyBQ1dxu64jcpxQ2rqANUmPvHGEv938AMS4";
              $api_key = config('app.yt_key');

              $get_api_url2 = "https://www.googleapis.com/youtube/v3/videos?id=$video_id2&key=$api_key&part=snippet,contentDetails,statistics,status";
              $json = file_get_contents($get_api_url2);
              $getData = json_decode( $json , true);

              // 動画情報の抽出
              foreach((array)$getData['items'] as $key => $gDat){
              	$video_title = $gDat['snippet']['title'];
              	// $description = $gDat['snippet']['description'];
              	$thumnail_url = $gDat['snippet']['thumbnails']['medium']['url'];
              }

              // 配列化
              $listinfos[]=array('id' => $value0, 'thumnail_url' => $thumnail_url, 'video_title' => $video_title,  'tag' => $value1, 'prekey2' => $prekey2, 'movieurl' => $value3 );
          }
      } else {
          $listinfos = []; // 検索にヒットしなければ空の配列を返す
      }

      return view('/index', ['results1' => $results1, 'results2' => $results2, 'results3' => $results3, 'listinfos' => $listinfos ]);
    }
}
