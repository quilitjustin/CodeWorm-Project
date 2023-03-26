@extends('layouts.admin')

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
                                                <a href="{{ route('users.show', encrypt($user['id'])) }}">
                                                    {{ $user['f_name'] . ' ' . $user['l_name'] }}
                                                </a>
                                            </td>
                                            <td class="text-center"><span class="badge bg-success">Active</span></td>
                                            <td class="d-none d-md-table-cell text-center">
                                                {{ $user['role'] }}</td>
                                            <td class="d-none d-xl-table-cell">
                                                <a class="text-link" href="{{ route('users.show', encrypt($user['id'])) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                <a class="text-success"
                                                    href="{{ route('users.edit', encrypt($user['id'])) }}">
                                                    <i class="fas fa-pen-square"></i> Edit</a>
                                                <form class="delete d-inline"
                                                    action="{{ route('users.destroy', encrypt($user['id'])) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger">
                                                        <i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <h5 class="text-center">No records</h5>
                                    @endforelse
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                            {{-- <div class="row mt-3"> --}}
                            {{-- Hide for mobile --}}
                            {{-- <div class="col-md-6 mb-2">
                                    Viewing {{ $users->firstItem() }} - {{ $users->lastItem() }} of {{ $users->total() }}
                                    entries.
                                </div>
                                <div class="col-md-6">
                                    {{ $users->onEachSide(3)->links() }}
                                </div> --}}
                            {{-- </div> --}}
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
        <div class="modal fade" id="confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm Deletion</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Are you sure you want to delete this record?
                            <br>
                            Important Reminder: Deleting records are extremely risky and not recommended.
                        </p>

                        <div class="form-group">
                            <label>
                                If you understand the risks and still wish to proceed.
                                <br>
                                Please type "I understand"
                            </label>
                            <input class="form-control" type="text" id="confirmation" placeholder="Please confirm" />
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-light">Confirm</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".delete").submit(function(e) {
                e.preventDefault();
                $("#confirm-delete").modal("show");
                const route = $(this).attr("action");
                const type = $(this).attr("method");
                const data = $(this).serialize();
                $.ajax({
                    url: route,
                    type: type,
                    data: data,
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
            $(function() {
                $("#data-table").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "copy", "csv", "excel", "pdf", "print"
                    "buttons": [{
                            "extend": "copyHtml5",
                            "title": "Export Data",
                            "exportOptions": {
                                "columns": [0, 1, 2]
                            }
                        },
                        {
                            "extend": "csvHtml5",
                            "title": "Export Data",
                            "exportOptions": {
                                "columns": [0, 1, 2]
                            }
                        },
                        {
                            "extend": "excelHtml5",
                            "title": "Export Data",
                            "exportOptions": {
                                "columns": [0, 1, 2]
                            }
                        },
                        {
                            "extend": "pdfHtml5",
                            "title": "Export Data",
                            "exportOptions": {
                                "columns": [0, 1, 2],
                            }
                        },
                        {
                            "extend": "print",
                            "title": "Export Data",
                            "exportOptions": {
                                "columns": [0, 1, 2]
                            }
                        },
                    ]
                }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');
            });
        });
    </script>
@endsection
