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
    if ($tag != '') {
        // 検索されたら検索結果を取得する
        $search = Movie::where('user_id', $currentuser)
        ->where('tag', $tag);
        $results = $search->get();
    } else {
        // それ以外はすべてのgivingを取得する
        $results = Movie::where('user_id', $currentuser)->get();
    }
    return view('user.movie.index', ['results' => $results, 'tag' => $tag]);
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
