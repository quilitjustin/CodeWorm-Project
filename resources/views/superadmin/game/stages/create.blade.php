@extends('layouts.superadmin.app')

@section('css')
    @include('superadmin.game.stages.css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stages</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('stages.index') }}">Stage</a></li>
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
                                Stage Details
                            </h3>
                        </div>
                        <form method="POST" action="{{ route('stages.store') }}">
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
                                            <label>Language</label>
                                            <select class="select2" style="width: 100%;"
                                                data-placeholder="Select a Language" id="proglang" name="proglang">
                                                <option value="">Select a Language</option>
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
                                            <label>Tasks</label>
                                            <select class="select2" id="tasks" name="tasks[]" multiple="multiple"
                                                data-placeholder="Select a State" style="width: 100%;">

                                            </select>
                                            @error('tasks')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Background Image</label>
                                            <select class="select2" id="bgims" name="bgim"
                                                data-placeholder="Select a Background Image" style="width: 100%;">
                                                <option value="">Select a Background Image</option>
                                                @forelse ($bgims as $bgim)
                                                    <option value="{{ $bgim->encrypted_id }}">{{ $bgim->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('bgim')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Background Music</label>
                                            <select class="select2" id="bgm" name="bgm"
                                                data-placeholder="Select a Background Image" style="width: 100%;">
                                                <option value="">Select a Background Music</option>
                                                @forelse ($bgms as $bgm)
                                                    <option value="{{ $bgm->encrypted_id }}">{{ $bgm->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('bgm')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Reward (Optional)</label>
                                            <select class="select2" id="reward" name="reward"
                                                data-placeholder="Select a Badge" style="width: 100%;">
                                                <option value="">Select a Badge</option>
                                                @forelse ($rewards as $reward)
                                                    <option value="{{ $reward->encrypted_id }}">{{ $reward->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('reward')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Player Base HP</label>
                                            <input class="form-control" type="number" name="player-base-hp"
                                                placeholder="Enter hp" value="{{ old('player-base-hp', '') }}" />
                                            @error('player-base-hp')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Enemy Base HP</label>
                                            <input class="form-control" type="number" name="enemy-base-hp"
                                                placeholder="Enter hp" value="{{ old('enemy-base-hp', '') }}" />
                                            @error('enemy-base-hp')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Player Base SP</label>
                                            <input class="form-control" type="number" name="player-base-sp"
                                                placeholder="Enter SP" value="{{ old('player-base-sp', '') }}" />
                                            @error('player-base-sp')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Enemy Rage Timer</label>
                                            <input class="form-control" type="number" name="enemy-rage-timer"
                                                placeholder="Enter name" value="{{ old('enemy-rage-timer', '') }}" />
                                            @error('enemy-rage-timer')
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
    @include('superadmin.game.stages.script')
    @include('layouts.superadmin.inc_component')
@endsection
