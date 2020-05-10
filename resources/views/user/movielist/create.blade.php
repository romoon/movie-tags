@extends('layouts.user')

@section('title', '動画リストの新規作成')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>動画リストの新規作成</h2>
                <form action="{{ action('User\ListController@create') }}" method="post" enctype="multipart/form-data">

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
                            <input type="text" class="form-control" name="listname" value="{{  old('listname') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">タグリスト</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="taglist" rows="3">{{ old('taglist') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="登録">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
