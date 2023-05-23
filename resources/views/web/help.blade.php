@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"
        style="background-image: url('{{ asset('assets/bgim/help.png') . '?v=' . filemtime(public_path('assets/bgim/announcement.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-navy font-weight-bold">How to Play</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Announcements</a></li>
                        <li class="breadcrumb-item active">Index</li>
                    </ol> --}}
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-navy">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Details
                                </h3>
                            </div>
                            <div class="card-body">
                                <p>
                                    <b>Introduction:</b><br>
                                    Welcome to Codeworm! an exciting adventure that will test your skills and immerse you
                                    in a thrilling virtual world. Prepare yourself for an epic journey filled with
                                    challenges, mysteries, and endless fun. Are you ready to embark on this unforgettable
                                    adventure?
                                </p>
                                <p>
                                    <b>How to Play:</b><br>
                                    <ol>
                                        <li>Select play from the sidebar on the left side or Click <a href="{{ route('web.play.index') }}" target="_blank">here</a>.</li>
                                        <li>Select programming language you wish to challenge. For example here we want to challenge PHP.
                                            <br>
                                            <img src="{{ asset('assets/help/h1.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>Select stage For example here we want to challenge Stage 1.
                                            <br>
                                            <img src="{{ asset('assets/help/h2.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>Click start button
                                            <br>
                                            <img src="{{ asset('assets/help/h3.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                    </ol>
                                </p>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
