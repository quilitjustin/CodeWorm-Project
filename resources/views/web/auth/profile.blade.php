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
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/play">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
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
                                    <form action="{{ route('web.profile_update', Auth::user()->encrypted_id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="picture">
                                        <span class="text-muted">Changes to your photo will be reflected across your
                                            account.</span>
                                        <div class="form-group">
                                            <label>Profile Picture</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image"
                                                        name="image" accept="image/*">
                                                    <label class="custom-file-label" for="image"
                                                        aria-describedby="inputGroupFileAddon02">Choose Image</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <button type="button" id="clear"
                                                        class="btn btn-outline-secondary">Clear</button>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="card p-2">
                                                    <label for="img-preview">Preview</label>
                                                    <img src="{{ !is_null(Auth::user()->profile_picture) ? asset(Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . Auth::user()->f_name . '+' . Auth::user()->l_name }}"
                                                        id="img-preview"
                                                        style="width: 150px; height: 150px; max-width: 150px; max-height: 150px;"
                                                        class="img-fluid img-circle mx-auto" alt="preview">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="cancel btn btn-warning mr-1">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div id="name" class="d-none">
                                    <form action="{{ route('web.profile_update', Auth::user()->encrypted_id) }}"
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
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div id="email" class="d-none">
                                    <form action="{{ route('web.profile_update', Auth::user()->encrypted_id) }}"
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
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div id="password" class="d-none">
                                    <form action="{{ route('web.profile_update', Auth::user()->encrypted_id) }}"
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
                                            <button type="submit" class="btn btn-primary">Submit</button>
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

        const imageFile = $("#image");
        const preview = $("#img-preview");

        imageFile.on("change", function(e) {
            // Replace label inside input 
            const fileName = $(this).val();
            $(this).next(".custom-file-label").html(fileName);

            // Show image preview
            const item = e.target.files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                preview.attr("src", reader.result);
                preview.removeClass("d-none");
            }, false);

            if (item) {
                reader.readAsDataURL(item);
            }
        });

        $("#clear").click(function() {
            imageFile.val("");
            imageFile.next(".custom-file-label").html("Choose Image");
            preview.addClass("d-none");
            preview.attr("src", "#");
        });

        $(document).ready(function() {
            $("form").on("submit", function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                const route = $(this).attr("action");
                $.ajax({
                    url: route,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        console.log(response);
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
