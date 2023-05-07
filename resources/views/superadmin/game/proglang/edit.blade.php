@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                     <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Programming Language</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.proglangs.index') }}">ProgLang</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <form method="POST" action="{{ route('super.proglangs.update', $proglang->encrypted_id) }}">
                            @csrf
                            @method('PUT')
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" type="text" name="name"
                                                placeholder="Enter name" value="{{ old('name', $proglang['name']) }}" />
                                            @error('name')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Language Key (<a href="https://ce.judge0.com/" target="_blank">Docs</a>)</label>
                                            <input class="form-control" type="text" name="key"
                                                placeholder="Enter name" value="{{ old('key', '66') }}" />
                                            @error('key')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Editor Mode (<a href="https://codemirror.net/docs/" target="_blank">Docs</a>)</label>
                                            <select class="form-control select2" style="width: 100%;" id="editor"
                                                name="editor">
                                                <option value="">Select Type</option>
                                                <option>Javascript</option>
                                                <option selected>PHP</option>
                                                <option>Pearl</option>
                                                <option>Python</option>
                                                <option>C#</option>
                                                <option>C++</option>
                                                <option>Javascript</option>
                                                <option>PHP</option>
                                                <option>Pearl</option>
                                                <option>Python</option>
                                                <option>C#</option>
                                                <option>C++</option>
                                                <option>Javascript</option>
                                                <option>PHP</option>
                                                <option>Pearl</option>
                                                <option>Python</option>
                                                <option>C#</option>
                                                <option>C++</option>
                                            </select>
                                            @error('editor')
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
                                <button type="submit" class="btn btn-primary ml-2">Update</button>
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
@endsection
