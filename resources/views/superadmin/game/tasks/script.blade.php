<!-- CodeMirror -->
<script src="{{ asset('codemirror/lib/codemirror.js') }}"></script>
<script src="{{ asset('codemirror/addon/edit/matchbrackets.js') }}"></script>
<script src="{{ asset('codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
<script src="{{ asset('codemirror/mode/xml/xml.js') }}"></script>
<script src="{{ asset('codemirror/mode/javascript/javascript.js') }}"></script>
<script src="{{ asset('codemirror/mode/css/css.js') }}"></script>
<script src="{{ asset('codemirror/mode/clike/clike.js') }}"></script>
<script src="{{ asset('codemirror/mode/php/php.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

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

    $("#advance").click(function() {
        if ($("#snippet").is(":hidden")) {
            $(this).text("Hide advanced options");
            $("#snippet").prop("hidden", false);
        } else {
            $(this).text("Show advanced options");
            $("#snippet").prop("hidden", true);
        }
    });

    $(document).ready(function() {
        $("#snippet").prop("hidden", true);

        // Summernote
        $("#summernote").summernote({
            height: 300,
            focus: true,
            // placeholder: 'write here...',
            codeviewIframeFilter: true,
            spellCheck: true
        });

        $("#run").click(function() {
            const language = $("#proglang option:selected").text();
            const code = editor.getValue();

            runCode(code, language.toLowerCase());
        });
    });
</script>
