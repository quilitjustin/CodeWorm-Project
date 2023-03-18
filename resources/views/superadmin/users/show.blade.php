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
                        <li class="breadcrumb-item"><a href="/users">Users</a></li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#profile"
                                        data-toggle="tab">Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="profile">

                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>First Name</label>
                                            <br>
                                            <p>{{ $user['f_name'] }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Middle Name</label>
                                            <br>
                                            <p>{{ $user['m_name'] }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Last Name</label>
                                            <br>
                                            <p>{{ $user['l_name'] }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Email</label>
                                            <br>
                                            <p>{{ $user['email'] }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Type of Account</label>
                                            <br>
                                            <p>{{ $user['role'] }}</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <hr class="border border-primary w-100">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Created By</label>
                                            <br>
                                            <a
                                                href="{{ route('users.show', $user['created_by']) }}">{{ $user['created_by'] }}</a>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Date Created</label>
                                            <br>
                                            <p>{{ \Carbon\Carbon::parse($user['created_at'])->diffForHumans() }}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Updated By</label>
                                            <br>
                                            {{-- Because updated_by can have null value, we must first check if the value is null to avoid error --}}
                                            <a
                                                href="{{ is_null($user['updated_by']) ? '#' : route('users.show', $user['updated_by']) }}">{{ $user['updated_by'] }}</a>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Date Updated</label>
                                            <br>
                                            <p>{{ is_null($user['updated_by']) ? '' : \Carbon\Carbon::parse($user['updated_at'])->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            <button id="cancel" type="button" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</button>
                            <a href="{{ route('users.edit', $user['id']) }}" class="btn btn-primary">Update</a>
                            <form class="d-inline" action="{{ route('users.destroy', $user['id']) }}" method="POST"
                                onsubmit="return confirm('You are about to delete User ID: {{ $user['id'] }}s record. \n Are you sure?');">
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
@endsection

@section('script')
    <script>
        $("#cancel").click(function() {
            window.history.back();
        });
    </script>
@endsection