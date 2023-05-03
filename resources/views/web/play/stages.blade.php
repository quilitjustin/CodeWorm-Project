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
                        <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Stages</h1>
                        <i class="fas fa-question-circle d-inline" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="You need to complete all stage to be able to compete for the leaderboards<br>Here you would be able to see your best time for all stage so you would be able to know in where stage you would want to grind"></i>      
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
                                    <div class="col-md-6 p-2" style="position: relative;">
                                        <a href="{{ route('web.play.start', $stage->encrypted_id) }}">
                                            <img src="{{ asset($stage->bgim->path) }}" alt="img"
                                                style="width:100%; max-width: 100%; height: 200px; max-height: 200px; box-shadow: 10px 10px 5px #ccc; -moz-box-shadow: 10px 10px 5px #ccc; -webkit-box-shadow: 10px 10px 5px #ccc; -khtml-box-shadow: 10px 10px 5px #ccc;">
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
                                                style="width:100%; max-width: 100%; height: 200px; max-height: box-shadow: 10px 10px 5px #ccc;
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

@section('script')
    <script>
        // From bootstrap documentation
        // https://getbootstrap.com/docs/5.1/components/tooltips/
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
@endsection
