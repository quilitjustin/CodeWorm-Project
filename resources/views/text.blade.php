<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        html, body{
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: "{{ asset('demo/api/v1/python.py') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "data" : 'print("Hello, world!")',
            },
            success: function(response){
                console.log(response);
            },
            error: function(xhr, status, error){
                console.log("Error: " + error.message);
            }
        });
    </script>
</body>
</html>