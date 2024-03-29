<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.meta')

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/codemirror/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/codemirror/theme/monokai.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    @yield('css')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <style>
        /* Remove Default WhiteSpace */
        html,
        body {
            padding: 0;
            margin: 0;
        }

        /* Remove Default btn css */
        button {
            background: none;
            color: inherit;
            border: none;
            padding: 0;
            font: inherit;
            cursor: pointer;
            outline: inherit;
        }

        .sidebar-collapse .logout-text {
            display: none;
        }

        .sidebar:hover .logout-text {
            display: inline;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('layouts.superadmin.nav')

        @include('layouts.superadmin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main Content-->

            @yield('content')

            <!-- /.content -->
        </div>

        @include('layouts.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- CodeMirror -->
    <script src="{{ asset('adminlte/plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
    {{-- Pusher --}}
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    @include('layouts.loading')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const cacheValue = localStorage.getItem('pending_registration');
        if (cacheValue !== null && cacheValue !== undefined) {
            $("#total-notification").addClass("badge badge-warning navbar-badge");
            $("#total-notification").text("!");
            $("#registration-badge").addClass("right badge badge-danger");
            $("#registration-badge").text("!");
            $("#notif-parent").append(`              <div class="dropdown-divider"></div>
                <a href="{{ route('super.request_registration.index') }}" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i></span> New registration requests
                </a>
                <div class="dropdown-divider"></div>`);
        } else {

            var pusher = new Pusher('e32d80a9a34cf1f5eaa9', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('user-request-registration');
            channel.bind('my-event', function(data) {
                localStorage.setItem('pending_registration', true);

                $("#total-notification").addClass("badge badge-warning navbar-badge");
                $("#total-notification").text("!");
                $("#registration-badge").addClass("right badge badge-danger");
                $("#registration-badge").text("!");
                $("#notif-parent").append(`              <div class="dropdown-divider"></div>
                <a href="{{ route('super.request_registration.index') }}" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i></span> New registration requests
                </a>
                <div class="dropdown-divider"></div>`);
            });
        }

        const cacheReports = localStorage.getItem('pending_reports');
        if (cacheReports !== null && cacheReports !== undefined) {
            $("#total-notification").addClass("badge badge-warning navbar-badge");
            $("#total-notification").text("!");
            $("#notif-parent").append(`   <div class="dropdown-divider"></div>
                <a href="{{ route('super.reports.index') . '#latest' }}" class="dropdown-item">
                    <i class="fas fa-flag mr-2"></i> New Reports
                    <span class="float-right text-muted text-sm"></span>
                </a>
                <div class="dropdown-divider"></div>`);
            $("#reports-badge").addClass("right badge badge-danger");
            $("#reports-badge").text("!");
        } else {
            var pusher = new Pusher('e32d80a9a34cf1f5eaa9', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('reports');
            channel.bind('my-event', function(data) {
                localStorage.setItem('pending_reports', true);
                $("#total-notification").addClass("badge badge-warning navbar-badge");
                $("#total-notification").text("!");
                $("#notif-parent").append(`   <div class="dropdown-divider"></div>
                <a href="{{ route('super.reports.index') }}" class="dropdown-item">
                    <i class="fas fa-flag mr-2"></i> New Reports
                    <span class="float-right text-muted text-sm"></span>
                </a>
                <div class="dropdown-divider"></div>`);
                $("#reports-badge").addClass("right badge badge-danger");
                $("#reports-badge").text("!");
            });
        }
    </script>

    @yield('script')

    @if (session()->has('msg'))
        <script>
            toastr.success("{{ session()->get('msg') }}");
        </script>
    @endif

    @if (session()->has('errmsg'))
        <script>
            toastr.error("{{ session()->get('errmsg') }}");
        </script>
    @endif
</body>

</html>
