@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stages</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('proglangs.index') }}">Stages</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="card card-indigo">
                        <div class="card-header">
                            <h3 class="card-title">
                                Please choose one of available programming languages
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                @forelse($proglangs as $proglang)
                                    <div class="col-12 p-2">
                                        <a href="{{ route('stages.create', $proglang['id']) }}"
                                            class="btn btn-secondary py-3 w-100">{{ $proglang['name'] }}</a>
                                        {{-- <a href="{{ route('stages.create', encrypt($proglang['id'])) }}"
                                            class="btn btn-secondary py-3 w-100">{{ $proglang['name'] }}</a> --}}
                                    </div>
                                @empty
                                    <p>Empty</p>
                                @endforelse
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

@section('script')
    <script>
        $("#cancel").click(function() {
            window.history.back();
        });
    </script>
@endsection
