@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Announcements</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Announcements</a></li>
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
                    <a href="{{ route('announcements.create') }}" class="btn btn-success">Create new Announcement</a>
                </div>
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
                                <a class="text-link" href="{{ route('announcements.show', $announcement->encrypted_id) }}">
                                    <i class="far fa-eye"></i> View</a>
                                <a class="text-success"
                                    href="{{ route('announcements.edit', $announcement->encrypted_id) }}">
                                    <i class="fas fa-pen-square"></i> Edit</a>
                                <form class="delete d-inline"
                                    action="{{ route('announcements.destroy', $announcement->encrypted_id) }}"
                                    method="POST">                                    @csrf
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
@endsection

@section('script')
    @include('layouts.superadmin.inc_delete')
@endsection
