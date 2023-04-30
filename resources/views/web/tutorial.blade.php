<!DOCTYPE html>
<html>

<head>
    @include('layouts.meta')

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <style type="text/css">
        #myCanvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .buttons-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }

        .buttons-overlay button {
            margin-right: 10px;
        }
    </style>
</head>

<body onload="init()">
    <div id="main">
        <canvas id="myCanvas"></canvas>
        <div class="buttons-overlay">
            <button class="btn btn-outline-light shadow-sm" id="backButton">Back</button>
            <button class="btn btn-outline-light shadow-sm" id="nextButton">Next</button>
            <button class="btn btn-outline-light shadow-sm" id="skipButton">Skip</button>
            <button class="btn btn-outline-light shadow-sm" id="fullScreenButton">Full
                Screen</button>
            <button class="btn btn-outline-light shadow-sm" id="exitFullScreenButton" hidden>Exit Full
                Screen</button>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        var canvas, ctx;
        var img1, img2, img3;
        var currentScene = 1;
        var numScenes = 3;
        var backButton, skipButton, nextButton;

        function init() {
            canvas = document.getElementById("myCanvas");
            ctx = canvas.getContext("2d");
            canvas.width = $(window).width();
            canvas.height = $(window).height();
            img1 = new Image();
            img2 = new Image();
            img3 = new Image();
            img1.src = "{{ asset('game/BackgroundImage/1682176636-tmp.png') }}";
            img2.src = "{{ asset('game/BackgroundImage/1682405753-Code Worm.png') }}";
            img3.src = "{{ asset('game/BackgroundImage/1682437111-Background 4.jpg') }}";
            backButton = document.getElementById("backButton");
            skipButton = document.getElementById("skipButton");
            nextButton = document.getElementById("nextButton");
            backButton.addEventListener("click", function() {
                if (currentScene > 1) {
                    currentScene--;
                }
            });
            skipButton.addEventListener("click", function() {
                currentScene = numScenes;
            });
            nextButton.addEventListener("click", function() {
                if (currentScene < numScenes) {
                    currentScene++;
                } else {
                    currentScene = 1;
                }
            });
            requestAnimationFrame(draw);
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            switch (currentScene) {
                case 1:
                    ctx.drawImage(img1, 0, 0, canvas.width, canvas.height);
                    break;
                case 2:
                    ctx.drawImage(img2, 0, 0, canvas.width, canvas.height);
                    break;
                case 3:
                    ctx.drawImage(img3, 0, 0, canvas.width, canvas.height);
                    break;
            }
            requestAnimationFrame(draw);
        }

        $("#fullScreenButton").click(function() {
            const main = document.getElementById("main");
            if (main.requestFullscreen) {
                main.requestFullscreen();
            } else if (main.msRequestFullscreen) {
                main.msRequestFullscreen();
            } else if (main.mozRequestFullScreen) {
                main.mozRequestFullScreen();
            } else if (main.webkitRequestFullscreen) {
                main.webkitRequestFullscreen();
            }
        });

        $("#exitFullScreenButton").click(function() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        });

        document.addEventListener("fullscreenchange", function() {
            const isFullscreen = Boolean(document.fullscreenElement);
            const fullScreenButton = document.getElementById("fullScreenButton");
            const exitFullscreenButton = document.getElementById("exitFullScreenButton");
            fullScreenButton.hidden = isFullscreen;
            exitFullscreenButton.hidden = !isFullscreen;
        });
    </script>
</body>

</html>
