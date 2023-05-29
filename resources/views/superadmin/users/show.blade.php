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
                                <li class="nav-item"><a class="nav-link" href="#request" data-toggle="tab">Registration
                                        Data</a>
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
                                            <label class="d-block">Status</label>
                                            <p
                                                class="badge {{ is_null($user->suspended_until) ? 'bg-success' : 'bg-danger' }}">
                                                {{ is_null($user->suspended_until) ? 'Active' : 'Suspended' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="request">
                                    <div class="mb-3">
                                        <label>Date Accepted: </label>
                                        <p>{{ $user->request_registrations->updated_at->format('Y-m-d H:i:s') }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label>School ID: </label>
                                        <img src="{{ asset($user->request_registrations->school_id) }}" alt="school id" class="img-fluid">
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
                            <a href="{{ route('super.users.index') }}" class="btn btn-warning mr-2"><i
                                    class="right fas fa-angle-left"></i> Go Back</a>
                            @if (is_null($user->suspended_until))
                                <form class="suspend d-inline"
                                    action="{{ route('super.users.suspend', $user->encrypted_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger">Suspend</button>
                                </form>
                            @else
                                <form class="activate d-inline"
                                    action="{{ route('super.users.suspend', $user->encrypted_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Activate</button>
                                </form>
                            @endif
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
    <div class="modal fade" id="confirm-suspend">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Suspension</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to suspend this user?
                        <br>
                        Please specify the reason.
                    </p>

                    <div class="form-group">
                        <input class="form-control" type="text" id="reason" placeholder="Reason" />
                        <span id="err-suspend-msg"></span>
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button id="confirm-suspension-btn" type="button" class="btn btn-outline-light">Confirm</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="confirm-activate">
        <div class="modal-dialog">
            <div class="modal-content bg-success">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Activation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to activate this user again?
                    </p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button id="confirm-activate-btn" type="button" class="btn btn-outline-light">Confirm</button>
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
        $(document).ready(function() {
            let route = "";
            let data = "";
            $(".suspend").submit(function(e) {
                e.preventDefault();
                $("#err-msg").text("");
                $("#confirm-suspend").modal("show");
                route = $(this).attr("action");
                data = $(this).serialize();
            });
            $("#confirm-suspension-btn").click(function() {
                $(this).prop("disabled", true);
                const reason = $("#reason").val();
                if (reason) {
                    $("#loading-modal").modal("show");
                    $.ajax({
                        url: route,
                        method: "PUT",
                        data: data + "&reason=" + reason,
                        success: function(response) {
                            toastr.success("Updated Successfully");
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        },
                    });
                } else {
                    $("#err-suspend-msg").text("Reason is required.");
                }
            });

            $(".activate").click(function(e) {
                e.preventDefault();
                route = $(this).attr("action");
                data = $(this).serialize();
                $("#confirm-activate").modal("show");
            });

            $("#confirm-activate-btn").click(function() {
                $(this).prop("disabled", true);
                $("#loading-modal").modal("show");
                $.ajax({
                    url: route,
                    method: "PUT",
                    data: data,
                    success: function(response) {
                        toastr.success("Updated Successfully");
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    },
                });
            });
        });
    </script>
@endsection
