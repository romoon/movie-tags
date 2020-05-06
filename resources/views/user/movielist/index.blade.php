@extends('layouts.user')
@section('title', '動画リストの一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>動画リストの一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('User\ListController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('user\ListController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タグの検索</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="tag" value="{{ $tag }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                            <a href="{{ action('user\ListController@index', $tag=null) }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="25%">動画リスト名</th>
                                <th width="20%">タグリスト</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                                <tr>
                                    <td><a href="#">{{ $result['listname'] }}</a> </td>
                                    <td>{{ \Str::limit($result['taglist'], 100) }}</td>
                                    <td>
                                      <div>
                                          <a href="{{ action('user\ListController@edit', ['id' => $result['id']]) }}">編集</a>
                                          <a href="{{ action('user\ListController@delete', ['id' => $result['id']]) }}">削除</a>
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
            <div class="col-md-6">
                <input type="button" value="登録動画の一覧" onClick="location.href='{{ asset('user/movie/index') }}'">
                <input type="button" value="動画の新規登録" onClick="location.href='{{ asset('user/movie/create') }}'">
                <input type="button" value="動画リストの一覧" onClick="location.href='{{ asset('user/movielist/index') }}'">
                <input type="button" value="動画リストの作成" onClick="location.href='{{ asset('user/movielist/create') }}'">
            </div>
        </div>
    </div>
@endsection
