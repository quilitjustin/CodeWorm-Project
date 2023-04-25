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
                        <h1 class="m-0 text-navy font-weight-bold">Stages
                        </h1>
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
                            @php
                                $condition = 0;
                            @endphp
                            @forelse ($stages as $stage)
                                @php
                                    if (empty($stage->game_records_users[0])) {
                                        $condition++;
                                    }
                                @endphp
                                @if ($condition < 2)
                                    <div class="col-md-6 p-2" style="position: relative; max-height: 150px">
                                        <a href="{{ route('web.play.start', $stage->encrypted_id) }}">
                                            <img src="{{ asset($stage->bgim->path) }}" alt="img" class="img-fluid"
                                                style="box-shadow: 10px 10px 5px #ccc;
      -moz-box-shadow: 10px 10px 5px #ccc;
      -webkit-box-shadow: 10px 10px 5px #ccc;
      -khtml-box-shadow: 10px 10px 5px #ccc;">
                                            <h3 class="text-dark font-weight-bold"
                                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-shadow: 2px 2px 0px #FFFFFF;">
                                                {{ $stage->name }}<br><span>{{ empty($stage->game_records_users[0]) ? '' : $stage->game_records_users[0]->record }}</span>
                                            </h3>
                                        </a>
                                    </div>
                                @else
                                    <div class="col-md-6 p-2" style="position: relative; filter: brightness(50%);">
                                        <a href="#">
                                            <img src="{{ asset($stage->bgim->path) }}" alt="img"
                                                style="max-width: 100%; max-height: 100%; box-shadow: 10px 10px 5px #ccc;
      -moz-box-shadow: 10px 10px 5px #ccc;
      -webkit-box-shadow: 10px 10px 5px #ccc;
      -khtml-box-shadow: 10px 10px 5px #ccc;">
                                            <h3 class="text-dark font-weight-bold"
                                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-shadow: 2px 2px 0px #FFFFFF;">
                                                Locked</h3>
                                        </a>
                                    </div>
                                @endif
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
