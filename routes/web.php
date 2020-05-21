<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', 'FrontController@index');
Route::group(['prefix' => '/'], function() {
    Route::get('index', 'FrontController@index');
    Route::get('', 'FrontController@index');
});
// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function() {
    Route::get('movie/create', 'User\MovieController@add');
    Route::post('movie/create', 'User\MovieController@create');
    Route::get('movie/index', 'user\MovieController@index');
    Route::get('movie/edit', 'user\MovieController@edit');
    Route::post('movie/edit', 'user\MovieController@update');
    Route::get('movie/delete', 'user\MovieController@delete');

    Route::get('movielist/create', 'User\ListController@add');
    Route::post('movielist/create', 'User\ListController@create');
    Route::get('movielist/index', 'user\ListController@index');
    Route::get('movielist/edit', 'user\ListController@edit');
    Route::post('movielist/edit', 'user\ListController@update');
    Route::get('movielist/delete', 'user\ListController@delete');
    Route::get('movielist/result', 'user\ListController@search');
});

Route::group(['prefix' => 'admin'], function() {
    Route::get('index', 'admin\AdminController@index')->middleware('auth:admin');
    Route::get('delete', 'admin\AdminController@delete')->middleware('auth:admin');

    // 追加分
    Route::get('home', 'AdminHomeController@index')->name('admin.home');
    Route::get('login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'AdminAuth\LoginController@login')->name('admin.login');
    Route::post('logout', 'AdminAuth\LoginController@logout');
    Route::get('register', 'AdminAuth\RegisterController@showRegisterForm')->name('admin.register');
    Route::post('register', 'AdminAuth\RegisterController@register')->name('admin.register');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
