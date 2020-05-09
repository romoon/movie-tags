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
      for ($i = 1; $i < 4; $i++) {
      // Movie ランダムID->ランダムTag1つ->検索
      $movie = Movie::orderByRaw("RAND()")->first();
      $prekey = $movie->tag;

      $prekey = mb_convert_kana($prekey, 's');
      $keywords = preg_split('/[\s]+/', $prekey, -1, PREG_SPLIT_NO_EMPTY);

      $keyword = $keywords[ array_rand( $keywords,1 ) ] ;

      $search = Movie::where('tag', 'like', '%'.$keyword.'%');
      $results = $search->get();

      for ($k = 1; $k < 4; $k++) {
        foreach ($results as $result) {
          $value0 = $result->id;
          // $value1 = $result->tag;
          // $value2 = $result->user_id;
          $video_url = $result->movieurl;
        }

        parse_str( parse_url( $video_url, PHP_URL_QUERY ), $pre_video_id );
        $video_id = $pre_video_id['v'];
        $api_key = "AIzaSyB_NlACkE5IituNxbNUdF2Pcx-uBAk5nUc";

        $get_api_url = "https://www.googleapis.com/youtube/v3/videos?id=$video_id&key=$api_key&part=snippet,contentDetails,statistics,status";
        $json = file_get_contents($get_api_url);
        $getData = json_decode( $json , true);

        foreach((array)$getData['items'] as $key => $gDat){
          $video_title = $gDat['snippet']['title'];
          // $description = $gDat['snippet']['description'];
          $thumnail_url = $gDat['snippet']['thumbnails']['default']['url'];
        }

        ${"results".$i}[] = array ('id' => $value0, 'thumnail_url' => $thumnail_url, 'video_title' => $video_title, 'keyword' => $keyword, 'movieurl' => $video_url);
      }
    }

      // Taglist ランダムID->検索 3個
      $movielist = Movielist::orderByRaw("RAND()")->first();
      $prekey2 = $movielist->taglist;

      $prekey2 = mb_convert_kana($prekey2, 's');
      $keywords2 = preg_split('/[\s]+/', $prekey2, -1, PREG_SPLIT_NO_EMPTY);

      $keywordCondition2=[];
      foreach( $keywords2 as $keyword ){
        $keywordCondition2[] = 'tag LIKE "%' . $keyword . '%"';
      }

      // $keywordCondition2 = implode(' AND ', $keywordCondition2);
      $keywordCondition2 = implode(' OR ', $keywordCondition2);

      $prekeyword2 = "SELECT * FROM movietags.movies WHERE " . $keywordCondition2;
      // dd($prekeyword2);

      $listresults = DB::select("$prekeyword2");
      // dd($listresults);

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
            $api_key = "AIzaSyB_NlACkE5IituNxbNUdF2Pcx-uBAk5nUc";

            // 動画情報の取得
            $get_api_url2 = "https://www.googleapis.com/youtube/v3/videos?id=$video_id2&key=$api_key&part=snippet,contentDetails,statistics,status";
            $json = file_get_contents($get_api_url2);
            $getData = json_decode( $json , true);

            // タイトル、サムネイルURLの抽出
            foreach((array)$getData['items'] as $key => $gDat){
            	$video_title = $gDat['snippet']['title'];
            	// $description = $gDat['snippet']['description'];
            	$thumnail_url = $gDat['snippet']['thumbnails']['default']['url'];
            }
            // 配列化
            $listinfos[]=array('id' => $value0, 'thumnail_url' => $thumnail_url, 'video_title' => $video_title,  'tag' => $value1, 'prekey2' => $prekey2, 'movieurl' => $value3 );
          }
      } else {
            $listinfos = [];
      }
      // dd($listinfos);

      return view('/index', ['results1' => $results1, 'results2' => $results2, 'results3' => $results3, 'listinfos' => $listinfos ]);
    }
}
