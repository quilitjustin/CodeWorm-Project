@extends('layouts.admin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tasks</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}">Task</a></li>
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
                                Task Details
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <p>{{ $task->name }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Programming Language</label>
                                    <a class="d-block"
                                        href="{{ is_null($task->proglang) ? '#' : route('admin.proglangs.show', $task->proglang->encrypted_id) }}">{{ is_null($task->proglang) ? '' : $task->proglang->name }}</a>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Difficulty</label>
                                    <p>{{ $task->difficulty }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Reward</label>
                                    <p>{{ $task->reward }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-12">
                                    <label>Description</label>
                                    <div class="px-2 py-1 bg-light">
                                        {!! $task->description !!}
                                    </div>
                                </div>
                                <div class="col-sm-12 {{ $task->snippet == '' ? 'd-none' : '' }}">
                                    <!-- /.form-group -->
                                    <label>Code Snippet</label>
                                    <textarea name="snippet" id="codeMirrorDemo" class="form-control">{!! $task->snippet !!}</textarea>
                                </div>
                                <div class="col-sm-12">
                                    <label>Expected Answer</label>
                                    <div class="px-2 py-1 bg-dark">
                                        {{ $task->answer }}
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <hr class="border border-primary w-100">
                                </div>
                                <div class="col-md-3">
                                    <label>Created By</label>
                                    <br>
                                    <a
                                        href="{{ is_null($task->created_by_user) ? '#' : route('admin.users.show', $task->created_by_user->encrypted_id) }}">{{ is_null($task->created_by_user) ? '' : $task->created_by_user->f_name . ' ' . $task->created_by_user->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Created</label>
                                    <br>
                                    <p>{{ \Carbon\Carbon::parse($task->created_at)->diffForHumans() }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>Updated By</label>
                                    <br>
                                    {{-- Because updated_by can have null value, we must first check if the value is null to avoid error --}}
                                    <a
                                        href="{{ is_null($task->updated_by_user) ? '#' : route('admin.users.show', $task->updated_by_user->encrypted_id) }}">{{ is_null($task->updated_by_user) ? '' : $task->updated_by_user->f_name . ' ' . $task->updated_by_user->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Updated</label>
                                    <br>
                                    <p>{{ is_null($task->updated_by) ? '' : \Carbon\Carbon::parse($task->updated_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            <button id="cancel" type="button" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</button>
                            <a href="{{ route('admin.tasks.edit', $task->encrypted_id) }}"
                                class="btn btn-primary ml-2">Update</a>
                        
                        </div>
                        <!-- /.card-footer -->
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
        const editor = CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            lineNumbers: true,
            matchBrackets: true,
            mode: {
                name: "application/x-httpd-php",
                startOpen: true,
            },
            indentUnit: 4,
            indentWithTabs: true,
            theme: "monokai",
        });
    </script>

    @include('superadmin.game.tasks.script')
    @include('layouts.superadmin.inc_component')
    <script>
        editor.setOption("readOnly", true);
        // Stop user the user from clicking the textbox
        editor.on("mousedown", function(e) {
            e.preventDefault();
        });

        $("#cancel").click(function() {
            window.history.back();
        });
    </script>
@endsection