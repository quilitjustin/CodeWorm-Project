@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center p-3"
        style="height: 100%; min-height: 100vh; background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.9)), url('{{ asset('assets/bgim/leaderboard.png') . '?v=' . filemtime(public_path('assets/bgim/leaderboard.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center text-light mt-4">
                    <h1 class="font-weight-bold">
                        Email Verification Success!</h1>
                    <p class="lead">
                        You're almost there! Just wait for the email notification confirming your registration request has been accepted by the admin, and you'll be good to go!
                    </p>
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



