@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Programming Language</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('proglangs.index') }}">ProgLang</a></li>
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
                                Programming Language Details
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Name</label>
                                    <p>{{ $proglang['name'] }}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-12">
                                    <hr class="border border-primary w-100">
                                </div>
                                <div class="col-md-3">
                                    <label>Created By</label>
                                    <br>
                                    <a
                                        href="{{ !isset($other[0]) ? '#' : route('users.show', $other[0]->encrypted_id) }}">{{ !isset($other[0]) ? 'N/A' : $other[0]->f_name . ' ' . $other[0]->l_name }}</a>
                                </div>
                                <div class="col-md-3">
                                    <label>Date Created</label>
                                    <br>
                                    <p>{{ \Carbon\Carbon::parse($proglang->created_at)->diffForHumans() }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>Updated By</label>
                                    <br>
                                    {{-- Because updated_by can have null value, we must first check if the value is null to avoid error --}}
                                    @if (!is_null($proglang->updated_by))
                                        <a
                                            href="{{ !isset($other[1]) ? '#' : route('users.show', $other[1]->encrypted_id) }}">{{ !isset($other[1]) ? 'N/A' : $other[1]->f_name . ' ' . $other[1]->l_name }}</a>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label>Date Updated</label>
                                    <br>
                                    <p>{{ is_null($proglang->updated_by) ? '' : \Carbon\Carbon::parse($proglang->updated_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            <button id="cancel" type="button" class="btn btn-warning"><i
                                    class="right fas fa-angle-left"></i> Go Back</button>
                            <a href="{{ route('proglangs.edit', $proglang->encrypted_id) }}" class="btn btn-primary ml-2">Update</a>
                            <form class="delete d-inline" action="{{ route('proglangs.destroy', $proglang->encrypted_id) }}" method="POST">
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
                    <div class="card card-indigo">
                        <div class="card-header">
                            <h3 class="card-title">
                                List of Stages
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                @forelse($stages as $stage)
                                    <div class="col-12 p-2">
                                        <a href="{{ route('stages.show', encrypt($stage->encrypted_id)) }}"
                                            class="btn btn-secondary py-3 w-100">{{ $stage['name'] }}</a>
                                    </div>
                                @empty
                                    <p>Empty</p>
                                @endforelse
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('stages.create', $proglang->encrypted_id) }}" class="btn btn-primary">Create New
                                Stage</a>
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
    @include('layouts.superadmin.delete')
    @include('layouts.superadmin.inc_component')
@endsection
