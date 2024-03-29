@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center"
        style="height: 100vh; background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), url('{{ asset('assets/bgim/login.png') . '?v=' . filemtime(public_path('assets/bgim/login.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <div class="register-box">
            <div class="register-logo text-white font-weight-bold">
                Codeworm
            </div>

            <div class="card rounded shadow-sm">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form id="login-form" action="{{ route('web.authenticate') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                    <label for="agreeTerms">
                                        I agree to the <a href="#">terms</a>
                                    </label>
                                </div>
                            </div> --}}
                            <!-- /.col -->
                            <div class="col-12 text-center">
                                <button id="submit-btn" type="submit" class="btn btn-primary btn-block mb-2">Login</button>
                                <a href="{{ route('web.register') }}">Sign up</a> |
                                <a href="{{ route('password.forgot') }}" >Forgot Password?</a>
                            </div>
                            <!-- /.col -->
                            <div class="mt-3">
                                @if ($errors->any())
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="text-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                        </div>
                    </form>

                    {{-- <div class="social-auth-links text-center">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i>
                            Sign up using Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i>
                            Sign up using Google+
                        </a>
                    </div> --}}

                    {{-- <a href="login.html" class="text-center">I already have a membership</a> --}}
                </div>
                <!-- /.form-box -->
            </div><!-- /.card -->
        </div>
        <!-- /.register-box -->
    </div>
@endsection

@section('script')
<script>
    $("#login-form").on("submit", function(){
        $("#submit-btn").prop("disabled", true);
    });
</script>
@endsection
