@extends('layouts.admin.app')

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
                    <li class="breadcrumb-item"><a href="{{ route('admin.proglangs.index') }}">ProgLang</a></li>
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
                    <form method="POST" action="{{ route('admin.proglangs.store') }}">
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
                                            <option>Assembly (NASM 2.14.02)</option>
                                            <option>Bash (5.0.0)</option>
                                            <option>Basic (FBC 1.07.1)</option>
                                            <option>C (GCC 7.4.0)</option>
                                            <option>C++ (GCC 7.4.0)</option>
                                            <option>C++ (GCC 8.3.0)</option>
                                            <option>C++ (GCC 9.2.0)</option>
                                            <option>C (GCC 8.3.0)</option>
                                            <option>C (GCC 9.2.0)</option>
                                            <option>C# (Mono 6.6.0.161)</option>
                                            <option>Common Lisp (SBCL 2.0.0)</option>
                                            <option>D (DMD 2.089.1)</option>
                                            <option>Elixir (1.9.4)</option>
                                            <option>Erlang (OTP 22.2)</option>
                                            <option>Executable</option>
                                            <option>Fortran (GFortran 9.2.0)</option>
                                            <option>Go (1.13.5)</option>
                                            <option>Haskell (GHC 8.8.1)</option>
                                            <option>Java (OpenJDK 13.0.1)</option>
                                            <option>JavaScript (Node.js 12.14.0)</option>
                                            <option>Lua (5.3.5)</option>
                                            <option>OCaml (4.09.0)</option>
                                            <option>Octave (5.1.0)</option>
                                            <option>Pascal (FPC 3.0.4)</option>
                                            <option>PHP (7.4.1)</option>
                                            <option>Plain Text</option>
                                            <option>Prolog (GNU Prolog 1.4.5)</option>
                                            <option>Python (2.7.17)</option>
                                            <option>Python (3.8.1)</option>
                                            <option>Ruby (2.7.0)</option>
                                            <option>Rust (1.40.0)</option>
                                            <option>TypeScript (3.7.4)</option>
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
