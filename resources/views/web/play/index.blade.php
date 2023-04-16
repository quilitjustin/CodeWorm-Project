@extends('layouts.web.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Programming Language</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('proglangs.index') }}">ProgLang</a></li>
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
                        <div class="col-md-4 p-2">
                            <a href="{{ route('web.play.php') }}"
                                class="btn btn-secondary w-100 py-3">PHP</a>
                        </div>
                        <div class="col-md-4 p-2">
                            <a href="{{ route('web.play.js') }}"
                                class="btn btn-secondary w-100 py-3">Javascript</a>
                        </div>
                        {{-- @forelse ($proglangs as $proglang)
                            <div class="col-md-4 p-2">
                                <a href="{{ route('web.play.stages', $proglang->id) }}"
                                    class="btn btn-secondary w-100 py-3">{{ $proglang->name }}</a>
                            </div>
                        @empty
                            <h5 class="text-center">No records</h5>
                        @endforelse --}}
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        // Code Goes here	
    </script>
@endsection
