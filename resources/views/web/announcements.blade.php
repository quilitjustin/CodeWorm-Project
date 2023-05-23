@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.9)), url('{{ asset('assets/bgim/announcement.png') . '?v=' . filemtime(public_path('assets/bgim/announcement.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-light font-weight-bold">Announcements</h1>
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
                            <h4 class="text-light">Pinned Announcements</h4>
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
                                    <div class="card-body" style="overflow:hidden;">
                                        <h5 class="m-0 font-weight-bold">{{ $pin->title }}</h5>
                                        {!! $pin->contents !!}
                                        <div class="d-none read-more justify-content-center"
                                            style="position: absolute; bottom: 0; left: 0; background-color: rgba(255, 255, 255, 0.7); width: 100%;">
                                            <button class="btn btn-outline-primary my-2">Show More</button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    @endif
                    <div class="col-12" id="latest">
                        <h4 class="text-light">Latest Announcements</h4>
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
                                    <div class="d-none read-more justify-content-center"
                                        style="position: absolute; bottom: 0; left: 0; background-color: rgba(255, 255, 255, 0.7); width: 100%;">
                                        <button class="btn btn-outline-primary my-2">Show More</button>
                                    </div>
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

@section('script')
    <script>
        if (cacheValue !== null && cacheValue !== undefined) {
            localStorage.removeItem('pending_announcement');
            location.reload();
        }

        $(document).ready(function() {
            const maxContentHeight = 150;

            $('.card-body').each(function() {
                let contentHeight = $(this).height();

                if (contentHeight > maxContentHeight) {
                    $(this).css('max-height', maxContentHeight + 'px');
                    $(this).append("<a href='#' class='read-less'>Show Less</a>");
                    $(this).children('.read-more').removeClass("d-none");
                    $(this).children('.read-more').addClass("d-flex");
                }
            });

            $('.read-less').click(function(e) {
                e.preventDefault();
                $(this).parent().css('max-height', maxContentHeight + 'px');
                $(this).parent().children(".read-more").removeClass("d-none");
                $(this).parent().children(".read-more").addClass("d-flex");
            });

            $('.read-more button').click(function(e) {
                e.preventDefault();
                let $content = $(this).parent().parent();
                $content.css('max-height', 'none');
                $(this).parent().removeClass("d-flex");
                $(this).parent().addClass("d-none");
            });
        });
    </script>
@endsection
