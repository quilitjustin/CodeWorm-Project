<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
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
    });
</script>
