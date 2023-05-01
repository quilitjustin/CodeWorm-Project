@extends('layouts.superadmin.app')

@section('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Programming Language</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('super.proglangs.index') }}">ProgLang</a></li>
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
                <div class="card card-navy">
                    <div class="card-header">
                        <h3 class="card-title">
                            Programming Language Details
                        </h3>
                    </div>
                    <form method="POST" action="{{ route('super.proglangs.store') }}">
                        @csrf
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Name (<a href="https://codemirror.net/docs/" target="_blank">Docs</a>)</label>
                                        <select class="form-control select2" style="width: 100%;" id="name"
                                            name="name">
                                            <option value="">Select Language</option>
                                            <option>Javascript</option>
                                            <option>PHP</option>
                                            <option>Pearl</option>
                                            <option>Python</option>
                                            <option>C#</option>
                                            <option>C++</option>
                                        </select>
                                        @error('name')
                                            <p class="text-danger my-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            <button id="cancel" type="button" class="btn btn-warning">Cancel</button>
                            <button type="submit" class="btn btn-primary ml-2">Create</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
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
@include('layouts.superadmin.inc_component')
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
</script>
@endsection
