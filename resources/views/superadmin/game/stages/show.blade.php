@extends('layouts.superadmin.app')

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
                        <li class="breadcrumb-item"><a href="{{ route('super.stages.index') }}">Stage</a></li>
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
                                Stage Details
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <p>{{ $stage->name }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Programming Language</label>
                                    <a class="d-block"
                                        href="{{ is_null($stage->proglang) ? '#' : route('super.proglangs.show', $stage->proglang->encrypted_id) }}">{{ is_null($stage->proglang) ? '' : $stage->proglang->name }}</a>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6 mb-3">
                                    <label>Background Image</label>
                                    <a class="d-block"
                                        href="{{ is_null($stage->bgim) ? '#' : route('super.bgims.show', $stage->bgim->encrypted_id) }}">{{ is_null($stage->bgim) ? '' : $stage->bgim->name }}</a>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Background Music</label>
                                    <a class="d-block mb-3"
                                        href="{{ is_null($stage->bgm) ? '#' : route('super.bgms.show', $stage->bgim->encrypted_id) }}">{{ is_null($stage->bgm) ? '' : $stage->bgm->name }}</a>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Player Base Hp</label>
                                    <p>{{ $stage->player_base_hp }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Enemy Base Hp</label>
                                    <p>{{ $stage->enemy_base_hp }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Player Base SP</label>
                                    <p>{{ $stage->player_base_sp }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Enemy Base Damage</label>
                                    <p>{{ $stage->enemy_base_dmg }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Tasks</label>
                                    <div>
                                        @forelse ($tasks as $task)
                                            <a class="d-block"
                                                href="{{ route('super.tasks.show', $task->encrypted_id) }}">{{ $task->name }}</a>
                                        @empty
                                            <p>None</p>
                                        @endforelse
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <label>Reward</label>
                                    <a class="d-block mb-3"
                                        href="{{ is_null($stage->badges) ? '#' : route('super.badges.show', $stage->badges->encrypted_id) }}">{{ is_null($stage->badges) ? '' : $stage->badges->name }}</a>
                                </div>
                                <div class="col-sm-12">
                                    <hr class="border border-primary w-100">
                                </div>
                                <div class="col-md-3">
                                    <label>Created By</label>
                                    <br>
                                    <a
                                        href="{{ is_null($stage->created_by_user) ? '#' : route('super.users.show', $stage->created_by_user->encrypted_id) }}">{{ is_null($stage->created_by_user) ? '' : $stage->created_by_user->f_name . ' ' . $stage->created_by_user->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Created</label>
                                    <br>
                                    <p>{{ \Carbon\Carbon::parse($stage->created_at)->diffForHumans() }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>Updated By</label>
                                    <br>
                                    {{-- Because updated_by can have null value, we must first check if the value is null to avoid error --}}
                                    <a
                                        href="{{ is_null($stage->updated_by_user) ? '#' : route('super.users.show', $stage->updated_by_user->encrypted_id) }}">{{ is_null($stage->updated_by_user) ? '' : $stage->updated_by_user->f_name . ' ' . $stage->updated_by_user->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Updated</label>
                                    <br>
                                    <p>{{ is_null($stage->updated_by) ? '' : \Carbon\Carbon::parse($stage->updated_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            <button id="cancel" type="button" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</button>
                            <a href="{{ route('super.stages.edit', $stage->encrypted_id) }}"
                                class="btn btn-primary ml-2">Update</a>
                            <form class="delete d-inline"
                                action="{{ route('super.stages.destroy', $stage->encrypted_id) }}" method="POST">
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
    @include('layouts.superadmin.inc_delete')
    @include('layouts.superadmin.inc_component')
@endsection
