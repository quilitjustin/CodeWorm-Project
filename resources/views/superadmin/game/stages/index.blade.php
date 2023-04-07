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
                        <li class="breadcrumb-item"><a href="{{ route('stages.index') }}">Stage</a></li>
                        <li class="breadcrumb-item active">Index</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-indigo">
                        <div class="card-header">
                            <h3 class="card-title">List of Current Stages</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Programming Language</th>
                                        <th class="d-none d-xl-table-cell">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($stages as $stage)
                                        <tr>
                                            <td>
                                                <a href="{{ route('stages.show', encrypt($stage->id)) }}">
                                                    {{ $stage->name }}
                                                </a>

                                            </td>
                                            <td>
                                                <a href="{{ route('proglangs.show', encrypt($stage->proglang_id)) }}">
                                                    {{ $stage->proglang_name }}
                                                </a>
                                            </td>
                                            <td class="d-none d-xl-table-cell">
                                                <a class="text-link"
                                                    href="{{ route('stages.show', encrypt($stage->id)) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                <a class="text-success"
                                                    href="{{ route('stages.edit', encrypt($stage->id)) }}">
                                                    <i class="fas fa-pen-square"></i> Edit</a>
                                                <form class="d-inline"
                                                    action="{{ route('stages.destroy', encrypt($stage->id)) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('You are about to delete {{ $stage->name }}s record. \n Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger">
                                                        <i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <h5 class="text-center">No records</h5>
                                    @endforelse
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="{{ route('stages.redirect') }}" class="btn btn-primary">Create New Stage</a>
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
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        // Code Goes here	
    </script>
@endsection
