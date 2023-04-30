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
                        <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Programming Language</h1>
                        <i class="fas fa-question-circle d-inline" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Hello"></i>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                     
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
                            @forelse ($proglangs as $proglang)
                                <div class="col-md-4 p-2">
                                    <a href="{{ route('web.play.stages', $proglang->encrypted_id) }}"
                                        class="btn btn-dark w-100 py-3">{{ $proglang->name }}</a>
                                </div>
                            @empty
                                <h5 class="text-center">No records</h5>
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
