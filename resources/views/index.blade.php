@extends('layouts.front')

@section('title', 'Movie Tag DB')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Left column  -->
            <div class="col-md-8">
              <div class="">
                <h4>Feel lucky Tag</h4>
                @for ($n = 1; $n < 4; $n++)
                  <h2>Tag:{{ ${"results".$n}[0]['keyword'] }}</h2>
                  <table class="table">
                  <thead>
                      <tr>
                          <th width="20%">Thumbnail</th>
                          <th width="40%">Title</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach(${"results".$n} as $result)
                        <tr>
                            <td><a href="{{ $result['movieurl'] }}"  target=”_blank”><img src="{{ $result['thumnail_url'] }}" alt="thumnail-image"></td></a>
                            <td>{{ \Str::limit($result['video_title'], 100) }}</td>
                        </tr>
                    @endforeach
                  </tbody>
                  </table>
                  <hr style="border-top:3px double lightgray;">
                @endfor
              </div>
              <div class="">
              <h4>Feel lucky Tag-List</h4>
              <h2>Tag-List:{{ $listinfos[0]['prekey2'] }}</h2>
              <table class="table">
                <thead>
                  <tr>
                    <th width="20%">Thumbnail</th>
                    <th width="40%">Title</th>
                    <th width="20%">Tag</th>
                  </tr>
                </thead>
              <?php $i=1 ?>
                <tbody>
                @foreach($listinfos as $listinfo)
                  @if( $i > 3 )
                    @break
                  @endif
                        <tr>
                            <td><a href="{{ $listinfo['movieurl'] }}"><img src="{{ $listinfo['thumnail_url'] }}" alt="thumnail-image"></td></a>
                            <td>{{ \Str::limit($listinfo['video_title'], 100) }}</td>
                            <td>{{ \Str::limit($listinfo['tag'], 100) }}</td>
                        </tr>
                <?php $i++ ?>
                @endforeach
                </tbody>
              </table>
            </div>

          </div>
            <!-- Right column  -->
            <div class="col-md-4">

            </div>
        </div>
        <div class="row">
            <hr style="border-top:3px double lightgray;">
            <div class="col-md-12">
                <input type="button" value="登録動画の一覧" onClick="location.href='{{ asset('user/movie/index') }}'">
                <input type="button" value="動画の新規登録" onClick="location.href='{{ asset('user/movie/create') }}'">
                <input type="button" value="動画リストの一覧" onClick="location.href='{{ asset('user/movielist/index') }}'">
                <input type="button" value="動画リストの作成" onClick="location.href='{{ asset('user/movielist/create') }}'">
                {{-- <input type="button" value="Admin 管理者のページ" onClick="location.href='{{ asset('admin/profile/index') }}'"> --}}
            </div>
        </div>
    </div>
@endsection
