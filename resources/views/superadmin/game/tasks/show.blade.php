@extends('layouts.superadmin.app')

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
                        <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Task</a></li>
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
                                Task Details
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <p>{{ $task['name'] }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>{{ $task->proglang }}</label>
                                </div>
                                <div class="col-sm-12">
                                    <!-- /.form-group -->
                                    <label>Code Snippet</label>
                                    <textarea name="snippet" id="codeMirrorDemo" class="form-control">{{ $task->snippet }}</textarea>
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
                                        href="{{ !isset($other[0]) ? '#' : route('users.show', $other[0]->id) }}">{{ !isset($other[0]) ? 'N/A' : $other[0]->f_name . ' ' . $other[0]->l_name }}</a>
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
                                    @if(!is_null($task->updated_by))
                                    <a href="{{ !isset($other[1]) ? '#' : route('users.show', $other[1]->id) }}">{{ !isset($other[1]) ? 'N/A' : $other[1]->f_name . ' ' . $other[1]->l_name }}</a>
                                    @endif
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
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary ml-2">Update</a>
                            <form class="d-inline" action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                onsubmit="return confirm('You are about to delete task ID: {{ $task->id }}s record. \n Are you sure?');">
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
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

@section('script')
    @include('superadmin.game.tasks.script')
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
