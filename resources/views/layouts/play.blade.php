<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/codemirror/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/codemirror/theme/monokai.css') }}">
    {{-- Game --}}
    <link rel="stylesheet" href="{{ asset('demo/style.css') }}">
    <style>
        .CodeMirror {
            height: 300px !important;
            padding: 20px;
        }
    </style>
</head>

<body style="background: #0E1525;">
    <div id="game" hidden>
        <div id="con" class="d-flex justify-content-center">
            <canvas id="canvas1"></canvas>
            <img id="playerImage" src="{{ asset('demo/player.png') }}" alt="player">
            <img id="backgroundImage" src="{{ asset('demo/background_single.png') }}" alt="bg-image">
            <img id="enemyImage" src="{{ asset('demo/enemy_1.png') }}" alt="enemy">
            <img id="life" src="{{ asset('demo/heart.png') }}" alt="life">
            <img id="boom" src="{{ asset('demo/boom.png') }}" alt="boom">
            <audio id="bgm" src="{{ asset('demo/bgm2.mp3') }}" controls loop></audio>
            <audio id="sfx" src="{{ asset('demo/boom.wav') }}" controls></audio>
            <button hidden id="fullScreenButton">Full Screen</button>
            <div id="overlay" class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 id="msg" class="text-white">

                    </h1>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div id="content" class="row">
                <div class="col-md-3 bg-blurr rounded" style="padding: 0;">
                    <button id="tackle" class="btn btn-primary w-100 shadow-sm fw-bold">
                        Tackle
                        <br>
                        <span class="fw-normal">
                            DMG 5 SP 5
                        </span>
                    </button>
                </div>
                <div class="col-md-6 p-0">
                    {{-- <div id="editor" class="row rounded" style="height: 330px; z-index: -10; background: #080c16;">
                    </div> --}}
                    
                    <textarea name="" id="codeMirrorDemo" cols="30" rows="10">// Print Hello World</textarea>
                    <button id="submit" class="btn btn-primary w-100">Submit</button>
                </div>
                <div class="col-md-3 bg-blurr p-3 text-white rounded">
                    <p>Error Console:</p>
                    <p id="err-console"></p>
                </div>
            </div>
        </div>
    </div>
    <div id="playBtn" class="d-flex justify-content-center align-items-center"
        style="z-index: -99999; width: 100vw; height: 100vh;">
        <button class="btn btn-primary">Play!</button>
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
    <!-- CodeMirror -->
    <script src="{{ asset('adminlte/plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/codemirror/mode/javascript/javascript.js') }}"></script>
    <script>
        const editor = CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            mode: "javascript",
            theme: "monokai",
        });
    </script>
    {{-- Game --}}
    <script src="{{ asset('demo/script.js') }}"></script>
</body>

</html>
