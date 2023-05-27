@extends('layouts.app')

@section('content')
    <div class="p-3" style="height: 100%; min-height: 100vh; background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.9)), url('{{ asset('assets/bgim/leaderboard.png') . '?v=' . filemtime(public_path('assets/bgim/leaderboard.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-light font-weight-bold">Portfolio</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        {{-- <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"></li>
                    <li class="breadcrumb-item active"></li>
                </ol> --}}
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
                                        src="{{ !is_null($user->profile_picture) ? asset($user->profile_picture) : 'https://ui-avatars.com/api/?name=' . $user->f_name . '+' . $user->l_name }}"
                                        alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ $user['f_name'] . ' ' . $user['l_name'] }}
                                </h3>

                                <p class="text-muted text-center">
                                    {{ $user->role == 'user' ? 'student' : $user->role }}
                                    <br>
                                    {{ $user['email'] }}
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
                        {{-- <div class="card card-primary">
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
                        </div> --}}
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#badges"
                                            data-toggle="tab">Badges</a>
                                    </li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="badges">
                                        <div class="row">
                                            @forelse ($user->badges as $badge)
                                                <div class="col-4 p-3">
                                                    <img src="{{ asset($badge->path) }}"
                                                        class="rounded mx-auto d-block border border-secondary"
                                                        alt="preview" style="height: 150px; max-height: 150px;">
                                                    <div class="text-center">
                                                        <h3 class="font-weight-bold">{{ $badge->name }}</h3>
                                                        <span>Date Earned:
                                                            {{ $badge->created_at }}</span>
                                                    </div>
                                                </div>
                                            @empty
                                                This user doesn't have badge yet.
                                            @endforelse
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <a href="{{ route('web.profile') }}" class="btn btn-dark">
                            <i class="right fas fa-angle-left"></i> Go
                            Back</a>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <script>
        // Code Goes here	
    </script>
@endsection
