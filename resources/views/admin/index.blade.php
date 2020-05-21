@extends('layouts.admin')

@section('title', 'Userの一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>Userの一覧</h2>
        </div>
        <!-- 検索 -->
        <div class="row">
            <div class="col-md-12">
                <form action="{{ action('admin\AdminController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">検索（メールアドレス）</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="email" value="{{ $email }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                            <a href="{{ action('user\AdminController@index', $tag=null) }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- 一覧表 -->
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="10%">id</th>
                                <th width="10%">名前</th>
                                <th width="20%">メールアドレス</th>
                                <th width="15%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ \Str::limit($user->id, 10) }}</td>
                                    <td>{{ \Str::limit($user->name, 20) }}</td>
                                    <td>{{ \Str::limit($user->email, 50) }}</td>
                                    <td>
                                        <div>
                                          <a href="{{ action('admin\AdminController@delete', ['id' => $user->id]) }}">削除</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="button" value="トップページ" onClick="location.href='{{ asset('/index') }}'">
            </div>
        </div>
    </div>
@endsection
