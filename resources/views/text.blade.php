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
    {{ encrypt("Hello world") }}
    {{ decrypt("eyJpdiI6IkZXWk53SXhjTGJmSzN4dW1EeEFqdEE9PSIsInZhbHVlIjoiak0yazJFUHlMeisraWZqZ25PcXA3aGg3U0FZZnNCc3pCNldwM3kyTXN4MD0iLCJtYWMiOiI3NjA5NGQ1ZjlmMDA4YTFhODNjNmQzODlhNjI0ZDMzZDI5ZGI2NmEwN2Y1YjU2YTY1YmRiOTQzMTg5Y2YyNmI5IiwidGFnIjoiIn0=") }}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: "{{ asset('demo/test.php') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "data" : `function myFunc(){
                    return "Hello World";
                } return myfunc();`,
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