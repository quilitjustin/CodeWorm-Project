@extends('layouts.admin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Background Musics</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.bgms.index') }}">BGM</a></li>
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
                            <h3 class="card-title">List of Current Background Musics</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="d-none d-xl-table-cell">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bgms as $bgm)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.bgms.show', $bgm->encrypted_id) }}">
                                                    {{ $bgm['name'] }}
                                                </a>
                                            </td>
                                            <td class="d-none d-xl-table-cell">
                                                <a class="text-link" href="{{ route('admin.bgms.show', $bgm->encrypted_id) }}">
                                                    <i class="far fa-eye"></i> View</a>
                                                <a class="text-success" href="{{ route('admin.bgms.edit', $bgm->encrypted_id) }}">
                                                    <i class="fas fa-pen-square"></i> Edit</a>
                                              
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
                            <a href="{{ route('admin.bgms.create') }}" class="btn btn-primary">Create New Background Music</a>
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