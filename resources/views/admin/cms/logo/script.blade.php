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

        const reader = new FileReader();
        
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
    
    });
</script>
