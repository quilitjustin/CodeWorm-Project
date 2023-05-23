<!-- CodeMirror -->
<script src="{{ asset('codemirror/lib/codemirror.js') }}"></script>
<script src="{{ asset('codemirror/addon/edit/matchbrackets.js') }}"></script>
<script src="{{ asset('codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
<script src="{{ asset('codemirror/mode/xml/xml.js') }}"></script>
<script src="{{ asset('codemirror/mode/javascript/javascript.js') }}"></script>
<script src="{{ asset('codemirror/mode/css/css.js') }}"></script>
<script src="{{ asset('codemirror/mode/clike/clike.js') }}"></script>
<script src="{{ asset('codemirror/mode/php/php.js') }}"></script>
<script>
    // We do this first we don't overwrite the default console.log
    console.compile = console.log;
    // Asign the value of console.log to window.$log
    console.log = function(data) {
        console.compile(data);
        window.$log = data;
    };

    // lets make php default
    let LANG_KEY = 68;
    let language = 'php';
    const PHP_ROUTE = "{{ asset('demo/api/v1/php_api.php') }}";

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
        $("#execute-code").prop("disabled", true);

        $(editor.getWrapperElement()).on("keyup", function() {
            if (editor.getValue()) {
                $("#execute-code").prop("disabled", false);
            } else {
                $("#execute-code").prop("disabled", true);
            }
        });

        $("#proglang").on("change", function() {
            const selectedOption = $(this).find('option:selected');
            LANG_KEY = selectedOption.data('key');
            const selectedText = selectedOption.text();
            language = selectedText.trim().toLowerCase();
            console.log(language)
        });

        $("#execute-code").click(function() {
            let code = editor.getValue();
            $("#output").html("Loading...");
            switch (language) {
                case "php":
                    $.post({
                        url: PHP_ROUTE,
                        data: {
                            _token: "{{ csrf_token() }}",
                            data: code,
                        },
                        success: function(response) {
                            $("#output").text("");
                            $("#output").append(response["result"]);
                        },
                        error: function(xhr, status, error) {

                        },
                    });

                    break;
                case "javascript":
                    try {
                        ("use strict");
                        eval(`${code}`);

                        $("#output").text("");
                        $("#output").append(window.log);
                    } catch (error) {

                    }

                    break;
                default:
                    let data = {
                        source_code: code,
                        language_id: LANG_KEY,
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

                    let request = $.ajax({
                        url: "{{ env('APP_CODE_EXECUTOR') }}",
                        type: "post",
                        data: data,
                    });

                    const delay = (ms) => new Promise((res) => setTimeout(res, ms));
                    // Callback handler that will be called on success
                    request.done(async function(response, textStatus, jqXHR) {
                        // Log a message to the console

                        let token = response.token;
                        await new Promise((resolve) => setTimeout(resolve, 3000)); // 3 sec
                        $.get({
                            url: "{{ env('APP_CODE_EXECUTOR') }}" + "/" + token,
                            success: function(response) {
                                $("#output").html(response.stdout);
                                if (response.stderr) {
                                    $("#output").text("");
                                    $("#output").append("<br>" + response
                                        .stderr); // append error output
                                }
                            },
                        });
                    });
            }
        });
    });
</script>
