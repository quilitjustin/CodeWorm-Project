@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Announcements</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.announcements.index') }}">Announcements</a></li>
                        <li class="breadcrumb-item active">Index</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 pb-4">
                    <a href="{{ route('super.announcements.create') }}" class="btn btn-success">Create new Announcement</a>
                </div>
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
                                            <form action="{{ route('super.announcements.pin', $pin->encrypted_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"><i
                                                        class="fas fa-thumbtack {{ $pin->is_pinned ? 'text-primary' : '' }}"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="">
                                    <h5 class="m-0 font-weight-bold">{{ $pin->title }}</h5>
                                    {!! $pin->contents !!}
                                </div>
                                <div class="card-footer">
                                    <a class="text-link" href="{{ route('super.announcements.show', $pin->encrypted_id) }}">
                                        <i class="far fa-eye"></i> View</a>
                                    <a class="text-success"
                                        href="{{ route('super.announcements.edit', $pin->encrypted_id) }}">
                                        <i class="fas fa-pen-square"></i> Edit</a>
                                    <form class="delete d-inline"
                                        action="{{ route('super.announcements.destroy', $pin->encrypted_id) }}"
                                        method="POST"> @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger">
                                            <i class="fas fa-trash"></i> Delete</button>
                                    </form>
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
                                    <div class="col-1 text-right">
                                        <form action="{{ route('super.announcements.pin', $announcement->encrypted_id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"><i
                                                    class="fas fa-thumbtack {{ $announcement->is_pinned ? 'text-primary' : '' }}"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="">
                                <h5 class="m-0 font-weight-bold">{{ $announcement->title }}</h5>
                                {!! $announcement->contents !!}
                            </div>
                            <div class="card-footer">
                                <a class="text-link"
                                    href="{{ route('super.announcements.show', $announcement->encrypted_id) }}">
                                    <i class="far fa-eye"></i> View</a>
                                <a class="text-success"
                                    href="{{ route('super.announcements.edit', $announcement->encrypted_id) }}">
                                    <i class="fas fa-pen-square"></i> Edit</a>
                                <form class="delete d-inline"
                                    action="{{ route('super.announcements.destroy', $announcement->encrypted_id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger">
                                        <i class="fas fa-trash"></i> Delete</button>
                                </form>
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
@endsection

@section('script')
    @include('layouts.superadmin.inc_delete')
@endsection
