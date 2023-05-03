@include('layouts.admin.delete')

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
<script>
    // Datatable
    $(function() {
        $("#data-table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            // "copy", "csv", "excel", "pdf", "print"
            "buttons": [{
                    "extend": "copyHtml5",
                    "title": "Export Data",
                    "exportOptions": {
                        "columns": ':not(:last-child)'
                    }
                },
                {
                    "extend": "csvHtml5",
                    "title": "Export Data",
                    "exportOptions": {
                        "columns": ':not(:last-child)'
                    }
                },
                {
                    "extend": "excelHtml5",
                    "title": "Export Data",
                    "exportOptions": {
                        "columns": ':not(:last-child)'
                    }
                },
                {
                    "extend": "pdfHtml5",
                    "title": "Export Data",
                    "exportOptions": {
                        "columns": ':not(:last-child)',
                    }
                },
                {
                    "extend": "print",
                    "title": "Export Data",
                    "exportOptions": {
                        "columns": ':not(:last-child)'
                    }
                },
            ]
        }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');
    });
</script>
