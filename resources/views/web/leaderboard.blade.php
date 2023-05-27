@extends('layouts.app')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center p-3"
        style="height: 100%; min-height: 100vh; background-image: url('{{ asset('assets/bgim/leaderboard.png') . '?v=' . filemtime(public_path('assets/bgim/leaderboard.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center text-light mt-4">
                    <h1 class="font-weight-bold">
                        Leaderboards</h1>
                    <p class="lead">
                        The worlds finest Procrastirnators
                    </p>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card card-navy">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title font-weight-bold d-inline mr-1">Rankings of Top 100</h3>
                                <i class="fas fa-question-circle d-inline" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Hello"></i>
                            </div>
                            <div class="col-md-6">
                                <select class="select2" id="language" name="language" data-placeholder="Select a Language"
                                    style="width: 100%;">
                                    <option value="">Select a Language</option>
                                    @forelse ($proglangs as $proglang)
                                        <option value="{{ $proglang->encrypted_id }}">
                                            {{ $proglang->name }}
                                        </option>
                                    @empty
                                        <option value="">No language available.</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="d-none" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"
                        id="tbl-preloader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="card-body" id="records">
                        <table id="data-table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <th>Highest Stage Cleared</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-sm-12">
                <a href="{{ route('web.play.index') }}" class="btn btn-dark">
                    <i class="right fas fa-angle-left"></i> Go
                    Back</a>
            </div>
            <!-- /.col -->
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    {{-- Lodash --}}
    <script src="{{ asset('js/lodash.js') }}"></script>

    <script>
        // From bootstrap documentation
        // https://getbootstrap.com/docs/5.1/components/tooltips/
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        // Datatable
        $(function() {
            $("#data-table").DataTable({
                "aaSorting": [],
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "emptyTable": "No data available"
                }
            }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

            $("#language").on("change", _.debounce(function() {
                const table = $('#data-table').DataTable();
                const selectedOption = $(this).val();
                $.post({
                    url: "{{ route('web.leaderboards.entry') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: selectedOption
                    },
                    beforeSend: function() {
                        $("#tbl-preloader").removeClass("d-none");
                    },
                    complete: function() {
                        $("#tbl-preloader").addClass("d-none");
                    },
                    success: function(response) {
                        table.clear();

                        if (response.length > 0) {
                            $.each(response, function(index, record) {
                                table.row.add([
                                    index + 1,
                                    "<a href='/public_profile/" + record
                                    .users.encrypted_id + "'><img src='" + (
                                        record.users.profile_picture ?
                                        record.users.profile_picture :
                                        "https://ui-avatars.com/api/?name=" +
                                        record.users.f_name + "+" + record
                                        .users.l_name) +
                                    "' class='img-circle mr-2' style='width: 35px; height: 35px; max-width: 35px; max-height: 35px;' />" +
                                    record.users.f_name + " " + record.users
                                    .l_name + "</a>",
                                    record.total_stages_cleared + " Stages",
                                    record.total_time
                                ]).draw(false).node();
                            });
                            table.draw();
                        } else {
                            table.draw();
                        }
                    },
                    error: function(error) {
                        // console.log(error)
                    }
                });
            }, 500)); // Debounce for 500ms

        });
    </script>
@endsection
