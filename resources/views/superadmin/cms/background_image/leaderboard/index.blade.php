@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Background Images</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('cmsleaderboards.index') }}">cmsleaderboards</a></li>
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
                <div id="images" class="col-6">
                    <div class="card card-indigo">
                        <div class="card-header">
                            <h3 class="card-title">Available Images</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                @forelse ($cmsleaderboards as $cmsleaderboard)
                                    <div class="img-toggle col-md-12 p-2 d-flex justify-content-center align-items-center">
                                        <img src="{{ asset($cmsleaderboard->path) }}"
                                            style="height: 150px; max-height: 150px" alt="picture">
                                    </div>
                                @empty
                                    No Records
                                @endforelse
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="{{ route('cmsleaderboards.create') }}" class="btn btn-primary">Upload New Image</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div id="settings" class="col-6">
                    <div class="card card-indigo">
                        <div class="card-header">
                            <h3 class="card-title">Image Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-secondary">
                                    <img src="#" id="img-preview">
                                    <p>
                                        Creted By:
                                        <span id="created-by"></span>
                                        <br>
                                        Date of Creation:
                                        <span id="created-at"></span>
                                    </p>
                                    <button id="set-bg" class="btn btn-primary">Set as background</button>
                                </div>
                            </div>
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
    @include('layouts.superadmin.delete')
    <script>
        let imgDetails = {!! $cmsleaderboards !!};
        
        let idx = "";

        $(".img-toggle").click(function() {
            $(".img-toggle").removeClass("border border-primary");

            $(this).addClass("border border-primary");

            idx = $(this).index();

            $("#img-preview").attr("src", `{{ asset(` + imgDetails[idx]["path"] + `) }}`);
            $("#created-by").text(imgDetails[idx]["created_by"]);
            $("#created-at").text(imgDetails[idx]["created_at"]);
        });

        $("#set-bg").click(function() {
            const route = "{{ route('super.cms.leaderboard') }}";

            $.post({
                url: route,
                data: {
                    _token: "{{ csrf_token() }}",
                    path: imgDetails[idx]['path'],
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
