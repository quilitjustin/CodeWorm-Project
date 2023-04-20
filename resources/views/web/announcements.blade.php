@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-image: url('{{ asset('assets/bgim/announcement.png') }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Announcements</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Announcements</a></li>
                        <li class="breadcrumb-item active">Index</li>
                    </ol> --}}
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @forelse($announcements as $announcement)
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="m-0">{{ $announcement['title'] }}</h5>
                                </div>
                                <div class="card-body" style="">
                                    {!! $announcement['contents'] !!}
                                </div>
                                <div class="card-footer">
                                    {{ \Carbon\Carbon::parse($announcement['created_at'])->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            No Announcements as of late!
                        @endforelse
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
                <div class="row mt-3">
                    {{-- Hide for mobile --}}
                    <div class="col-md-6 mb-2">
                        Viewing {{ $announcements->firstItem() }} - {{ $announcements->lastItem() }} of
                        {{ $announcements->total() }}
                        entries.
                    </div>
                    <div class="col-md-6">
                        {{ $announcements->onEachSide(3)->links() }}
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
