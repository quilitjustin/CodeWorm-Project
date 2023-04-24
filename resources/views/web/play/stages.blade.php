@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-image: url('{{ asset('assets/bgim/play.png') }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stages </h1>
                        <h6 class="font-size-5 text-danger">Note: You need to complete all stage to be qualified to compete for leaderboards.</h6>
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
                            {{-- <div class="col-md-4 p-2">
                            <a href="{{ route('web.play.php') }}"
                                class="btn btn-secondary w-100 py-3">PHP</a>
                        </div>
                        <div class="col-md-4 p-2">
                            <a href="{{ route('web.play.js') }}"
                                class="btn btn-secondary w-100 py-3">Javascript</a>
                        </div> --}}
                            @forelse ($stages as $stage)
                                <div class="col-md-4 p-2">
                                    <a href="{{ route('web.play.start', $stage->encrypted_id) }}"
                                        class="btn btn-dark w-100 py-3">{{ $stage->name }}</a>
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
