@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
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
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#profile"
                                            data-toggle="tab">Profile</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#security" data-toggle="tab">Security</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#other" data-toggle="tab">Others</a>
                                    </li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="profile">
                                        <form class="form-horizontal" method="POST"
                                            action="{{ route('web.profile_update', Auth::user()->encrypted_id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            {{-- So the system would know what email it would ignore because email must be unique --}}
                                            <input type="hidden" name="id" value="{{ Auth::user()->encrypted_id }}">
                                            {{-- So the system would know what kind of update you want to make --}}
                                            <input type="hidden" value="picture" name="action">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Profile Picture</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group mb-3">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="image"
                                                                name="image" accept="image/*">
                                                            <label class="custom-file-label" for="image"
                                                                aria-describedby="inputGroupFileAddon02">Choose
                                                                Image</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button type="button" id="clear"
                                                                class="btn btn-outline-secondary">Clear</button>
                                                        </div>
                                                    </div>
                                                    @if ($errors->any())
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li class="text-danger">{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    <div>
                                                        <div class="card p-2">
                                                            <label for="img-preview">Preview</label>
                                                            <img src="{{ !is_null(Auth::user()->profile_picture) ? asset(Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . Auth::user()->f_name . '+' . Auth::user()->l_name }}"
                                                                id="img-preview"
                                                                style="width: 150px; height: 150px; max-width: 150px; max-height: 150px;"
                                                                class="img-fluid img-circle mx-auto" alt="preview">
                                                        </div>
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="security">
                                        <form class="form-horizontal" method="POST"
                                            action="{{ route('web.profile_update', Auth::user()->encrypted_id) }}">
                                            @csrf
                                            @method('PUT')
                                            {{-- So the system would know what email it would ignore because email must be unique --}}
                                            <input type="hidden" name="id" value="{{ Auth::user()->encrypted_id }}">
                                            {{-- So the system would know what kind of update you want to make --}}
                                            <input type="hidden" value="password" name="action">
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-2 col-form-label">Old Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="old-password"
                                                        name="old_password" placeholder="Old Password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-2 col-form-label">Re-Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="re-password"
                                                        name="password_confirmation" placeholder="Confirm Password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        @if ($errors->any())
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li class="text-danger">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="settings">
                                        <form class="form-horizontal" method="POST"
                                            action="{{ route('web.profile_update', Auth::user()->encrypted_id) }}">
                                            @csrf
                                            @method('PUT')
                                            {{-- So the system would know what email it would ignore because email must be unique --}}
                                            <input type="hidden" name="id"
                                                value="{{ Auth::user()->encrypted_id }}">
                                            {{-- So the system would know what kind of update you want to make --}}
                                            <input type="hidden" value="details" name="action">
                                            <div class="form-group row">
                                                <label for="inputFirsttName" class="col-sm-2 col-form-label">First
                                                    Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputFirstName"
                                                        placeholder="First Name" name="f-name"
                                                        value="{{ Auth::user()->f_name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputMiddleName" class="col-sm-2 col-form-label">Middle
                                                    Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputMiddleName"
                                                        placeholder="Middle Name" name="m-name"
                                                        value="{{ Auth::user()->m_name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputLastName" class="col-sm-2 col-form-label">Last
                                                    Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputLastName"
                                                        placeholder="Last Name" name="l-name"
                                                        value="{{ Auth::user()->l_name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="inputEmail"
                                                        placeholder="Email" name="email"
                                                        value="{{ Auth::user()->email }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        @if ($errors->any())
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li class="text-danger">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="other">
                                        <h5>Public Profile: </h5>
                                        <a class="btn btn-outline-primary" href="{{ route('public_profile.show', Auth::user()->encrypted_id) }}">Go and see</a>
                                    </div>
                                    <!-- /.tab-pane --
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
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
    </script>
@endsection
