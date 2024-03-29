<div class="modal fade" id="confirm-delete">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Deletion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Are you sure you want to delete this record?
                    <br>
                    Important Reminder: Deleting records are extremely risky and not recommended.
                </p>

                <div class="form-group">
                    <label>
                        If you understand the risks and still wish to proceed.
                        <br>
                        Please type "<span id="condition">I understand</span>"
                    </label>
                    <input class="form-control" type="text" id="confirmation" placeholder="Please confirm" />
                    <span id="err-msg"></span>
                </div>
                <!-- /.form-group -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button id="confirm-btn" type="button" class="btn btn-outline-light">Confirm</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    $(document).ready(function() {
        let form = "";
        $(".delete").submit(function(e) {
            e.preventDefault();
            $("#err-msg").text("");
            $("#confirmation").val("")
            $("#confirm-delete").modal("show");
            form = $(this);
        });
        $("#confirm-btn").click(function() {
            const answer = $("#confirmation").val();
            const condition = $("#condition").text();
            if (answer == condition) {
                form.unbind().submit();
                $("#confirm-delete").modal("hide");
            } else {
                $("#err-msg").text("Incorrect, please try again.");
            }
        });
    });
</script>
