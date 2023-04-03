@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
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
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="https://ui-avatars.com/api/?name={{ Auth::user()->f_name }}+{{ Auth::user()->l_name }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ Auth::user()->f_name . ' ' . Auth::user()->l_name }}
                            </h3>

                            <p class="text-muted text-center">
                                Student
                                <br>
                                {{ Auth::user()->email }}
                            </p>

                            {{-- <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Followers</b> <a class="float-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Following</b> <a class="float-right">543</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Friends</b> <a class="float-right">13,287</a>
                                </li>
                            </ul>

                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Introduction</strong>

                            <p class="text-muted">
                                B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>

                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                            <p>
                                <span class="badge badge-info">UI Design</span>
                                <span class="badge badge-info">Coding</span>
                                <span class="badge badge-info">Javascript</span>
                                <span class="badge badge-info">PHP</span>
                                <span class="badge badge-info">Node.js</span>
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Elseware</strong>
                            <br>
                            <a class="text-info" href="#">Github</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
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
                                        action="{{ route('web.profile_update', Auth::user()->id) }}">
                                        @csrf
                                        {{-- So the system would know what email it would ignore because email must be unique --}}
                                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
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
                                        action="{{ route('web.profile_update', Auth::user()->id) }}">
                                        @csrf
                                        {{-- So the system would know what email it would ignore because email must be unique --}}
                                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                        {{-- So the system would know what kind of update you want to make --}}
                                        <input type="hidden" value="details" name="action">
                                        <div class="form-group row">
                                            <label for="inputFirsttName" class="col-sm-2 col-form-label">First
                                                Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputFirstName"
                                                    placeholder="First Name" name="f-name"
                                                    value="{{ Auth::user()->f_name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputMiddleName" class="col-sm-2 col-form-label">Middle
                                                Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputMiddleName"
                                                    placeholder="Middle Name" name="m-name"
                                                    value="{{ Auth::user()->m_name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputLastName" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputLastName"
                                                    placeholder="Last Name" name="l-name"
                                                    value="{{ Auth::user()->l_name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail"
                                                    placeholder="Email" name="email"
                                                    value="{{ Auth::user()->email }}">
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
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
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
