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
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
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

        @include('layouts.web.nav')

        @include('layouts.web.sidebar')



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
    <!-- Toastr -->
    <script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
    {{-- Pusher --}}
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const cacheValue = localStorage.getItem('pending_announcement');
        if (cacheValue !== null && cacheValue !== undefined) {
            $("#total-notification").addClass("badge badge-warning navbar-badge");
            $("#total-notification").text("!");
            $("#notif-parent").append(`   <div class="dropdown-divider"></div>
                <a href="{{ route('web.announcements.index') . '#latest' }}" class="dropdown-item">
                    {{-- This will be updated with ajax inside app.blade.php --}}
                    <i class="fas fa-scroll mr-2"></i> <span id="user-reg-count"></span> New Announcement
                    <span class="float-right text-muted text-sm"></span>
                </a>
                <div class="dropdown-divider"></div>`);
            $("#announcement-badge").addClass("right badge badge-danger");
            $("#announcement-badge").text("!");
        } else {
            Pusher.logToConsole = true;

            var pusher = new Pusher('e32d80a9a34cf1f5eaa9', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('announcement');
            channel.bind('my-event', function(data) {
                localStorage.setItem('pending_announcement', true);
                $("#total-notification").addClass("badge badge-warning navbar-badge");
                $("#total-notification").text("!");
                $("#notif-parent").append(`   <div class="dropdown-divider"></div>
        <a href="{{ route('web.announcements.index') . '#latest' }}" class="dropdown-item">
            {{-- This will be updated with ajax inside app.blade.php --}}
            <i class="fas fa-scroll mr-2"></i> <span id="user-reg-count"></span> New Announcement
            <span class="float-right text-muted text-sm"></span>
        </a>
        <div class="dropdown-divider"></div>`);
                $("#announcement-badge").addClass("right badge badge-danger");
                $("#announcement-badge").text("!");
            });
        }
    </script>

    @yield('script')

    @if (session()->has('msg'))
        <script>
            toastr.success("{{ session()->get('msg') }}");
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            toastr.error("{{ session()->get('error') }}");
        </script>
    @endif
</body>

</html>
