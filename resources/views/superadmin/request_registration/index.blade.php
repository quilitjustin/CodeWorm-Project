@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-navy font-weight-bold">Registration Request</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.request_registration.index') }}">Registration</a></li>
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
                            <h3 class="card-title">List of Registration Requests</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th class="d-none d-xl-table-cell">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reqregs as $reqreg)
                                        <tr>
                                            <td>
                                                {{-- <a href="{{ route('super.reqregs.show', $reqreg->encrypted_id) }}">
                                                    {{ $reqreg['f_name'] . ' ' . $reqreg['l_name'] }}
                                                </a> --}}
                                            </td>
                                            <td class="text-center"><span
                                                    class="badge {{ $reqreg->status == 'active' ? 'bg-success' : 'bg-danger' }}">{{ $reqreg->status }}</span>
                                            </td>
                                            <td class="d-none d-md-table-cell text-center">
                                                {{ $reqreg['role'] }}</td>
                                            <td class="d-none d-xl-table-cell">
                                                {{-- <a class="text-link"
                                                    href="{{ route('super.reqregs.show', $reqreg->encrypted_id) }}"><i
                                                        class="far fa-eye"></i> View</a> --}}
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
    <script></script>
@endsection
