@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Background Image</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('bgims.index') }}">Bgims</a></li>
                        <li class="breadcrumb-item active">Show</li>
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
                                Background Image Details
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Name</label>
                                    <p>{{ $bgim->name }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-12">
                                    <hr class="border border-primary w-100">
                                </div>
                                <div class="col-md-3">
                                    <label>Created By</label>
                                    <br>
                                    <a href="{{ is_null($bgim->created_by_user) ? '#' : route('users.show', $bgim->created_by_user->encrypted_id) }}">{{ is_null($bgim->created_by_user) ? '' : $bgim->created_by_user->f_name . ' ' . $bgim->created_by_user->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Created</label>
                                    <br>
                                    <p>{{ \Carbon\Carbon::parse($bgim->created_at)->diffForHumans() }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>Updated By</label>
                                    <br>
                                    {{-- Because updated_by can have null value, we must first check if the value is null to avoid error --}}
                                    <a href="{{ is_null($bgim->updated_by_user) ? '#' : route('users.show', $bgim->updated_by_user->encrypted_id) }}">{{ is_null($bgim->updated_by_user) ? '' : $bgim->updated_by_user->f_name . ' ' . $bgim->updated_by_user->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Updated</label>
                                    <br>
                                    <p>{{ is_null($bgim->updated_by) ? '' : \Carbon\Carbon::parse($bgim->updated_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            <button id="cancel" type="button" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</button>
                            <a href="{{ route('bgims.edit', $bgim->encrypted_id) }}" class="btn btn-primary ml-2">Update</a>
                            <form class="delete d-inline" action="{{ route('bgims.destroy', $bgim->encrypted_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ml-2">Delete</button>
                            </form>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card p-2">
                        <label for="img-preview">Preview</label>
                        <img src="{{ asset($bgim->path) }}" id="img-preview" class="img-fluid" alt="preview">
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
    @include('layouts.superadmin.delete')
    @include('layouts.superadmin.inc_component')
@endsection
