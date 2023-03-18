@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="/" class="text-info"><i class="right fas fa-angle-left"></i> Go Back</a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"></li>
                        <li class="breadcrumb-item active"></li>
                    </ol> --}}
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h2 class="text-center display-4">Search For Someone</h2>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form action="simple-results.html">
                        <div class="input-group">
                            <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here"
                                id="search-box">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="search-suggestion" class="bg-white" style="max-height: 150px; overflow:auto">

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#search-box").on("input", function() {
                const keyword = $(this).val();
                const route = "{{ route('search.portfolio') }}";
                $.get({
                    url: route,
                    method: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "keyword": keyword,
                    },
                    success: function(response) {
                        let html = '';
                        $.each(response, function(index, data) {
                            html +=
                                `<a href="/public_profile/` + data.id +`)">
                                    <div class="form-control m-0">` +
                                        data.name + `</div>
                                </a>`;
                        });
                        $("#search-suggestion").html(html);
                    }
                });
            });
        });
    </script>
@endsection
