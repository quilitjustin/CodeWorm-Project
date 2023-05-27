@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center p-3"
        style="height: 100%; min-height: 100vh; background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.9)), url('{{ asset('assets/bgim/leaderboard.png') . '?v=' . filemtime(public_path('assets/bgim/leaderboard.png')) }}');)">

        <div class="row">
            <div class="col-12">
                <h2 class="text-center display-4 text-white font-weight-bold">Search For Someone</h2>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <form action="simple-results.html">
                            <div class="input-group">
                                <input type="search" class="form-control form-control-lg"
                                    placeholder="Type your keywords here" id="search-box">
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
            <div class="col-12 text-center">
                <a href="{{ route('web.play.index') }}" class="btn btn-dark mt-3">Go
                    Back</a>
            </div>
        </div>
    </div>
    </section>
@endsection

@section('script')
    {{-- Lodash --}}
    <script src="{{ asset('js/lodash.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#search-box").on("input", _.debounce(function() {
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
                                `<a href="/public_profile/` + data.encrypted_id + `)">
                                    <div class="form-control m-0">` +
                                data.name + `</div>
                                </a>`;
                        });
                        $("#search-suggestion").html(html);
                    }
                });
            }, 300));
        });
    </script>
@endsection
