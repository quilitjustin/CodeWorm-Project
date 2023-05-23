@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                     <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Show</li>
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
                    <div class="card card-navy">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#profile"
                                        data-toggle="tab">Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Details</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#other" data-toggle="tab">Others</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="profile">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="d-block">Profile Picture</label>
                                            <img src="{{ !is_null($user->profile_picture) ? asset($user->profile_picture) : 'https://ui-avatars.com/api/?name=' . $user->f_name . '+' . $user->l_name }}"
                                                alt="profile picture"
                                                style="width: 150px; height: 150px; max-width: 150px; max-height: 150px;"
                                                class="img-fluid img-circle d-block mx-auto" alt="preview">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>First Name</label>
                                            <p>{{ $user->f_name }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Last Name</label>
                                            <p>{{ $user->l_name }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Email</label>
                                            <p>{{ $user->email }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Role</label>
                                            <p>{{ $user->role }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="d-block">Status</label>
                                            <p class="badge {{ is_null($user->suspended_until) ? 'bg-success' : 'bg-danger' }}">{{ is_null($user->suspended_until) ? 'Active' : 'Suspended' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="other">
                                    <h5>Public Profile: </h5>
                                    <a class="btn btn-outline-primary"
                                        href="{{ route('public_profile.show', $user->encrypted_id) }}">Go and see</a>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('super.users.index') }}" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('script')
    @include('layouts.superadmin.inc_component')
    @include('layouts.superadmin.inc_delete')
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
