@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                     <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Logo Image</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">CMS</a></li>
                        <li class="breadcrumb-item active">Logo</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @include('superadmin.cms.logo.app')
@endsection

@section('script')
    {{-- @include('layouts.superadmin.delete') --}}
    <script>
        const route = "{{ route('super.cms.logo.set') }}";
    </script>
    @include('superadmin.cms.logo.script')
@endsection
