@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"
        style="background-image: url('{{ asset('assets/bgim/announcement.png') . '?v=' . filemtime(public_path('assets/bgim/announcement.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-navy font-weight-bold">Announcements</h1>
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
                    @if (!is_null($pinned))
                        <div class="col-12">
                            @forelse($pinned as $pin)
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-11 text-muted">
                                                <p class="m-0">Posted By: <span
                                                        class="badge badge-secondary">{{ $pin->created_by_user->f_name . ' ' . $pin->created_by_user->l_name }}</span>
                                                    {{ \Carbon\Carbon::parse($pin->created_at)->diffForHumans() }}</p>
                                            </div>
                                            <div class="col-1 text-right">
                                                <i class="fas fa-thumbtack text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="">
                                        <h5 class="m-0 font-weight-bold">{{ $pin->title }}</h5>
                                        {!! $pin->contents !!}
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    @endif
                    <div class="col-12">
                        @forelse($announcements as $announcement)
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-11 text-muted">
                                            <p class="m-0">Posted By: <span
                                                    class="badge badge-secondary">{{ $announcement->created_by_user->f_name . ' ' . $announcement->created_by_user->l_name }}</span>
                                                {{ \Carbon\Carbon::parse($announcement->created_at)->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="">
                                    <h5 class="m-0 font-weight-bold">{{ $announcement->title }}</h5>
                                    {!! $announcement->contents !!}
                                </div>
                            </div>
                        @empty
                            No Announcements as of late!
                        @endforelse
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
                {{-- <div class="row mt-3">
             
                <div class="col-md-6 mb-2">
                    Viewing {{ $announcements->firstItem() }} - {{ $announcements->lastItem() }} of
                    {{ $announcements->total() }}
                    entries.
                </div>
                <div class="col-md-6">
                    {{ $announcements->onEachSide(3)->links() }}
                </div>
            </div> --}}
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
