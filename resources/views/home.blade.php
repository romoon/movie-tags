@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    ログインしました！
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <input type="button" value="動画の登録" onClick="location.href='{{ asset('user/movie/create') }}'">
            <input type="button" value="登録動画の一覧" onClick="location.href='{{ asset('user/movie/index') }}'">
        </div>
    </div>
</div>
@endsection
