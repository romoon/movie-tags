@extends('layouts.user')

@section('title', 'MyMovieの新規作成')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>MyMovieの新規作成</h2>
                <form action="{{ action('User\MovieController@create') }}" method="post" enctype="multipart/form-data">

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
                            <input type="url" class="form-control" name="movieurl" value="{{  old('movieurl') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">タグ</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="tag" rows="3">{{ old('tag') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="登録">
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
