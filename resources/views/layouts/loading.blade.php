<div class="modal fade" id="loading-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <img class="img-fluid" width="150" height="150"
                    src="{{ asset('assets/logo/logo.png') . '?v=' . filemtime(public_path('assets/logo/logo.png')) }}"><br>
                <div class="spinner-border text-dark" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    $('#loading-modal').attr('data-backdrop', 'static');
</script>
