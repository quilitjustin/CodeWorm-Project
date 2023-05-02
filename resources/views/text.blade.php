<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="{{ asset('codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('codemirror/theme/monokai.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <style>
        html,
        body {
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    <textarea name="" id="codeMirrorDemo"></textarea>
    <div class="bg-light p-3">
        Output: <span id="output"></span>
    </div>
    <button id="submit-btn" class="btn btn-success">Submit</button>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="{{ asset('codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('codemirror/addon/edit/matchbrackets.js') }}"></script>
    <script src="{{ asset('codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
    <script src="{{ asset('codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('codemirror/mode/clike/clike.js') }}"></script>
    <script src="{{ asset('codemirror/mode/php/php.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            const editor = CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                lineNumbers: true,
                matchBrackets: true,
                mode: {
                    name: "application/x-httpd-php",
                    startOpen: true,
                },
                indentUnit: 4,
                indentWithTabs: true,
                theme: "monokai",
            });
            $("#submit-btn").prop("disabled", true);

            $(editor.getWrapperElement()).on("keyup", function(){
                if(editor.getValue()){
                    $("#submit-btn").prop("disabled", false);
                } else {
                    $("#submit-btn").prop("disabled", true);
                }
            });
            
            const PHP_KEY = "68";
            const JAVA_KEY = "62";
            const CPP_KEY = "53";
            const PYTHON_KEY = "70";

            $("#submit-btn").click(function() {
                let code = editor.getValue();
                editor.setValue("");
                editor.clearHistory();
                $("#output").html("Loading...");
                console.log(code);
                let data = {
                    source_code: code,
                    language_id: PYTHON_KEY,
                    number_of_runs: "1",
                    stdin: "Judge0",
                    expected_output: null,
                    cpu_time_limit: "2",
                    cpu_extra_time: "0.5",
                    wall_time_limit: "5",
                    memory_limit: "128000",
                    stack_limit: "64000",
                    max_processes_and_or_threads: "60",
                    enable_per_process_and_thread_time_limit: false,
                    enable_per_process_and_thread_memory_limit: false,
                    max_file_size: "1024",
                    stderr: true,
                };
                console.log(data)
                let request = $.ajax({
                    url: "{{ env('APP_CODE_EXECUTOR') }}",
                    type: "post",
                    data: data,
                });

                const delay = (ms) => new Promise((res) => setTimeout(res, ms));
                // Callback handler that will be called on success
                request.done(async function(response, textStatus, jqXHR) {
                    // Log a message to the console
                    console.log("Hooray, it worked!");
                    let token = response.token;
                    await new Promise((resolve) => setTimeout(resolve, 5000)); // 5 sec
                    $.get({
                        url: BASE_URL + "/" + token,
                        success: function(response) {
                            console.log(response.stdout);
                            console.log(response.stderr);
                            $("#output").html(response.stdout);
                            if (response.stderr) {
                                $("#output").append("<br>" + response
                                .stderr); // append error output
                            }
                        },
                    });
                });
            });
        });
    </script>

</body>

</html>
