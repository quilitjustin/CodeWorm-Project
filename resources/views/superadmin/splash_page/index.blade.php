@extends('layouts.superadmin.app')

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
                    <div class="card card-navy">
                        <div class="card-header">
                            <h3 class="card-title">List of Current Versions</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered table-hover">
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
                                                <a href="{{ route('super.splash.show', $splash['id']) }}">
                                                    Version {{ $splash->id }}</a>
                                                @if ($loop->first)
                                                    <span class="badge bg-primary">Latest</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($splash['created_at'])->diffForHumans() }}</td>
                                            <td class="d-none d-md-table-cell text-center"><a
                                                    href="{{ is_null($splash->created_by_user) ? '#' : route('super.users.show', $splash->created_by_user->encrypted_id) }}">{{ is_null($splash->created_by_user) ? '' : $splash->created_by_user->f_name . ' ' . $splash->created_by_user->l_name }}</a>
                                            </td>
                                            <td class="d-none d-xl-table-cell">
                                                <a class="text-link" href="{{ route('super.splash.show', $splash['id']) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                @if (!$loop->first)
                                                    <form class="delete d-inline"
                                                        action="{{ route('super.splash.destroy', $splash['id']) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-danger">
                                                            <i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
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

@section('script')
    @include('layouts.superadmin.index_component')
@endsection
