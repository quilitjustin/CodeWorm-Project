<script>
    const imageFile = $("#image");
    const preview = $("#img-preview");
    const previewBody = $("#preview");

    imageFile.on("change", function(e) {
        // Replace label inside input 
        const fileName = $(this).val();
        $(this).next(".custom-file-label").html(fileName);

        // Show image preview
        const item = e.target.files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function() {
            preview.attr("src", reader.result);
            previewBody.removeClass("d-none");
        }, false);

        if (item) {
            reader.readAsDataURL(item);
        }
    });

    $("#clear").click(function() {
        imageFile.val("");
        imageFile.next(".custom-file-label").html("Choose Image");
        previewBody.addClass("d-none");
        preview.attr("src", "#");
    });
</script>
