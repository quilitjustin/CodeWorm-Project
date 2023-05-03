@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
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
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
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
                                            <label>Middle Name</label>
                                            <p>{{ $user->m_name }}</p>
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
                                            <label>Status</label>
                                            <p>{{ $user->status }}</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <hr class="border border-primary w-100">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Created By</label>
                                            <br>
                                            <a
                                                href="{{ is_null($user->created_by_user) ? '#' : route('super.users.show', $user->created_by_user->encrypted_id) }}">{{ is_null($user->created_by_user) ? '' : $user->created_by_user->f_name . ' ' . $user->created_by_user->l_name }}</a>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Date Created</label>
                                            <br>
                                            <p>{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Updated By</label>
                                            <br>
                                            {{-- Because updated_by can have null value, we must first check if the value is null to avoid error --}}
                                            <a
                                                href="{{ is_null($user->updated_by_user) ? '#' : route('super.users.show', $user->updated_by_user->encrypted_id) }}">{{ is_null($user->updated_by_user) ? '' : $user->updated_by_user->f_name . ' ' . $user->updated_by_user->l_name }}</a>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Date Updated</label>
                                            <br>
                                            <p>{{ is_null($user->updated_by) ? '' : \Carbon\Carbon::parse($user->updated_at)->diffForHumans() }}
                                            </p>
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
                            <button id="cancel" type="button" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</button>
                            <a href="{{ route('super.users.edit', $user->encrypted_id) }}"
                                class="btn btn-primary ml-2">Update</a>
                            <form class="ban d-inline" action="{{ route('super.user.ban', $user->encrypted_id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline-warning ml-2">Ban</button>
                            </form>
                            <form class="delete d-inline" action="{{ route('super.users.destroy', $user->encrypted_id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ml-2">Delete</button>
                            </form>
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
    <div class="modal fade" id="confirm-ban">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Ban</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to ban this user?
                        <br>
                        Important Reminder: Banning user means that he/she won't be able to use this account until the ban is lifted.
                    </p>
                    <div class="form-group">
                        <label>Ban Duration</label>
                        <select class="form-control select2" style="width: 100%;" id="ban-duration" name="duration">
                            <option>hour</option>
                            <option>day</option>
                            <option>week</option>
                            <option>month</option>
                            <option>year</option>
                            <option>Until I change it</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>
                            If you understand but still wish to proceed.
                            <br>
                            Please type "<span id="condition-ban">I understand</span>"
                        </label>
                        <input class="form-control" type="text" id="confirmation-ban" placeholder="Please confirm" />
                        <span id="err-msg-ban"></span>
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button id="confirm-btn-ban" type="button" class="btn btn-outline-light">Confirm</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
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

        let ban_form = "";
        $(".ban").submit(function(e) {
            e.preventDefault();
            $("#err-msg-ban").text("");
            $("#confirmation-ban").val("")
            $("#confirm-ban").modal("show");
            ban_form = $(this);
        });
        $("#confirm-btn-ban").click(function() {
            const answer = $("#confirmation-ban").val();
            const condition = $("#condition-ban").text();
            if (answer == condition) {
                ban_form.unbind().submit();
                $("#confirm-ban").modal("hide");

            } else {
                $("#err-msg-ban").text("Incorrect, please try again.");
            }
        });
    </script>
@endsection
