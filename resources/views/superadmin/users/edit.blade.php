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
                        <li class="breadcrumb-item active">Update</li>
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
                                <li class="nav-item"><a class="nav-link" href="#security" data-toggle="tab">Security</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="profile">

                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="security">
                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('users.update', $user['id']) }}">
                                        @csrf
                                        @method('PUT')
                                        {{-- So the system would know what email it would ignore because email must be unique --}}
                                        <input type="hidden" name="id" value="{{ $user['id'] }}">
                                        {{-- So the system would know what kind of update you want to make --}}
                                        <input type="hidden" value="password" name="action">
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Password">
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
                                        action="{{ route('users.update', $user['id']) }}">
                                        @csrf
                                        @method('PUT')
                                        {{-- So the system would know what email it would ignore because email must be unique --}}
                                        <input type="hidden" name="id" value="{{ $user['id'] }}">
                                        {{-- So the system would know what kind of update you want to make --}}
                                        <input type="hidden" value="details" name="action">
                                        <div class="form-group row">
                                            <label for="inputFirsttName" class="col-sm-2 col-form-label">First
                                                Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputFirstName"
                                                    placeholder="First Name" name="f-name"
                                                    value="{{ old('f-name', $user['f_name']) }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputMiddleName" class="col-sm-2 col-form-label">Middle
                                                Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputMiddleName"
                                                    placeholder="Middle Name" name="m-name"
                                                    value="{{ old('m-name', $user['m_name']) }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputLastName" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputLastName"
                                                    placeholder="Last Name" name="l-name"
                                                    value="{{ old('l-name', $user['l_name']) }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail"
                                                    placeholder="Email" name="email"
                                                    value="{{ old('email', $user['email']) }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputType" class="col-sm-2 col-form-label">Type of Account</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="inputType" name="role">
                                                    <option selected="selected">user</option>
                                                    <option>admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- /.form-group -->
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
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                        <div class="card-footer">
                            <button id="cancel" type="button" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</button>
                        </div>
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
