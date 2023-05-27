@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Reports</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.reports.index') }}">Repots</a></li>
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
                            <h3 class="card-title">List of Current Reports</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Reported By</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reports as $report)
                                        <tr>
                                            <td>
                                                <a href="{{ route('super.reports.show', $report->encrypted_id) }}">
                                                    {{ $report->created_by_user->f_name . ' ' . $report->created_by_user->l_name }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}
                                            </td>
                                            <td class="">
                                                <a class="text-link"
                                                    href="{{ route('super.reports.show', $report->encrypted_id) }}">
                                                    <i class="far fa-eye"></i> View</a>
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
                        {{-- <div class="card-footer clearfix">
                            <a href="{{ route('super.reports.create') }}" class="btn btn-primary">Create New report</a>
                        </div> --}}
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
    <script>
        if (cacheReports !== null && cacheReports !== undefined) {
            localStorage.removeItem('pending_reports');
            location.reload();
        }
    </script>
    @include('layouts.superadmin.index_component')
@endsection
