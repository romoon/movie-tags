@extends('layouts.front')

@section('title', 'Movie Tag DB')

@section('content')
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>Movie Tags</h1>
            <hr style="border-top:3px double lightgray;">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mt-0 mb-4">
            <input type="button" value="動画の新規登録" onClick="location.href='{{ asset('user/movie/create') }}'">
            <input type="button" value="動画の新規登録" onClick="location.href='{{ asset('user/movie/index') }}'">
            <input type="button" value="動画リストの一覧" onClick="location.href='{{ asset('user/movielist/index') }}'">
            <input type="button" value="動画リストの作成" onClick="location.href='{{ asset('user/movielist/create') }}'">
          </div>
        </div>

        <!-- Tag -->
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Feel lucky Tag</h4>
                    </div>
                
                    @for($count=1 ;$count < 4; $count++ )
                    <div class="col-md-12 mt-md-4">
                      <h2>Tag : {{ ${"results".$count}[0]['keyword'] }}</h2>
                    </div>
                    @foreach(${"results".$count} as $result)
                        <div class="col-md-3 mr-md-1 mt-md-2">
                          <a href="{{ $result['movieurl'] }}"  target=”_blank”><img src="{{ $result['thumnail_url'] }}" class="img-fluid" alt="thumnail-image"></a></br>
                          <p>{{ \Str::limit($result['video_title'], 100) }}</p>
                        </div>
                    @endforeach
                    <div class="col-md-12">
                        <hr style="border-top:3px double lightgray;">
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Tag-List -->
        <div class="row">
            <div class="col-md-12 mt-md-4">
                <h4>Feel lucky Tag-List</h4>
            </div>
            <div class="col-md-12 mt-md-4">
                <h2>Tag-List : {{ $listinfos[0]['prekey2'] }}</h2>
            </div>
            @foreach($listinfos as $listinfo)
            <div class="col-md-3 mr-md-1 mt-md-2 pull-left">
                <a href="{{ $listinfo['movieurl'] }}" target="_blank"><img src="{{ $listinfo['thumnail_url'] }}" class="img-fluid" alt="thumnail-image"></a></br>
                <p>{{ \Str::limit($listinfo['video_title'], 100) }}</p></br>
                <p>{{ \Str::limit($listinfo['tag'], 100) }}</p>
            </div>
            @endforeach
            <div class="col-md-12">
                <hr style="border-top:3px double lightgray;">
            </div>
        </div>

        <div class="row">
            <hr style="border-top:3px double lightgray;">
            <div class="col-md-12">
                <input type="button" value="Admin 管理者ページへ" onClick="location.href='{{ asset('admin/index') }}'">
            </div>
        </div>

@endsection
