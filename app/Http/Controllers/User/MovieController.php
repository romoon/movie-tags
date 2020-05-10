<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Movie;

class MovieController extends Controller
{
    //
    public function add()
  {
      return view('user.movie.create');
  }

  public function create(Request $request)
  {
      // Varidationを行う
      $this->validate($request, Movie::$rules);

      $movie = new Movie;
      $form = $request->all();

      unset($form['_token']);

      $movie->fill($form);
      $movie->save();

      return redirect('user/movie/create');
  }

  public function index(Request $request)
  {
    $currentuser = \Auth::user()->id;
    $tag = $request->tag;
    $movie_infos = []; // 初期値を設定しておかないと、検索ヒット0のときエラーになる。

    if ($tag != '') {
        // 検索されたら検索結果を取得する
        $search = Movie::where('user_id', $currentuser)
        ->where('tag', 'like', '%'.$tag.'%');
        $results = $search->get();

    } else {
        // それ以外
        $results = Movie::where('user_id', $currentuser)->get();
        // $results = Movie::orderByRaw("RAND()")->take(10)->get();
    }

    foreach ($results as $result) {
      $value0 = $result->id;
      $value1 = $result->tag;
      $value2 = $result->user_id;
      $value3 = $result->movieurl;

      // 動画IDの抽出（とりあえず正規表現のみ）
      $video_url = $result->movieurl;

      parse_str( parse_url( $video_url, PHP_URL_QUERY ), $pre_video_id );
      $video_id = $pre_video_id['v'];

      // Youtube API Key
      $api_key = "AIzaSyCDB8zK2rgqLcorcYgwAuax0BbOB7pjn9Q";

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
      $movie_infos[]=array('id' => $value0, 'thumnail_url' => $thumnail_url, 'video_title' => $video_title, 'description' => $description, 'tag' => $value1, 'user_id' => $value2, 'movieurl' => $value3 );
    }

    return view('user.movie.index', ['tag' => $tag, 'movie_infos' => $movie_infos]);
  }

  public function edit(Request $request)
  {
      $movie = Movie::find($request->id);
      if (empty($movie)) {
        abort(404);
      }
      return view('user.movie.edit', ['movie_form' => $movie]);
  }

  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Movie::$rules);
      // Giving Modelからデータを取得する
      $movie = Movie::find($request->id);
      // 送信されてきたフォームデータを格納する
      $movie_form = $request->all();
      // _tokenを削除する。
      unset($movie_form['_token']);

      // 該当するデータを上書きして保存する
      $movie->fill($movie_form)->save();

      return redirect('user/movie/index');
  }

  public function delete(Request $request)
  {
    // 該当するNews Modelを取得
    $movie = Movie::find($request->id);
    // 削除する
    $movie->delete();

    return redirect('user/movie/index');
  }
}
