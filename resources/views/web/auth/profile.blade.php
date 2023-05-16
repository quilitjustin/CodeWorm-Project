@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-navy font-weight-bold">Profile</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-12">
                        <div class="card rounded shadow-sm">
                            <div class="card-body">
                                <table class="table table-hover" id="settings">
                                    <tbody>
                                        <tr data-target="#picture" class="settings-option">
                                            <th scope="row">Photo</th>
                                            <td>Add a personal touch to your account by uploading a photo.</td>
                                            <td><i class="fas fa-arrow-right"></i></td>
                                        </tr>
                                        <tr data-target="#name" class="settings-option">
                                            <th scope="row">Name</th>
                                            <td>{{ Auth::user()->f_name . ' ' . Auth::user()->l_name }}</td>
                                            <td><i class="fas fa-arrow-right"></i></td>
                                        </tr>
                                        <tr data-target="#email" class="settings-option">
                                            <th scope="row">Email</th>
                                            <td>{{ Auth::user()->email }}</td>
                                            <td><i class="fas fa-arrow-right"></i></td>
                                        </tr>
                                        <tr data-target="#password" class="settings-option">
                                            <th scope="row">Password</th>
                                            <td>********</td>
                                            <td><i class="fas fa-arrow-right"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div id="picture" class="d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('web.profile.upload_picture') }}">
                                                <div class="card p-3 d-flex justify-content-center align-items-center">
                                                    <div class="border border-primary rounded-circle d-flex align-items-center justify-content-center mb-3"
                                                        style="width:150px; height:150px;">
                                                        <i class="nav-icon fas fa-upload" style="font-size: 80px;"></i>
                                                    </div>
                                                    <p class="text-dark font-weight-bold">Upload Photo</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('web.profile.upload_picture') }}">
                                                <div class="card p-3 d-flex justify-content-center align-items-center">
                                                    <div class="border border-primary rounded-circle d-flex align-items-center justify-content-center mb-3"
                                                        style="width:150px; height:150px;">
                                                        <i class="nav-icon fas fa-upload" style="font-size: 80px;"></i>
                                                    </div>
                                                    <p class="text-dark font-weight-bold">Take a Photo</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="name" class="d-none">
                                    <form class="update-form" action="{{ route('web.profile_update', Auth::user()->encrypted_id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="name">
                                        <span class="text-muted">Changes to your name will be reflected across your
                                            account.</span>
                                        <div class="form-group mb-3">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" name="f_name"
                                                value="{{ old('f_name', Auth::user()->f_name) }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" name="l_name"
                                                value="{{ old('l_name', Auth::user()->l_name) }}">
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="cancel btn btn-warning mr-1">Cancel</button>
                                            <button type="submit" class="submit-btn btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div id="email" class="d-none">
                                    <form class="update-form" action="{{ route('web.profile_update', Auth::user()->encrypted_id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="email">
                                        <span class="text-muted">Changes to your email will be reflected across your
                                            account.</span>
                                        <div class="form-group mb-3">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ old('email', Auth::user()->email) }}">
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="cancel btn btn-warning mr-1">Cancel</button>
                                            <button type="submit" class="submit-btn btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div id="password" class="d-none">
                                    <form class="update-form" action="{{ route('web.profile_update', Auth::user()->encrypted_id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="password">
                                        <span class="text-muted">Changes to your password will be reflected across your
                                            account.</span>
                                        <div class="form-group mb-3">
                                            <label>Old Password</label>
                                            <input type="password" class="form-control" name="old_password"
                                                value="{{ old('old_password', '') }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password"
                                                value="{{ old('password', '') }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                value="{{ old('password_confirmation', '') }}">
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="cancel btn btn-warning mr-1">Cancel</button>
                                            <button type="submit" class="submit-btn btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="form-group">
                                    <ul id="errors">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".settings-option").click(function() {
                const target = $(this).data("target");
                $("#settings").fadeOut("slow", function() {
                    $(target).removeClass("d-none").fadeIn("fast");
                });
            });

            $(".cancel").click(function() {
                const target = $(this).parent().parent().parent();
                $(target).fadeOut("slow", function() {
                    $("#settings").fadeIn("fast");
                });
            });

            $(".update-form").on("submit", function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                const route = $(this).attr("action");
                $.ajax({
                    url: route,
                    type: 'PUT',
                    data: formData,
                    beforeSend: function() {
                         $(".submit-btn").prop("disabled", true);
                    },
                    complete: function() {
                         $(".submit-btn").prop("disabled", false);
                    },
                    success: function(response) {
                        toastr.success(response.msg);
                    },
                    error: function(xhr, errorThrown) {
                        $("#errors").empty();
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $("#errors").append("<li class='text-danger'>" + value +
                                "</li>");
                        });
                    }
                });
            });
        });
    </script>
@endsection
