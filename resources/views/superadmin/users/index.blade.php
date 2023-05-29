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
                        <li class="breadcrumb-item active">Index</li>
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
                <div class="col-12">
                    <div class="card card-navy">
                        <div class="card-header">
                            <h3 class="card-title">List of Current Users</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('super.users.show', $user->encrypted_id) }}">
                                                    {{ $user->f_name . ' ' . $user->l_name }}
                                                </a>
                                            </td>
                                            <td class="text-center"><span
                                                    class="badge {{ is_null($user->suspended_until) ? 'bg-success' : 'bg-danger' }}">{{ is_null($user->suspended_until) ? 'active' : 'suspended' }}</span>
                                            </td>
                                            <td class="">
                                                <a class="text-link"
                                                    href="{{ route('super.users.show', $user->encrypted_id) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                @if (is_null($user->suspended_until))
                                                    <form class="suspend d-inline"
                                                        action="{{ route('super.users.suspend', $user->encrypted_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="text-danger">
                                                            <i class="fas fa-ban"></i> Suspend</button>
                                                    </form>
                                                @else
                                                    <form class="activate d-inline"
                                                        action="{{ route('super.users.activate', $user->encrypted_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="text-success">
                                                            <i class="fas fa-plus"></i> Activate</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        {{-- <div class="card-footer clearfix">
                            <a href="{{ route('super.users.create') }}" class="btn btn-primary">Create New User</a>
                        </div> --}}
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
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
    @include('layouts.superadmin.index_component')
@endsection
