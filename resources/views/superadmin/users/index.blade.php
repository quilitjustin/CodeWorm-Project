@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.users.index') }}">Users</a></li>
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
                            <h3 class="card-title">List of Current Users</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th class="d-none d-md-table-cell">Type</th>
                                        <th class="d-none d-xl-table-cell">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('super.users.show', $user->encrypted_id) }}">
                                                    {{ $user['f_name'] . ' ' . $user['l_name'] }}
                                                </a>
                                            </td>
                                            <td class="text-center"><span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}">{{ $user->status }}</span></td>
                                            <td class="d-none d-md-table-cell text-center">
                                                {{ $user['role'] }}</td>
                                            <td class="d-none d-xl-table-cell">
                                                <a class="text-link" href="{{ route('super.users.show', $user->encrypted_id) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                <a class="text-success" href="{{ route('super.users.edit', $user->encrypted_id) }}">
                                                    <i class="fas fa-pen-square"></i> Edit</a>
                                               
                                                <form class="delete d-inline"
                                                    action="{{ route('super.users.destroy', $user->encrypted_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger">
                                                        <i class="fas fa-trash"></i> Delete</button>
                                                </form>
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
                        <div class="card-footer clearfix">
                            <a href="{{ route('super.users.create') }}" class="btn btn-primary">Create New User</a>
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

@section('script')
    @include('layouts.superadmin.index_component')
    <script>
        
    </script>
@endsection
