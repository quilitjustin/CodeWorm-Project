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

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let TOTAL_NOTIFICATION = 0;
        let TOTAL_REGISTRATION_REQUEST = 0;
        
        $("#user-reg-count").text(TOTAL_REGISTRATION_REQUEST);
        // $.get({
        //     url: "{{ route('super.analytics.user_reg_count') }}",
        //     data: {
        //         _token: "{{ csrf_token() }}",
        //     },
        //     success: function(response) {
        //         // Inside nav.blade.php, in notifications
        //         TOTAL_NOTIFICATION = response.count;
        //         $("#user-reg-count").text(TOTAL_REGISTRATION_REQUEST);
        //         TOTAL_REGISTRATION_REQUEST += response.count;
        //         $("#total-notification").text(TOTAL_NOTIFICATION);
        //     }
        // });

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('e32d80a9a34cf1f5eaa9', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('user-request-registration');
        channel.bind('my-event', function(data) {
            TOTAL_REGISTRATION_REQUEST += 1;
            TOTAL_NOTIFICATION += 1;

            $("#user-reg-count").text(TOTAL_REGISTRATION_REQUEST);
            $("#total-notification").text(TOTAL_NOTIFICATION);
        });
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
