@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Announcements</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.announcements.index') }}">Announcements</a></li>
                        <li class="breadcrumb-item active">Show</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0 font-weight-bold">{{ $announcement->title }}</h5>
                        </div>
                        <div class="card-body" style="">
                            <div class="row">
                                <div class="col-sm-12">
                                    {!! $announcement->contents !!}
                                </div>
                                <div class="col-sm-12">
                                    <hr class="border border-primary w-100">
                                </div>
                                <div class="col-md-3">
                                    <label>Created By</label>
                                    <br>
                                    <a
                                        href="{{ is_null($announcement->created_by_user) ? '#' : route('super.users.show', $announcement->created_by_user->encrypted_id) }}">{{ is_null($announcement->created_by_user) ? '' : $announcement->created_by_user->f_name . ' ' . $announcement->created_by_user->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Created</label>
                                    <br>
                                    <p>{{ \Carbon\Carbon::parse($announcement->created_at)->diffForHumans() }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>Updated By</label>
                                    <br>
                                    {{-- Because updated_by can have null value, we must first check if the value is null to avoid error --}}
                                    <a
                                        href="{{ is_null($announcement->updated_by_user) ? '#' : route('super.users.show', $announcement->updated_by_user->encrypted_id) }}">{{ is_null($announcement->updated_by_user) ? '' : $announcement->updated_by_user->f_name . ' ' . $announcement->updated_by_user->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Updated</label>
                                    <br>
                                    <p>{{ is_null($announcement->updated_by) ? '' : \Carbon\Carbon::parse($announcement->updated_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button id="cancel" type="button" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</button>
                            <a href="{{ route('super.announcements.edit', $announcement->encrypted_id) }}"
                                class="btn btn-primary ml-2">Update</a>
                            <form class="delete d-inline"
                                action="{{ route('super.announcements.destroy', $announcement->encrypted_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ml-2">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('script')
    @include('layouts.superadmin.inc_delete')
    @include('layouts.superadmin.inc_component')
    <script>
        $(document).ready(function() {
            // Summernote
            $('#summernote').summernote({
                height: 150,
                focus: true,
                // placeholder: 'write here...',
                codeviewIframeFilter: true,
                spellCheck: true
            });
        });
    </script>
@endsection
