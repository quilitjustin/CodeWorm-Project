@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                     <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Announcements</h1>
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
                    <div class="card card-navy card-outline">
                        <div class="card-header">
                            <h5 class="m-0 font-weight-bold">{{ $announcement->title }}</h5>
                        </div>
                        <div class="card-body" style="">
                            <div class="row">
                                <div class="col-sm-12">
                                    {!! $announcement->contents !!}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('super.announcements.index') }}" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</a>
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
