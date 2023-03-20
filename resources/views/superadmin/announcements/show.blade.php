@extends('layouts.admin')

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
                        <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Announcements</a></li>
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
                            <h5 class="m-0">{{ $announcement['title'] }}</h5>
                        </div>
                        <div class="card-body" style="">
                            <div class="row">
                                <div class="col-sm-12">
                                    {!! $announcement['contents'] !!}
                                </div>
                                <div class="col-sm-12">
                                    <hr class="border border-primary w-100">
                                </div>
                                <div class="col-md-3">
                                    <label>Created By</label>
                                    <br>
                                    <a
                                        href="{{ route('announcements.show', $announcement['created_by']) }}">{{ $announcement['created_by'] }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Created</label>
                                    <br>
                                    <p>{{ \Carbon\Carbon::parse($announcement['created_at'])->diffForHumans() }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>Updated By</label>
                                    <br>
                                    {{-- Because updated_by can have null value, we must first check if the value is null to avoid error --}}
                                    <a
                                        href="{{ is_null($announcement['updated_by']) ? '#' : route('announcements.show', $announcement['updated_by']) }}">{{ $announcement['updated_by'] }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Updated</label>
                                    <br>
                                    <p>{{ is_null($announcement['updated_by']) ? '' : \Carbon\Carbon::parse($announcement['updated_at'])->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button id="cancel" type="button" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</button>
                            <a href="{{ route('announcements.edit', $announcement['id']) }}" class="btn btn-primary ml-2">Update</a>
                            <form class="d-inline" action="{{ route('announcements.destroy', $announcement['id']) }}" method="POST"
                                onsubmit="return confirm('You are about to delete announcement ID: {{ $announcement['id'] }}s record. \n Are you sure?');">
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
    <script>
        $(document).ready(function() {
            // Summernote
            $('#summernote').summernote({
                    height: 150,
                    focus: true,
                    // placeholder: 'write here...',
                    codeviewIframeFilter: true,
                    spellCheck: true
                }
            );
        });

        $("#cancel").click(function() {
            window.history.back();
        });
    </script>
@endsection