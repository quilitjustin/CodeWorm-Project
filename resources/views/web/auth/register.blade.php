@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center"
        style="height: 100vh; background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), url('{{ asset('assets/bgim/login.png') . '?v=' . filemtime(public_path('assets/bgim/login.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">


        <div class="card rounded shadow-sm">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form id="registration-form" action="{{ route('web.auth.request') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="First name" name="f_name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Middle name (Optional)" name="m_name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Last name" name="l_name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
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
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Retype password"
                            name="password_confirmation">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="school_id"
                                accept="image/*">
                            <label class="custom-file-label" for="image" aria-describedby="inputGroupFileAddon02">School
                                ID</label>
                        </div>
                        <div class="input-group-append">
                            <button type="button" id="clear" class="btn btn-outline-secondary">Clear</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#" id="terms">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button id="submit-btn" type="submit" class="btn btn-primary btn-block mb-2">Register</button>
                        </div>
                        <div class="col-12 text-center">
                            <a href="{{ route('web.login') }}">Login</a> |
                            <a href="{{ route('password.forgot') }}">Forgot Password?</a>
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
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>

    <div class="modal fade" id="terms-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Terms and Conditions</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>By using this website, you agree to be bound by the following terms and conditions:</p>
                    <ol>
                        <li>You agree to comply with all applicable laws and regulations</li>
                        <li>You agree not to use the website for any unlawful purpose.</li>
                        <li>You agree not to harass, intimidate, or otherwise abuse any other user.</li>
                        <li>You agree not to upload, post, or transmit any content that infringes on the rights of
                            others.
                        </li>
                        <li>You agree not to use the website to distribute spam or other unsolicited messages.</li>
                        <li>You agree not to engage in any activity that could damage or disrupt the website or its
                            servers.
                        </li>
                        <li>You agree to be responsible for maintaining the confidentiality of your account information.
                        </li>
                        <li>You agree to notify us immediately if you become aware of any unauthorized use of your
                            account.
                        <li>You acknowledge and agree that your account may be terminated or suspended at any time for
                            any
                            reason, including but not limited to repeated denials of registration by the site administrator.
                            In
                            such
                            cases, the email address associated with your account may be permanently banned from use on the
                            site.</li>
                    </ol>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="confirm-btn" type="button" class="btn btn-primary">Confirm</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('script')
    <script>
        const imageFile = $("#image");

        imageFile.on("change", function(e) {
            // Replace label inside input 
            const fileName = $(this).val();
            $(this).next(".custom-file-label").html(fileName);
        });

        $("#clear").click(function() {
            imageFile.val("");
            imageFile.next(".custom-file-label").html("Choose Image");
        });

        $("#terms").click(function() {
            $("#terms-modal").modal("show");
        });

        $("#registration-form").on("submit", function(e){
            $("#submit-btn").prop("disabled", true); 
        });
    </script>
@endsection
