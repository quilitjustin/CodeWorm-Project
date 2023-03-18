@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Splash Page</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Splash</li>
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
                            <h3 class="card-title">List of Current Versions</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Version ID</th>
                                        <th>Date</th>
                                        <th class="d-none d-md-table-cell">Created By</th>
                                        <th class="d-none d-xl-table-cell">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($splashs as $splash)
                                        <tr>
                                            <td>
                                                <a href="{{ route('splash.show', $splash['id']) }}">
                                                    Version {{ $splash['id'] }}</a>
                                                @if ($splash['id'] == $latest['id'])
                                                    <span class="badge bg-primary">Latest</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($splash['created_at'])->diffForHumans() }}</td>
                                            <td class="d-none d-md-table-cell text-center">{{ $splash['created_by'] }}</td>
                                            <td class="d-none d-xl-table-cell">
                                                <a class="text-link" href="{{ route('splash.show', $splash['id']) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                <form class="d-inline" action="{{ route('splash.destroy', $splash['id']) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('You are about to delete splash ID: {{ $splash['id'] }}s record. \n Are you sure?');">
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
                                    Viewing {{ $splashs->firstItem() }} - {{ $splashs->lastItem() }} of
                                    {{ $splashs->total() }}
                                    entries.
                                </div>
                                <div class="col-md-6">
                                    {{ $splashs->onEachSide(0.5)->links() }}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
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
