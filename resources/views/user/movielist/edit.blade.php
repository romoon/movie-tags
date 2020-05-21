@extends('layouts.user')

@section('title', '動画リストの編集')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>動画リストの編集</h2>
                <form action="{{ action('user\ListController@update') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="form-group row">
                        <label class="col-md-2">動画リスト名</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="listname" value="{{  $movielist_form->listname }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">タグ</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="taglist" rows="3">{{ $movielist_form->taglist }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="hidden" name="id" value="{{ $movielist_form->id }}">
                            <input type="hidden" name="user_id" value="{{ $movielist_form->user_id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="更新">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
