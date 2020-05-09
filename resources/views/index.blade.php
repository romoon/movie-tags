@extends('layouts.front')

@section('title', 'Movie Tag DB')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Left column  -->
            <div class="col-md-8">
                <h2>Feel lucky Tag</h2>
                <table class="table">
                <thead>
                    <tr>
                        <th width="20%">順位</th>
                        <th width="20%">ニックネーム</th>
                        <th width="20%">Giving</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
                <hr style="border-top:3px double lightgray;">
                <h2>Feel lucky Tag-List</h2>
                <table class="table">
                <thead>
                    <tr>
                        <th width="20%">順位</th>
                        <th width="20%">ニックネーム</th>
                        <th width="20%">Givingの年収割合</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
            </div>
            <!-- Right column  -->
            <div class="col-md-4">

            </div>
        </div>
        <div class="row">
            <hr style="border-top:3px double lightgray;">
            <div class="col-md-12">
                <input type="button" value="Mypage" onClick="location.href='{{ asset('user/movie/index') }}'">
                {{-- <input type="button" value="Admin 管理者のページ" onClick="location.href='{{ asset('admin/profile/index') }}'"> --}}
            </div>
        </div>
    </div>
@endsection
