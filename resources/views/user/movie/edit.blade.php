@extends('layouts.user')

@section('title', '登録動画の編集')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>登録動画の編集</h2>
                <form action="{{ action('user\MovieController@update') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="form-group row">
                        <label class="col-md-2">動画URL</label>
                        <div class="col-md-10">
                            <input type="url" class="form-control" name="movieurl" value="{{  $movie_form->movieurl }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">タグ</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="tag" rows="3">{{ $movie_form->tag }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="hidden" name="id" value="{{ $movie_form->id }}">
                            <input type="hidden" name="user_id" value="{{ $movie_form->user_id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="更新">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="button" value="登録動画の一覧" onClick="location.href='{{ asset('user/movie/index') }}'">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
