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
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
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
                    <div class="card card-indigo">
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
                                        <th class="d-none d-md-table-cell">Type</th>
                                        <th class="d-none d-xl-table-cell">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td class="text-center">
                                                <a href="{{ route('users.show', $user->encrypted_id) }}">
                                                    {{ $user['f_name'] . ' ' . $user['l_name'] }}
                                                </a>
                                            </td>
                                            <td class="text-center"><span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}">{{ $user->status }}</span></td>
                                            <td class="d-none d-md-table-cell text-center">
                                                {{ $user['role'] }}</td>
                                            <td class="d-none d-xl-table-cell">
                                                <a class="text-link" href="{{ route('users.show', $user->encrypted_id) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                <a class="text-success" href="{{ route('users.edit', $user->encrypted_id) }}">
                                                    <i class="fas fa-pen-square"></i> Edit</a>
                                                <form class="ban d-inline"
                                                    action="{{ route('super.user.ban', $user->encrypted_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-warning">
                                                        <i class="fas fa-ban"></i> Ban</button>
                                                </form>
                                                <form class="delete d-inline"
                                                    action="{{ route('users.destroy', $user->encrypted_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger">
                                                        <i class="fas fa-trash"></i> Delete</button>
                                                </form>
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
                        <div class="card-footer clearfix">
                            <a href="{{ route('users.create') }}" class="btn btn-primary">Create New User</a>
                        </div>
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
                            <option>forever</option>
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
    @include('layouts.superadmin.index_component')
    <script>
        $(document).ready(function() {
            let route = "";
            let data = "";
            $(".ban").submit(function(e) {
                e.preventDefault();
                $("#err-msg-ban").text("");
                $("#confirmation-ban").val("")
                $("#confirm-ban").modal("show");
                route = $(this).attr("action");
                data = $(this).serialize();
            });
            $("#confirm-btn-ban").click(function() {
                const answer = $("#confirmation-ban").val();
                const condition = $("#condition-ban").text();
                if (answer == condition) {
                    const duration = $("#ban-duration").val();
                    data+= "&duration=" + duration;
                    console.log(data)
                    $.post({
                        url: route,
                        data: data,
                        success: function(response) {
                            toastr.success(response.message);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                    // window.location.reload();
                    // toBeRemoved.remove();
                    $("#confirm-ban").modal("hide");
                   
                } else {
                    $("#err-msg-ban").text("Incorrect, please try again.");
                }
            });
        });
    </script>
@endsection
