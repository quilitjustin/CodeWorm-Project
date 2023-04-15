<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $(document).ready(function() {
        $.get({
            url: "{{ route('super.fetch.languages') }}",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                let html = '';
                $.each(response, function(index, data) {
                    html +=
                        `<option value="` + data.id + `">` + data.name + `</option>`;
                });
                $("#proglang").html(html);
                $("#proglang").prop("selectedIndex", -1);
            }
        });

        $('#proglang').change(function() {
            const id = $(this).val();
            $("#tasks").html("");
            $.post({
                url: "{{ route('super.fetch.tasks') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                success: function(response) {
                    console.log(response)
                    let html = '';
                    $.each(response, function(index, data) {
                        html +=
                            `<option value="` + data.id + `">` + data.name +
                            `</option>`;
                    });
                    $("#tasks").html(html);
                }
            });
        });
    });
</script>
