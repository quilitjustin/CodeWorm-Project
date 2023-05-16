@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Registration Requests</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.request_registration.index') }}">Registration</a></li>
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
                            <h3 class="card-title">List of Current Registration Requests</h3>
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
                                    @forelse ($reqregs as $reqreg)
                                        <tr>
                                            <td>
                                                <a href="{{ route('super.request_registration.show', $reqreg->id) }}">
                                                    {{ $reqreg->users->email }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $reqreg->status == 'pending' ? 'bg-secondary' : ($reqreg->status == 'accepted' ? 'bg-success' : 'bg-danger') }}">{{ $reqreg->status }}</span>
                                            </td>
                                            <td class="">
                                                <a class="text-link"
                                                    href="{{ route('super.request_registration.show', $reqreg->id) }}">
                                                    <i class="far fa-eye"></i> View
                                                </a>
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
                    <h4 class="modal-title">Confirm Deletion</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to suspend this Registration Request?
                        <br>
                        Please specify the reason.
                    </p>

                    <div class="form-group">
                        <input class="form-control" type="text" id="reason" placeholder="Reason" />
                        <span id="err-msg"></span>
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button id="confirm-btn" type="button" class="btn btn-outline-light">Confirm</button>
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
            $(".suspend").submit(function(e) {
                e.preventDefault();
                $("#err-msg").text("");
                $("#confirmation").val("")
                $("#confirm-suspend").modal("show");
                route = $(this).attr("action");
                data = $(this).serialize();
                // Select the parent <tr>
                toBeRemoved = $(this).parent().parent();
            });
            $("#confirm-btn").click(function() {
                const reason = $("#reason").val();
                if (reason) {
                    $.ajax({
                        url: route,
                        method: "PUT",
                        data: data + "&reason=" + reason,
                        beforeSend: function() {

                        },
                        complete: function() {
                            window.location.reload();
                        },
                        success: function(response) {
                            toastr.success("Updated Successfully");
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                    // window.location.reload();
                    // toBeRemoved.remove();
                } else {
                    $("#err-msg").text("Reason is required.");
                }
            });
        });
    </script>
@endsection
