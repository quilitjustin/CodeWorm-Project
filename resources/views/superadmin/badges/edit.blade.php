@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Badges</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.badges.index') }}">Badge</a></li>
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
                                Badge Details
                            </h3>
                        </div>
                        <form method="POST" action="{{ route('super.badges.update', $badge->encrypted_id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="false" id="action" name="action">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" type="text" name="name"
                                                placeholder="Enter name" value="{{ old('name', $badge['name']) }}" />
                                            @error('name')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image"
                                                        name="image" accept="image/*">
                                                    <label class="custom-file-label" for="image"
                                                        aria-describedby="inputGroupFileAddon02">Choose Image</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <button type="button" id="clear"
                                                        class="btn btn-outline-secondary">Clear</button>
                                                </div>
                                            </div>

                                            @error('image')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer d-flex justify-content-end">
                                <button id="cancel" type="button" class="btn btn-warning">Cancel</button>
                                <button type="submit" class="show btn btn-primary ml-2">Update</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card p-2">
                        <label for="img-preview">Preview</label>
                        <div class="row d-flex justify-content-center">
                            <div id="preview" class="col-4 d-none">
                                <img src="#" id="img-preview" class="rounded img-fluid border border-secondary"
                                    alt="preview">
                                <div class="text-center">
                                    <h3 class="font-weight-bold">Untitled</h3>
                                    <span>Date Earned: 41 minutes ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
    @include('superadmin.badges.script')
@endsection
