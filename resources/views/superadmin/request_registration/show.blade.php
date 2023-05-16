@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Registration Request</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.request_registration.index') }}">Requests</a>
                        </li>
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
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="card card-navy">
                        <div class="card-header">
                            <h3 class="card-title">
                                Registration Request Details
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>First Name</label>
                                    <p>{{ $reqreg->users->f_name }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <label>First Name</label>
                                    <p>{{ $reqreg->users->l_name }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <label>First Name</label>
                                    <p>{{ $reqreg->users->email }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <label>Status</label>
                                    <p>{{ $reqreg->status }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-12">
                                    <hr class="border border-primary w-100">
                                </div>

                                <div class="col-md-3">
                                    <label>Date Requested</label>
                                    <br>
                                    <p>{{ \Carbon\Carbon::parse($reqreg->created_at)->diffForHumans() }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Updated</label>
                                    <br>
                                    <p>{{ \Carbon\Carbon::parse($reqreg->updated_at)->diffForHumans() }}
                                    </p>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            <button id="cancel" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back
                            </button>
                            @if ($reqreg->status == 'pending')
                                <form class="registration-update-form" action="{{ route('super.request_registration.update', $reqreg->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="decision" value="approved">
                                    <button class="btn btn-success">Approve</button>
                                </form>
                                <form class="registration-update-form" action="{{ route('super.request_registration.update', $reqreg->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="decision" value="deny">
                                    <button class="btn btn-danger">Deny</button>
                                </form>
                            @endif
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card p-2">
                        <label for="img-preview">School ID Provided</label>
                        <img src="{{ asset($reqreg->school_id) }}" id="img-preview" class="img-fluid" alt="preview">
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

@section('script')
    @include('layouts.superadmin.inc_delete')
    <script>
        $("#cancel").click(function(){
            window.location.href = "{{ route('super.request_registration.index') }}";
        });

        $(".registration-update-form").on("submit", function(e) {
            $(".registration-update-form").find("button").prop("disabled", true);
            $("#cancel").prop("disabled", true);
        });
    </script>
@endsection
