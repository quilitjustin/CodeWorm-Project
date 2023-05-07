@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                     <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Badge</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.badges.index') }}">Badge</a></li>
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
                    <div class="card card-navy">
                        <div class="card-header">
                            <h3 class="card-title">
                                Badge Details
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Name</label>
                                    <p>{{ $badge->name }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-12">
                                    <hr class="border border-primary w-100">
                                </div>
                                <div class="col-md-3">
                                    <label>Created By</label>
                                    <br>
                                    <a
                                        href="{{ is_null($badge->created_by_user) ? '#' : route('super.users.show', $badge->created_by_user->encrypted_id) }}">{{ is_null($badge->created_by_user) ? '' : $badge->created_by_user->f_name . ' ' . $badge->created_by_user->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Created</label>
                                    <br>
                                    <p>{{ \Carbon\Carbon::parse($badge->created_at)->diffForHumans() }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>Updated By</label>
                                    <br>
                                    {{-- Because updated_by can have null value, we must first check if the value is null to avoid error --}}
                                    <a
                                        href="{{ is_null($badge->updated_by_user) ? '#' : route('super.users.show', $badge->updated_by_user->encrypted_id) }}">{{ is_null($badge->updated_by_user) ? '' : $badge->updated_by_user->f_name . ' ' . $badge->updated_by_user->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Updated</label>
                                    <br>
                                    <p>{{ is_null($badge->updated_by) ? '' : \Carbon\Carbon::parse($badge->updated_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('super.badges.index') }}" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</a>
                            <a href="{{ route('super.badges.edit', $badge->encrypted_id) }}"
                                class="btn btn-primary ml-2">Update</a>
                            <form class="delete d-inline" action="{{ route('super.badges.destroy', $badge->encrypted_id) }}"
                                method="POST">                                @csrf
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
                        <div class="row d-flex justify-content-center">
                            <div id="preview" class="col-4">
                                <img src="{{ asset($badge->path) }}" id="img-preview"
                                    class="rounded mx-auto d-block border border-secondary"
                                    style="height: 150px; max-height: 150px;" alt="preview">
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
    @include('layouts.superadmin.inc_delete')
@endsection
