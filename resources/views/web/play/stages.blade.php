@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"
        style="background-image: url('{{ asset('assets/bgim/play.png') }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-navy font-weight-bold">Stages </h1>
                        <h6 class="font-size-5 text-danger">Note: You need to complete all stage to be qualified to compete
                            for leaderboards.</h6>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('stages.index') }}">stage</a></li>
                        <li class="breadcrumb-item active">Index</li>
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
                    <div class="col-12 px-5">
                        <div class="row">
                            @forelse ($stages as $stage)
                                <div class="col-md-6 p-2" style="position: relative;">
                                    <a href="{{ route('web.play.start', $stage->encrypted_id) }}">
                                        <img src="{{ asset($stage->bgim->path) }}" alt="img"
                                            style="max-width: 100%; max-height: 100%;">
                                        <h3 class="text-dark font-weight-bold"
                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-shadow: 2px 2px 0px #FFFFFF;">
                                            {{ $stage->name }}<br><span>{{ is_null($stage->game_records_users) ? '' : $stage->game_records_users[0]->record }}</span></h3>
                                    </a>
                                </div>
                            @empty
                                <h5 class="text-center">No stages available</h5>
                            @endforelse
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('scripts')
    <script>
        // Code Goes here	
    </script>
@endsection
