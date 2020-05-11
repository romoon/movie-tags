<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Movielist;
use DB;

class ListController extends Controller
{
    public function add()
  {
      return view('user.movielist.create');
  }

  public function create(Request $request)
    {
        // Varidationを行う
        $this->validate($request, Movielist::$rules);

        $movie = new Movielist;
        $form = $request->all();

        unset($form['_token']);

        $movie->fill($form);
        $movie->save();

        return redirect('user/movielist/create');
    }

  public function index(Request $request)
  {
    $currentuser = \Auth::user()->id;
    $tag = $request->tag;

    if ($tag != '') {
        // 検索されたら検索結果を取得する
        $search = Movielist::where('user_id', $currentuser)
        ->where('taglist', 'like', '%'.$tag.'%');
        $results = $search->get();

    } else {
        // それ以外はすべてのMovieを取得する
        $results = Movielist::where('user_id', $currentuser)->get();
    }

      return view('user.movielist.index', ['tag' => $tag, 'results' => $results]);
  }

  public function edit(Request $request)
  {
    // dd($request);
      $movielist = Movielist::find($request->id);
      if (empty($movielist)) {
        abort(404);
      }
      return view('user.movielist.edit', ['movielist_form' => $movielist]);
  }

  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Movielist::$rules);
      // データを取得する
      $movielist = Movielist::find($request->id);
      // 送信されてきたフォームデータを格納する
      $movielist_form = $request->all();
      // _tokenを削除する。
      unset($movielist_form['_token']);

      // 該当するデータを上書きして保存する
      $movielist->fill($movielist_form)->save();

      return redirect('user/movielist/create');
  }

  public function delete(Request $request)
  {
    // 該当するNews Modelを取得
    $movielist = Movielist::find($request->id);
    // 削除する
    $movielist->delete();

    return redirect('user/movielist/index');
  }

  public function search(Request $request)
  {
    $listresults=[];
    $currentuser = \Auth::user()->id;
    $movielist = Movielist::find($request->id);
    $prekey = $movielist->taglist;

    // 全角スペースを半角スペースに変換
    $prekey = mb_convert_kana($prekey, 's');

    // スペースの正規表現「/[\s]+/」にして、1つ以上の連続した半角スペースで分割
    // PREG_SPLIT_NO_EMPTY を指定して、空文字列以外だけを返す
    $keywords = preg_split('/[\s]+/', $prekey, -1, PREG_SPLIT_NO_EMPTY);

    $keywordCondition=[];
    foreach( $keywords as $keyword ){
      $keywordCondition[] = 'tag LIKE "%' . $keyword . '%"';
    }

    // $keywordCondition = implode(' AND ', $keywordCondition);
    $keywordCondition = implode(' OR ', $keywordCondition);

    $prekeyword = "SELECT * FROM movietags.movies WHERE " . $keywordCondition . " AND user_id = " . $currentuser;
    // dd($prekeyword)

    $results = DB::select("$prekeyword");
    // dd($results);

    //
    // movie information
    //
    if ( $results != null ) {

        foreach ($results as $result) {
          $value0 = $result->id;
          $value1 = $result->tag;
          $value2 = $result->user_id;

          // 動画IDの抽出（とりあえず正規表現のみ）
          $video_url = $result->movieurl;

          parse_str( parse_url( $video_url, PHP_URL_QUERY ), $pre_video_id );
          $video_id = $pre_video_id['v'];

          // Youtube API Key
          $api_key = "AIzaSyBQ1dxu64jcpxQ2rqANUmPvHGEv938AMS4";

          // 動画情報の取得
          $get_api_url = "https://www.googleapis.com/youtube/v3/videos?id=$video_id&key=$api_key&part=snippet,contentDetails,statistics,status";
          // dd($get_api_url);
          $json = file_get_contents($get_api_url);
          $getData = json_decode( $json , true);

          // タイトル、サムネイルURLの抽出
          foreach((array)$getData['items'] as $key => $gDat){
          	$video_title = $gDat['snippet']['title'];
          	$description = $gDat['snippet']['description'];
          	$thumnail_url = $gDat['snippet']['thumbnails']['default']['url'];
          }
          // 配列化
          $listresults[]=array('id' => $value0, 'thumnail_url' => $thumnail_url, 'video_title' => $video_title, 'description' => $description, 'tag' => $value1, 'user_id' => $value2, 'movieurl' => $video_url );
        }
  } else {
        $listresults = [];
  }

    return view('user.movielist.result', ['listresults' => $listresults]);
  }
}
