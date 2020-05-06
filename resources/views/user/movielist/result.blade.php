@extends('layouts.user')

@section('title', '動画リストの検索結果一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>動画リストの検索結果一覧</h2>
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
                            @foreach($results as $result)
                                <tr>
                                    <td><img src="{{ $result['thumnail_url'] }}" alt="thumnail-image"></td>
                                    <td>{{ \Str::limit($result['video_title'], 100) }}</td>
                                    <td>{{ \Str::limit($result['description'], 100) }}</td>
                                    <td>{{ \Str::limit($result['tag'], 100) }}</td>
                                    <td>
                                      <div>
                                          <a href="#">編集</a>
                                          <a href="#">削除</a>
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
