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
                            @foreach($listresults as $listresult)
                                <tr>
                                    <td><a href="{{ $listresult['movieurl'] }}"  target=”_blank”><img src="{{ $listresult['thumnail_url'] }}" alt="thumnail-image"></a></td>
                                    <td>{{ \Str::limit($listresult['video_title'], 100) }}</td>
                                    <td>{{ \Str::limit($listresult['description'], 100) }}</td>
                                    <td>{{ \Str::limit($listresult['tag'], 100) }}</td>
                                    <td>
                                      <div>
                                        <a href="{{ action('user\MovieController@edit', ['id' => $listresult['id']]) }}">編集</a>
                                        <a href="{{ action('user\MovieController@delete', ['id' => $listresult['id']]) }}">削除</a>
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
