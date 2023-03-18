@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Visual Effects</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('vfxs.index') }}">Vfx</a></li>
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
                            <h3 class="card-title">List of Current Visual Effects</h3>
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
                                    @forelse ($vfxs as $vfx)
                                        <tr>
                                            <td>{{ $vfx['id'] }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('vfxs.show', $vfx['id']) }}">
                                                    {{ $vfx['name'] }}
                                                </a>
                                            </td>
                                            <td class="d-none d-xl-table-cell">
                                                <a class="text-link" href="{{ route('vfxs.show', $vfx['id']) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                <a class="text-success" href="{{ route('vfxs.edit', $vfx['id']) }}">
                                                    <i class="fas fa-pen-square"></i> Edit</a>
                                                <form class="d-inline" action="{{ route('vfxs.destroy', $vfx['id']) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('You are about to delete vfx ID: {{ $vfx['id'] }}s record. \n Are you sure?');">
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
                                    Viewing {{ $vfxs->firstItem() }} - {{ $vfxs->lastItem() }} of {{ $vfxs->total() }}
                                    entries.
                                </div>
                                <div class="col-md-6">
                                    {{ $vfxs->onEachSide(3)->links() }}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="{{ route('vfxs.create') }}" class="btn btn-primary">Create New vfx</a>
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
