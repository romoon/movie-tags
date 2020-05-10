@extends('layouts.user')

@section('title', '登録済み動画の一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>登録済み動画の一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('User\MovieController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('user\MovieController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タグの検索</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="tag" value="{{ $tag }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                            <a href="{{ action('user\MovieController@index', $tag=null) }}">Reset</a>
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
                                <th width="15%">Thumbnail</th>
                                <th width="25%">Title</th>
                                <th width="30%">Description</th>
                                <th width="20%">tag</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movie_infos as $movie_info)
                                <tr>
                                    <td><a href="{{ $movie_info['movieurl'] }}"  target=”_blank”><img src="{{ $movie_info['thumnail_url'] }}" alt="thumnail-image"></td></a>
                                    <td>{{ \Str::limit($movie_info['video_title'], 100) }}</td>
                                    <td>{{ \Str::limit($movie_info['description'], 100) }}</td>
                                    <td>{{ \Str::limit($movie_info['tag'], 100) }}</td>
                                    <td>
                                      <div>
                                          <a href="{{ action('user\MovieController@edit', ['id' => $movie_info['id']]) }}">編集</a>
                                          <a href="{{ action('user\MovieController@delete', ['id' => $movie_info['id']]) }}">削除</a>
                                      </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
