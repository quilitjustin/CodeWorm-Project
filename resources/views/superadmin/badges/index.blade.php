@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Badge</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('badges.index') }}">Badge</a></li>
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
                            <h3 class="card-title">List of Current Badges</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="d-none d-md-table-cell">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($badges as $badge)
                                        <tr>
                                            <td>
                                                <a href="{{ route('badges.show', encrypt($badge->encrypted_id)) }}">
                                                    {{ $badge['name'] }}
                                                </a>
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                <a class="text-link"
                                                    href="{{ route('badges.show', encrypt($badge->encrypted_id)) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                <a class="text-success"
                                                    href="{{ route('badges.edit', encrypt($badge->encrypted_id)) }}">
                                                    <i class="fas fa-pen-square"></i> Edit</a>
                                                <form class="delete d-inline"
                                                    action="{{ route('badges.destroy', encrypt($badge->encrypted_id)) }}"
                                                    method="POST"> @csrf
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
                            <a href="{{ route('badges.create') }}" class="btn btn-primary">Create New badge</a>
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
@endsection
