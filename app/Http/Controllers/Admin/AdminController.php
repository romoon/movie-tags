<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
  public function index(Request $request)
  {
    $email = $request->email;
    if ($email != '') {
        // 検索されたら検索結果を取得する
        $users = User::where('email', $email)->get();
    } else {
      // それ以外はすべてのProfileを取得する
        $users = User::all();
    }
    return view('admin.index', ['users' => $users, 'email' => $email]);
  }

  public function delete(Request $request)
  {
    $del_user = User::find($request->id);
    $del_user->delete();

    return redirect('admin/index');
  }
}
