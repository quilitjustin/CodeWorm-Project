@extends('layouts.admin')

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
                            <h3 class="card-title">List of Current Programming Languages</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th class="d-none d-xl-table-cell">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($proglangs as $proglang)
                                        <tr>
                                            <td>{{ $proglang['id'] }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('proglangs.show', $proglang['id']) }}">
                                                    {{ $proglang['name'] }}
                                                </a>
                                            </td>
                                            <td class="d-none d-xl-table-cell">
                                                <a class="text-link" href="{{ route('proglangs.show', $proglang['id']) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                <a class="text-success" href="{{ route('proglangs.edit', $proglang['id']) }}">
                                                    <i class="fas fa-pen-square"></i> Edit</a>
                                                <form class="d-inline" action="{{ route('proglangs.destroy', $proglang['id']) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('You are about to delete proglang ID: {{ $proglang['id'] }}s record. \n Are you sure?');">
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
                            <div class="row mt-3">
                                {{-- Hide for mobile --}}
                                <div class="col-md-6 mb-2">
                                    Viewing {{ $proglangs->firstItem() }} - {{ $proglangs->lastItem() }} of {{ $proglangs->total() }}
                                    entries.
                                </div>
                                <div class="col-md-6">
                                    {{ $proglangs->onEachSide(0.5)->links() }}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="{{ route('proglangs.create') }}" class="btn btn-primary">Create New proglang</a>
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