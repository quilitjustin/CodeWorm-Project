@extends('layouts.superadmin.app')

@section('css')
    @include('superadmin.game.tasks.css')
@endsection

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
                    <div class="card card-indigo">
                        <div class="card-header">
                            <h3 class="card-title">
                                Task Details
                            </h3>
                        </div>
                        <form method="POST" action="{{ route('tasks.store') }}">
                            @csrf
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" type="text" name="name"
                                                placeholder="Enter name" value="{{ old('name', '') }}" />
                                            @error('name')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Difficulty</label>
                                            <select class="form-control select2" style="width: 100%;" id="difficulty"
                                                name="difficulty">
                                                <option>Easy</option>
                                                <option>Medium</option>
                                                <option>Hard</option>
                                            </select>
                                            @error('difficulty')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Language</label>
                                            <select class="form-control select2" style="width: 100%;" id="proglang"
                                                name="proglang">
                                                @forelse ($proglangs as $proglang)
                                                    <option value="{{ $proglang->encrypted_id }}">{{ $proglang->name }}
                                                    </option>
                                                @empty
                                                @endforelse

                                            </select>
                                            @error('proglang')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea id="summernote" name="description">
                                                {{ old('description', '') }}
                                            </textarea>
                                            @error('description')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Expected Answer</label>
                                            <input class="form-control" type="text" name="answer"
                                                placeholder="Expected answer" value="{{ old('answer', '') }}" />
                                            @error('answer')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Reward (SP)</label>
                                            <input class="form-control" type="number" name="reward"
                                                placeholder="Enter Amount of SP" value="{{ old('reward', '') }}" />
                                            @error('reward')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                        <button id="advance" type="button" class="text-info mb-3">Show advanced
                                            options</button>
                                        <div class="form-group" id="snippet">
                                            <label>Provide Code Snippet</label>
                                            <textarea name="snippet" id="codeMirrorDemo" class="form-control"></textarea>
                                            @error('snippet')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                            <button type="button" id="run"
                                                class="btn btn-outline-success mt-3 px-5">Run</button>
                                            <div class="px-2 py-1 mt-3 bg-dark">
                                                <div>
                                                    Console:
                                                </div>
                                                <hr class="border border-light w-100 m-0 p-0">
                                                <div id="result">

                                                </div>
                                            </div>
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
    @include('superadmin.game.tasks.script')
    @include('layouts.superadmin.inc_component')
    <script>
        const PHP_ROUTE = "{{ asset('demo/api/v1/php_api.php') }}";
        const TOKEN = "{{ csrf_token() }}";
    </script>
    {{-- Code execution --}}
    <script src="{{ asset('js/rcode.js') }}"></script>
    <script>
        $("#cancel").click(function() {
            window.history.back();
        });

        $("#run").click(function() {
            const language = $("#proglang option:selected").text();
            const code = editor.getValue();

            runCode(code, language.toLowerCase());
        });

        // $(document).ready(function() {
        //     const route = "{{ route('super.fetch.languages') }}";
        //     $.get({
        //         url: route,
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //         },
        //         success: function(response) {
        //             let html = '';
        //             $.each(response, function(index, data) {
        //                 html +=
        //                     `<option value="` + data.id + `">` + data.name + `</option>`;
        //             });
        //             $("#proglang").append(html);
        //         }
        //     });
        // });
    </script>
@endsection
