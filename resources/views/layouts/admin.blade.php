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
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/codemirror/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/codemirror/theme/monokai.css') }}">

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
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('layouts.nav')

        @include('layouts.sidebar')

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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // Summernote
            // $('#summernote').summernote({
            //         height: 150,
            //         focus: true,
            //         placeholder: "Write something here",
            //         codeviewIframeFilter: true,
            //         spellCheck: true
            //     }
            // );

            // CodeMirror
            // CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            //     mode: "htmlmixed",
            //     theme: "monokai"
            // });
        });
    </script>

    @yield('script')

</body>

</html>
