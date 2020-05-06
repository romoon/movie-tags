<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Movielist;

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

      return redirect('user/movielist/edit');
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
    $results=[];
    
    return view('user.movielist.result', ['results' => $results]);
  }
}
