<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.meta')
    <!-- CodeMirror -->
    <link rel="stylesheet" href="{{ asset('codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('codemirror/theme/monokai.css') }}">
    {{-- Game --}}
    <link rel="stylesheet" href="{{ asset('demo/style.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body
    style=" 
background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9)), url('{{ asset($stage->bgim->path) }}');
background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%;
height:100vh; width=100%;">
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
            <img id="backgroundImage" class="d-none" src="{{ asset($stage->bgim->path) }}" alt="bg-image">
            <img id="enemyImage" class="d-none" src="{{ asset('demo/enemy_1.png') }}" alt="enemy">
            <img id="life" class="d-none" src="{{ asset('demo/heart.png') }}" alt="life">
            <img id="boom" class="d-none" src="{{ asset('demo/boom.png') }}" alt="boom">
            <audio id="bgm" class="d-none" src="{{ asset($stage->bgm->path) }}" controls loop></audio>
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
                                DMG 50 SP 50
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
                        <button id="" class="skills btn btn-success w-100 shadow-sm font-weight-bold" disabled>
                            Elixir
                            <br>
                            <span class="font-weight-normal">
                                HP 500 SP 450
                            </span>
                        </button>
                        <button id="" class="skills btn btn-warning w-100 shadow-sm font-weight-bold" disabled>
                            Super Science!
                            <br>
                            <span class="font-weight-normal">
                                DMG 9999 SP 1000
                            </span>
                        </button>
                    </div>
                    <div>
                        <button class="pause-btn btn btn-danger w-100 shadow-sm font-weight-bold">Pause/Menu</button>
                    </div>
                </div>
                <div id="main-controls" class="col-md-6 p-0" style="height: 330px; background: #080c16;">
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
                    <!-- /.card-header -->
                    <div id="controls-preloader" class="d-none"
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
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
        <div class="text-center">
            <h1 class="text-light d-block">Codeworm</h1>
            <button class="btn btn-primary">Play!</button>
        </div>
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
                    <p id="total-time"></p>
                    @if (isset($stage->badges))
                        <p>Rewards: </p>
                        <img src="{{ asset($stage->badges->path) }}"
                            class="rounded mx-auto d-block border border-secondary" alt="preview"
                            style="height: 150px; max-height: 150px;">
                        <div class="text-center">
                            <h3 class="font-weight-bold">{{ $stage->badges->name }}</h3>
                        </div>
                    @else
                        <p>Rewards: None</p>
                    @endisset
            </div>
            <div class="modal-footer justify-content-between">
                <button class="quit-btn btn btn-danger">Quit</button>
                <button class="restart btn btn-warning">Try again</button>
                @if (!is_null($next_stage))
                    {{-- Next stage --}}
                    <a href="{{ route('web.play.start', $next_stage->encrypted_id) }}"
                        class="btn btn-primary">Next
                        Stage: {{ $next_stage->name }}</a>
                @else
                    <a href="{{ route('web.leaderboard.index') }}" class="btn btn-primary">Leaderboards</a>
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
                <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Hello"></i>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Background Music</label>
                    <input type="range" min="0" max="10" value="1" id="bgm-volume"
                        class="slider form-control" id="slider">
                </div>
                <div class="form-group">
                    <label for="">Sound Effects</label>
                    <input type="range" min="0" max="10" value="1" id="sfx-volume"
                        class="slider form-control" id="slider">
                </div>
                <button class="restart btn btn-warning w-100 mb-3">Restart</button>
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
                <p>Are you sure you want to restart?</p>
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
    // Prevent paste events
    editor.on("paste", function(cm, event) {
        event.preventDefault();
        return true;
    });

    // Prevent copy events
    editor.on("copy", function(cm, event) {
        event.preventDefault();
        return true;
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

    const phpRoute = "{{ asset('demo/api/v1/php_api.php') }}";
    const jsRoute = "{{ asset('demo/api/v1/js_api.php') }}";
    const name = '{{ Auth::user()->f_name . ' ' . Auth::user()->l_name }}';
    const proglang = "{{ $stage->proglang->name }}";
    const language = proglang.toLowerCase();
    const storeRoute = "{{ route('web.play.store') }}";
    const userId = '{{ Auth::user()->encrypted_id }}';
    const CSRF_TOKEN = `{{ csrf_token() }}`;
    const STAGE_NAME = "{{ $stage->name }}";
    const STAGE_ID = "{{ $stage->encrypted_id }}";
    const PLAYER_HP = {{ $stage->player_base_hp }};
    const PLAYER_SP = {{ $stage->player_base_sp }};
    const ENEMY_HP = {{ $stage->enemy_base_hp }};
    const ENEMY_DMG = {{ $stage->enemy_base_dmg }};

    const BADGE_ID = null;
    let WIN = false;
    let GAME_OVER = false;
</script>
@isset($stage->badges)
    <script>
        BADGE_ID = "{{ $stage->badges->encrypted_id }}";
    </script>
@endisset
{{-- Game --}}
<script src="{{ asset('demo/script.js?v=13') }}"></script>
<script>
    $(document).ready(function() {
        $("#code-editor").prop("hidden", true);
        $("#game").prop("hidden", true);
        $('.modal').attr('data-backdrop', 'static');

        // From bootstrap documentation
        // https://getbootstrap.com/docs/5.1/components/tooltips/
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        $(".restart").click(function() {
            $("#pause-modal").modal("hide");
            $("#restart-modal").modal("show");
        });

        $("#restart-modal .back-btn").click(function() {
            if (WIN) {
                $("#restart-modal").modal("show");
            } else if (GAME_OVER) {
                $("#lose-modal").modal("show");
            } else {
                $("#pause-modal").modal("show");
            }

            $("#restart-modal").modal("hide");
        });

        $(".quit-btn").click(function() {
            $("#pause-modal").modal("hide");
            $("#quit-modal").modal("show");
        });

        $("#quit-modal .back-btn").click(function() {
            if (WIN) {
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
