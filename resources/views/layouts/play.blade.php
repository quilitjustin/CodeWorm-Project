<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.meta')
    <!-- CodeMirror -->
    <link rel="stylesheet" href="{{ asset('codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('codemirror/theme/monokai.css') }}">
    {{-- Game --}}
    <link rel="stylesheet" href="{{ asset('demo/style.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body style="background: #0E1525;">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader">
            <div style="margin: auto;">
                <img class="d-block" src="{{ asset('assets/img/logo.png') }}" alt="logo" height="150"
                    width="150">
                <div class="spinner-border mt-3 d-block mx-auto" style="" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <div id="game">
        <div id="con" class="d-flex justify-content-center">
            <canvas id="canvas1"></canvas>
            <img id="playerImage" class="d-none" src="{{ asset('demo/player.png') }}" alt="player">
            <img id="backgroundImage" class="d-none" src="{{ asset('demo/background_single.png') }}" alt="bg-image">
            <img id="enemyImage" class="d-none" src="{{ asset('demo/enemy_1.png') }}" alt="enemy">
            <img id="life" class="d-none" src="{{ asset('demo/heart.png') }}" alt="life">
            <img id="boom" class="d-none" src="{{ asset('demo/boom.png') }}" alt="boom">
            <audio id="bgm" class="d-none" src="{{ asset('demo/bgm.mp3') }}" controls loop></audio>
            <audio id="sfx" class="d-none" src="{{ asset('demo/boom.wav') }}" controls></audio>
            <audio id="sfx2" class="d-none" src="{{ asset('demo/ice.wav') }}" controls></audio>
            <button hidden id="fullScreenButton">Full Screen</button>
            <div id="overlay" class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 id="msg" class="text-light shadow">

                    </h1>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div id="content" class="row">
                <div class="col-md-3 bg-blurr rounded d-flex flex-column justify-content-between" style="padding: 0;">
                    <div>
                        <button id="tackle" class="skills btn btn-primary w-100 shadow-sm font-weight-bold">
                            Tackle
                            <br>
                            <span class="font-weight-normal">
                                DMG 5 SP 5
                            </span>
                        </button>
                        <button id="heal" class="skills btn btn-success w-100 shadow-sm font-weight-bold">
                            Heal
                            <br>
                            <span class="font-weight-normal">
                                HP 100 SP 100
                            </span>
                        </button>
                        <button id="supreme" class="skills btn btn-primary w-100 shadow-sm font-weight-bold">
                            I'm Supreme!
                            <br>
                            <span class="font-weight-normal">
                                DMG 1000 SP 100
                            </span>
                        </button>
                    </div>
                    <div>
                        <button
                            class="pause-btn btn btn-danger w-100 shadow-sm font-weight-bold">Pause/Menu</button>
                    </div>
                </div>
                <div class="col-md-6 p-0" style="height: 330px; background: #080c16;">
                    {{-- <div id="editor" class="row rounded" style="height: 330px; z-index: -10; background: #080c16;">
                    </div> --}}
                    <div id="tasks" class="h-100">

                    </div>
                    <div id="description" class="h-100 text-light p-3" hidden>
                        <div class="h-75" style="overflow: auto;">
                            <h5 style="mb-3">Task Description:</h5>
                            <div id="task-description">

                            </div>
                        </div>
                        <div class="h-25 d-flex justify-content-end align-items-end">
                            <button id="start-coding" class="btn btn-success">Start Coding</button>
                        </div>
                    </div>
                    <div id="code-editor">
                        <textarea name="" id="codeMirrorDemo"></textarea>
                        <div class="bg-navy">
                            <p class="m-0 p-1 font-weight-bold">Expected Answer: <span id="expected-answer"
                                    class="font-weight-normal"></span></p>
                        </div>
                        <div class="btn-group w-100" role="group">
                            <button id="cancel-task" class="btn btn-warning w-25">Cancel</button>
                            <button id="re-description" class="btn btn-success w-50">Read Description</button>
                            <button id="submit" class="btn btn-primary w-25">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 bg-blurr p-3 text-white rounded">
                    <p>Console:</p>
                    <p id="err-console"></p>
                </div>
            </div>
        </div>
    </div>
    <div id="playBtn" class="d-flex justify-content-center align-items-center"
        style="z-index: -99999; width: 100vw; height: 100vh;">
        <button class="btn btn-primary">Play!</button>
    </div>

    <div class="modal fade" id="win-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Congrats You Win!</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <p>Rewards:&hellip;</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="quit-btn btn btn-danger">Quit</button>
                    @if (isset($other[1]))
                        <a href="{{ route('web.play.start', $other[1]->id) }}" class="btn btn-primary">Next Stage: {{ $other[1]->name }}</a>
                    @endif
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="lose-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nice Try!</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <p>You lost, want to try again?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <a class="quit-btn btn btn-danger">Quit</a>
                    <a href="#" onclick="location.reload();" class="btn btn-primary">Yes</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="pause-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Paused!</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Background Music</label>
                        <input type="range" min="0" max="10" value="1" id="bgm-volume" class="slider form-control" id="slider">
                    </div>
                    <button id="restart" class="btn btn-warning w-100 mb-3">Restart</button>
                    <button class="pause-btn btn btn-primary w-100">Resume</button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="quit-btn btn btn-danger w-100">Quit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal" id="restart-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Restart</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to restart? <br>You may lose your current progress</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="back-btn btn btn-default">Back</button>
                    <a href="#" onclick="location.reload();" class="btn btn-warning">Restart Anyway</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal" id="quit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Quit</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to quit the game?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="back-btn btn btn-default">Back</button>
                    <a href="{{ route('web.play.index') }}" class="btn btn-danger">Quit </a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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
    <script src="{{ asset('codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('codemirror/addon/edit/matchbrackets.js') }}"></script>
    <script src="{{ asset('codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
    <script src="{{ asset('codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('codemirror/mode/clike/clike.js') }}"></script>
    <script src="{{ asset('codemirror/mode/php/php.js') }}"></script>
    <script>
        const editor = CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            lineNumbers: true,
            matchBrackets: true,
            mode: {
                name: "application/x-httpd-php",
                startOpen: true,
            },
            indentUnit: 4,
            indentWithTabs: true,
            theme: "monokai",
        });

        let RIGHT_ANSWER = "";

        let arr = [];

        const tasks = {!! $tasks !!};

        let html = '';
        for (let i = 0; i < tasks.length; i++) {
            html +=
                `<button onclick="showTask(` + i +
                `);" class="btn btn-outline-info h-25 w-100" font-weight-bold>` +
                tasks[i]["name"] + `<br><span class="font-weight-normal">Difficulty: ` +
                tasks[i]["difficulty"] + ` Reward: ` + tasks[i]["reward"] + `(SP)</span>` +
                `</button>`;
        }
        let STAKE = 0;

        function showTask(idx) {
            $("#tasks").prop("hidden", true);
            $("#description").prop("hidden", false);
            $("#task-description").text(tasks[idx]["description"]);
            $("#expected-answer").text(tasks[idx]["answer"]);

            RIGHT_ANSWER = tasks[idx]["answer"];
            STAKE = tasks[idx]["reward"];
            editor.getDoc().setValue("");
            if (tasks[idx]["snippet"]) {
                editor.getDoc().setValue(tasks[idx]["snippet"]);
            }
        };

        $("#tasks").append(html);
        $("#re-description").click(function() {
            $("#description").prop("hidden", false);
            $("#code-editor").prop("hidden", true);
        });
        $("#start-coding").click(function() {
            $("#description").prop("hidden", true);
            $("#code-editor").prop("hidden", false);
        });
        $("#cancel-task").click(function() {
            $("#tasks").prop("hidden", false);
            $("#description").prop("hidden", true);
            $("#code-editor").prop("hidden", true);
        });
        $("#code-editor").prop("hidden", true);
        // $.get({
        //     url: "{{ route('fetch.php') }}",
        //     method: 'GET',
        //     data: {
        //         "_token": "{{ csrf_token() }}",
        //     },
        //     success: function(response) {
        //         let html = '';
        //         $.each(response, function(index, data) {
        //             html +=
        //                 `<button onclick="showTask(` + index +
        //                 `);" class="btn btn-outline-info h-25 w-100">` + data.name + `</button>`;
        //             arr.push(data.snippet);
        //         });
        //         $("#tasks").append(html);
        //     }
        // });

        const phpRoute = "{{ asset('demo/api/v1/php_api.php') }}";
        const jsRoute = "{{ asset('demo/api/v1/js_api.php') }}";
        const name = '{{ Auth::user()->f_name . ' ' . Auth::user()->l_name }}';
        const proglang = "{{ $other[0]->name }}";
        const language = proglang.toLowerCase();
        const storeRoute = "{{ route('web.play.store') }}";
        const userId = '{{ Auth::user()->encrypted_id }}';
        const CSRF_TOKEN = `{{ csrf_token() }}`;
        const STAGE_NAME = "{{ $stage[0]->name }}";
        const STAGE_ID = "{{ $stage[0]->encrypted_id }}";
        let WIN = false;
        let GAME_OVER = false;
    </script>
    {{-- Game --}}
    <script src="{{ asset('demo/script.js?v=7') }}"></script>
    <script>
        $(document).ready(function() {
            $("#game").prop("hidden", true);
            $('.modal').attr('data-backdrop', 'static');

            $("#restart").click(function(){
                $("#pause-modal").modal("hide");
                $("#restart-modal").modal("show");
            });

            $("#restart-modal .back-btn").click(function(){
                if(WIN){
                    $("#restart-modal").modal("show");
                } else if (GAME_OVER) {
                    $("#lose-modal").modal("show");
                } else {
                    $("#pause-modal").modal("show");
                }

                $("#restart-modal").modal("hide");
            });

            $(".quit-btn").click(function(){
                $("#pause-modal").modal("hide");
                $("#quit-modal").modal("show");
            });

            $("#quit-modal .back-btn").click(function(){
                if(WIN){
                    $("#win-modal").modal("show");
                } else if (GAME_OVER) {
                    $("#lose-modal").modal("show");
                } else {
                    $("#pause-modal").modal("show");
                }
                
                $("#quit-modal").modal("hide");
            });
        });
    </script>
</body>

</html>
