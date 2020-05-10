@extends('layouts.admin')

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

                        Admin logged in!
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <input type="button" value="User Profile 一覧に戻る" onClick="location.href='{{ asset('admin/index') }}'">
            </div>
        </div>
    </div>
@endsection
