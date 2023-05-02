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
        #canvas1 {
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

        #narrative-overlay {
            position: absolute;
            bottom: 3%;
        }

        #splash-overlay {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.7);
            height: 100%;
            width: 100%;
            z-index: 2;
        }

        #splash-overlay div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader">
            <div style="margin: auto;">
                <img class="d-block" style="background-color: transparent;" src="{{ asset('assets/img/logo.png') }}"
                    alt="logo" height="150" width="150">
                <div class="spinner-border mt-3 d-block mx-auto" style="" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <div id="main">
        <div id="splash-overlay">
            <div>
                <h1 class="text-light font-weight-bold text-center">Welcome to Codeworm my dear Procrastinator</h1>
                <button id="start" class="btn btn-default mx-auto d-block">Start</button>
            </div>
        </div>
        <audio id="bgm" class="d-none" src="{{ asset('js/prologue.mp3') }}" controls loop></audio>
        <canvas id="canvas1"></canvas>
        <img id="bg1" src="{{ asset('game/BackgroundImage/1682176636-tmp.png') }}" class="d-none"
            alt="background image">
        <div class="buttons-overlay" hidden>
            <button class="btn btn-light shadow-sm" id="backButton">Back</button>
            <button class="btn btn-light shadow-sm" id="nextButton">Next</button>
            <button class="btn btn-light shadow-sm" id="skipButton">Skip</button>
            <button class="btn btn-light shadow-sm" id="fullScreenButton">Full
                Screen</button>
            <button class="btn btn-light shadow-sm" id="exitFullScreenButton" hidden>Exit Full
                Screen</button>
        </div>
        <div id="narrative-overlay" class="w-100 p-3" hidden>
            <div class="text-white w-100 p-3" style="background-color: rgba(0, 0, 0, 0.7);">
                <p class="h-5 font-weight-bold">Unknown</p>
                <p class="h-6" id="dialogue"></p>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <script>
        $(document).ready(function() {
            let canvas, ctx;
            let img1, img2, img3, img4, img5, img6;
            let currentScene = 0;
            let backButton, skipButton, nextButton;
            const arr = [
                "There was a god who was omnipotent and omniscient in a universe unlike any other. For years, people had worshiped this deity, who had given them direction and safety. But one day the deity suddenly vanished, leaving behind bits of worms of code.",
                "It was said that the code worms were dispersed around the country and that the powers of the god would pass to the person who could collect them all. The most daring and ambitious explorers start on a quest to locate the code worm fragments and obtain the god's inheritance.",
                "The group's trek brought them to a tower that protruded far into the sky, and it was rumored that there were numerous elusive beings and creatures guarding the god's code worm fragments there. The adventurers encountered many difficulties as they ascended the tower, fending off hazardous animals and completing challenging puzzles to reach each floor.",
                "But as they gained strength from each triumph, they eventually reached the pinnacle of the tower. They discovered a powerful person there who was the final keeper of the god's fragments. The explorers battled the being in a ferocious struggle, employing all of their abilities to vanquish it.",
                "After taking down the last guardian, the explorers were able to finally take possession of the god's inheritance—the bits of his code worms. However, they were unaware that their journey had only just begun because the powers they had attained were much more than they had ever anticipated, and carrying the weight of being the god's heirs would be a tremendous load."
            ];
            const numScenes = arr.length;
            $("#start").click(function() {
                $(this).parent().parent().fadeOut();
                const bgm = document.getElementById("bgm");
                bgm.volume = 0.3;
                bgm.play();
                $(".buttons-overlay").prop("hidden", false);
                $("#narrative-overlay").prop("hidden", false);
                narrative();
            });
            canvas = document.getElementById("canvas1");
            ctx = canvas.getContext("2d");
            canvas.width = $(window).width();
            canvas.height = $(window).height();
            img1 = document.getElementById("bg1");
            backButton = document.getElementById("backButton");
            skipButton = document.getElementById("skipButton");
            nextButton = document.getElementById("nextButton");
            backButton.addEventListener("click", function() {
                if (currentScene > 0) {
                    currentScene--;
                    narrative();
                }
            });
            skipButton.addEventListener("click", function() {
                location.href = "{{ route('web.play.index') }}";
            });
            nextButton.addEventListener("click", function() {
                if (currentScene < numScenes - 1) {
                    currentScene++;
                    narrative();
                } else {
                    location.href = "{{ route('web.play.index') }}";
                }
            });

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img1, 0, 0, canvas.width, canvas.height);
                requestAnimationFrame(draw);
            }
            draw();

            let intervalId;

            function narrative() {
                clearInterval(intervalId);
                $("#dialogue").text("");
                // Get the current scene's dialogue text
                const dialogue = arr[currentScene];

                // Split the text into individual characters
                const letters = dialogue.split('');

                let i = 0;

                // Use setInterval to add a delay between each letter
                intervalId = setInterval(() => {
                    // Add the next letter to the dialogue element
                    $("#dialogue").text($("#dialogue").text() + letters[i]);

                    i++;

                    // If all letters have been added, clear the interval
                    if (i === letters.length) {
                        clearInterval(intervalId);
                    }
                }, 20); // Change this value to adjust the delay between letters
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
        });
    </script>
</body>

</html>
