<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    let imgDetails = {!! $cmsbgims !!};

    let idx = "";
    let visibility = false;

    $(".img-toggle").click(function() {
        $(".img-toggle").removeClass("border border-primary col-md-4");
        if (!visibility) {
            $(".img-toggle").addClass("col-12");
            $("#images").removeClass("col-12");
            $("#images").addClass("col-md-6");
            $("#settings").removeClass("d-none");
            visibility = true;
        }

        $(this).addClass("border border-primary");

        idx = $(this).index();

        $("#img-preview").prop("src", "{{ asset('') }}" + imgDetails[idx]["path"]);
        $("#created-by").text(imgDetails[idx]["created_by_user"]["f_name"] + " " + imgDetails[idx]["created_by_user"]["l_name"]);
        const postDate = moment(imgDetails[idx]["created_at"]);
        const timeDifference = postDate.fromNow(); // "a day ago"
        $("#created-at").text(timeDifference);
    });

    $("#set-bg").click(function() {
        $.post({
            url: route,
            data: {
                _token: "{{ csrf_token() }}",
                path: imgDetails[idx]['path'],
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    $(document).ready(function() {
        $("#delete").click(function() {
            $("#err-msg").text("");
            $("#confirmation").val("")
            $("#confirm-delete").modal("show");
        });
        $("#confirm-btn").click(function() {
            const answer = $("#confirmation").val();
            const condition = $("#condition").text();
            if (answer == condition) {
                $.ajax({
                    url: "{{ route('super.cms.bgim.destroy', '') }}/" + imgDetails[idx]['encrypted_id'],
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
                // window.location.reload();
                $(".img-toggle").eq(idx).remove();
                $("#confirm-delete").modal("hide");
                $(".img-toggle").removeClass("col-12");
                $("#images").addClass("col-12");
                $("#images").removeClass("col-md-6");
                $("#settings").addClass("d-none");
                visibility = false;
            } else {
                $("#err-msg").text("Incorrect, please try again.");
            }
        });
    });
</script>
