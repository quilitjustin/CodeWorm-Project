@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center p-3"
        style="height: 100%; min-height: 100vh; background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.9)), url('{{ asset('assets/bgim/leaderboard.png') . '?v=' . filemtime(public_path('assets/bgim/leaderboard.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center text-light mt-4">
                    <h1 class="font-weight-bold">
                        Registration Success!</h1>
                    <p class="lead">
                        Please verify your email. Once that's done, the admin will review your request and determine whether to accept it or not.                    </p>
                </div>
            </div>
            <div class="col-sm-12">
                
            </div>
            <div class="col-sm-12 text-center">
                <a href="{{ route('web.login') }}" class="btn btn-outline-primary">
                    Go Back</a>
            </div>
            <!-- /.col -->
        </div>
    </div>
@endsection



