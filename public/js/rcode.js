function runCode(code, language){

if(language == "php"){

$.post({
    url: PHP_ROUTE,
    data: {
        _token: TOKEN,
        data: code,
    },
    success: function (response) {
        if(response['success'] == true){
            $("#result").text(response['result']);
        } else {
            $("#result").text("Syntax error: " + response['result']);
        }
    },
    error: function (xhr, status, error) {
        $("#result").text("Error: " + error.message);
    },
});
} else if(language == 'js'){
    // We do this first we don't overwrite the default console.log
    console.compile = console.log;
    // Asign the value of console.log to window.$log
    console.log = function (data) {
        console.compile(data);
        window.$log = data;
    };

    try {
        "use strict";
        eval(`${code}`);
        $("#result").text($log);
    } catch (error) {
        $("#result").text("Syntax error: " + error.message);
    }
}
}