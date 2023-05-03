<script>
    $("#cancel").click(function() {
        window.history.back();
    });

    function stopHistory() {
        const location = window.location.href;
        // Replace the current history entry with the form's action URL so the window.history.back() would work properly even after the form got a respnse of 422
        history.replaceState(null, "", location);
    }

    stopHistory();
</script>
