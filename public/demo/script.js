window.addEventListener("load", function () {
    const canvas = this.document.getElementById("canvas1");
    const ctx = canvas.getContext("2d");
    canvas.width = 800;
    canvas.height = 360;
    let enemies = [];
    let score = 0;
    let paused = false;
    const enemyName = "Codeworm";
    // let gameOver = false;
    // let win = false;
    let timer = 0;
    let formatTimer = "";
    let TASK_TIMER = 0;
    let TOTAL_TIMER = [];
    let interval;
    let start = false;
    let bgm = document.getElementById("bgm");
    let bgmVolume = 0.1;
    bgm.volume = bgmVolume;
    let sfxVolume = 0.1;
    const fullScreen = this.document.getElementById("fullScreenButton");
    const CLAP_SFX = document.getElementById("clap");
    const SHEESH_SFX = document.getElementById("sheesh");
    const DOH = document.getElementById("doh");
    const GOKU = document.getElementById("goku");
    const HEAL = document.getElementById("heal-sfx");
    // We do this first we don't overwrite the default console.log
    console.compile = console.log;
    // Asign the value of console.log to window.$log
    console.log = function (data) {
        console.compile(data);
        window.$log = data;
    };

    function formatTime(time) {
        let hours = Math.floor(time / 3600);
        let minutes = Math.floor((time % 3600) / 60);
        let seconds = Math.floor(time % 60);
        return (
            hours +
            ":" +
            (minutes < 10 ? "0" : "") +
            minutes +
            ":" +
            (seconds < 10 ? "0" : "") +
            seconds
        );
    }

    $("#bgm-volume").on("change", function () {
        const volume = $(this).val();
        bgmVolume = volume / 10;
        bgm.volume = bgmVolume;
    });

    $("#sfx-volume").on("change", function () {
        const volume = $(this).val();
        sfxVolume = volume / 10;
    });

    $("#playBtn button").click(function () {
        $("body").removeAttr("style");
        $("body").css("background-color", "#0E1525");
        $(this).parent().prop("hidden", true);
        $("#game").prop("hidden", false);
        $("#playBtn").attr("style", "");
        bgm.play();
        start = true;
        animate(0);
    });

    // function evaluateCode(code) {
    //     try {
    //       let result = eval(`!!(` + code + `)`);
    //       $("#err-console").text("");
    //       return true;
    //     } catch (error) {
    //       $("#err-console").text("Syntax error: " + error.message);
    //       return false;
    //     }
    // }

    let intervalId;

    function startEnemyAtk(enemy) {
      intervalId = setInterval(function() {
        setAtkCondition(enemy);
      }, 30000); // Call setAtkCondition every 30 seconds (30,000 milliseconds)
    }
    let countdown = 30;
    function countdownEndGame() {
      intervalId = setInterval(function() {
        countdown--;
        $("#msg").fadeIn();
        $("#msg").html("Game is about to end <br>" + countdown);
        if(countdown < 0){
            GAME_OVER = true;
        }
      }, 1000); 
    }
    
    function stopEnemyAtk() {
      clearInterval(intervalId); // Stop the interval
    }
    
    function setAtkCondition(enemy) {
      enemy.atkCondition = true;
    }
    

    let ENABLED_CONTROLS = true;
    class InputHandler {
        constructor(player, enemy) {
            this.keys = [];
            $("#start-coding").click(function () {
                ENABLED_CONTROLS = false;
                $("#msg").fadeIn();
                $("#msg").text("Ready");
                setTimeout(function () {
                    $("#msg").fadeIn();
                    $("#msg").text("Get Set");
                }, 1000);
                setTimeout(function () {
                    $("#msg").fadeIn();
                    $("#msg").text("Go!");
                }, 2000);
                setTimeout(function () {
                    ENABLED_CONTROLS = true;
                    $("#msg").fadeOut();
                    startTimer();
                    startEnemyAtk(enemy);
                }, 3000);
            });

            $("#tackle").click(function () {
                player.tackle = true;
                player.sp -= 50;
                GOKU.currentTime = 0;
                GOKU.volume = sfxVolume;
                GOKU.play();
                $("#msg").html("Tackle has been used!<br>Damage 50");
                $("#msg").fadeIn();
                setTimeout(function () {
                    $("#msg").fadeOut();
                    GOKU.pause();
                }, 1000);
            });

            $("#heal").click(function () {
                HEAL.currentTime = 0;
                HEAL.volume = sfxVolume;
                HEAL.play();
                player.lives += 100;
                player.sp -= 100;
                $("#msg").html("Heal has been used!<br>HP + 100");
                $("#msg").fadeIn();
                setTimeout(function () {
                    $("#msg").fadeOut();
                    HEAL.pause();
                }, 1500);
            });

            $("#elixir").click(function () {
                HEAL.currentTime = 0;
                HEAL.volume = sfxVolume;
                HEAL.play();
                player.lives += 500;
                player.sp -= 450;
                $("#msg").html("Elixir has been used!<br>HP + 500");
                $("#msg").fadeIn();
                setTimeout(function () {
                    $("#msg").fadeOut();
                    HEAL.pause();
                }, 1500);
            });

            $("#supreme").click(function () {
                player.supreme = true;
                if (enemy.lives > 500) {
                    enemy.lives -= 500;
                } else {
                    enemy.lives = 0;
                }
                player.sp -= 100;
                $("#msg").html("Supreme has been used!<br>Damage 500");
                $("#msg").fadeIn();
                setTimeout(function () {
                    $("#msg").fadeOut();
                }, 2000);
            });
            $("#super").click(function () {
                player.supreme = true;
                GOKU.currentTime = 0;
                GOKU.volume = sfxVolume;
                GOKU.play();
                if (enemy.lives > 9999) {
                    enemy.lives -= 9999;
                } else {
                    enemy.lives = 0;
                }
                player.sp -= 1000;
                $("#msg").html("Super Science has been used!<br>Damage 9999");
                $("#msg").fadeIn();
                setTimeout(function () {
                    $("#msg").fadeOut();
                    GOKU.pause();
                }, 2000);
            });
            $("#submit").click(function () {
                let code = editor.getValue();
                ENABLED_CONTROLS = false;

                switch (language) {
                    case "php":
                        $.post({
                            url: PHP_ROUTE,
                            data: {
                                _token: "{{ csrf_token() }}",
                                data: code,
                            },
                            complete: function () {
                                ENABLED_CONTROLS = true;
                            },
                            success: function (response) {
                                // console.log(response);
                                if (response["success"] == true) {
                                    if (response["result"] == RIGHT_ANSWER) {
                                         clearInterval(intervalId); // Stop the interval
                                        CLAP_SFX.currentTime = 0;
                                        CLAP_SFX.volume = sfxVolume;
                                        CLAP_SFX.play();
                                        SHEESH_SFX.currentTime = 0;
                                        SHEESH_SFX.volume = sfxVolume;
                                        SHEESH_SFX.play();
                                        $("#msg").html(
                                            "Right Answer!<br>SP +" + STAKE
                                        );
                                        player.sp += STAKE;
                                        $("#tasks").prop("hidden", false);
                                        $("#code-editor").prop("hidden", true);
                                        stopTimer();
                                        TOTAL_TIMER.push(TASK_TIMER);
                                        TASK_TIMER = 0;
                                        if(maxTask <= 0){
                                            countdownEndGame();
                                        }
                                    } else {
                                        DOH.currentTime = 0;
                                        DOH.volume = sfxVolume;
                                        DOH.play();
                                        $("#msg").html(
                                            "Wrong Answer"
                                        );
                                      
                                    }
                                    $("#err-console").text(
                                        "Output: " + response["result"]
                                    );
                                } else {
                                    DOH.currentTime = 0;
                                    DOH.volume = sfxVolume;
                                    DOH.play();
                                    $("#err-console").text(
                                        "Syntax error: " + response["result"]
                                    );
                                    $("#msg").html(
                                        "There's an error"
                                    );
                                
                                }
                            },
                            error: function (xhr, status, error) {
                                DOH.currentTime = 0;
                                DOH.volume = sfxVolume;
                                DOH.play();
                                console.log("Error: " + error.message);
                                $("#err-console").text(
                                    "Error: Did not follow the given format"
                                );
                                $("#msg").html(
                                    "There's an error"
                                );
                              
                            },
                        });
                        $("#msg").fadeIn();
                        setTimeout(function () {
                            $("#msg").fadeOut();
                            CLAP_SFX.pause();
                            SHEESH_SFX.pause();
                        }, 1900);
                        break;
                    case "javascript":
                        try {
                            ("use strict");
                            eval(`${code}`);

                            if (window.$log == RIGHT_ANSWER) {
                                 clearInterval(intervalId); // Stop the interval
                                CLAP_SFX.currentTime = 0;
                                CLAP_SFX.volume = sfxVolume;
                                CLAP_SFX.play();
                                SHEESH_SFX.currentTime = 0;
                                SHEESH_SFX.volume = sfxVolume;
                                SHEESH_SFX.play();
                                $("#msg").html("Right Answer!<br>SP +" + STAKE);
                                $("#tasks").prop("hidden", false);
                                $("#code-editor").prop("hidden", true);
                                player.sp += STAKE;
                                 if(maxTask <= 0){
                                            countdownEndGame();
                                        }
                            } else {
                                DOH.currentTime = 0;
                                DOH.volume = sfxVolume;
                                DOH.play();
                                $("#msg").html(
                                    "Wrong Answer"
                                );
                         
                            }
                            $("#err-console").text("Output: " + $log);
                        } catch (error) {
                            DOH.currentTime = 0;
                            DOH.volume = sfxVolume;
                            DOH.play();
                            $("#err-console").text(
                                "Syntax error: " + error.message
                            );
                            $("#msg").html(
                                "There's an error"
                            );
                            enemy.atkCondition = true;
                        }
                        $("#msg").fadeIn();
                        setTimeout(function () {
                            $("#msg").fadeOut();
                            CLAP_SFX.pause();
                            SHEESH_SFX.pause();
                        }, 1900);
                        break;
                    default:
                        let data = {
                            source_code: code,
                            language_id: LANG_KEY,
                            number_of_runs: "1",
                            stdin: "Judge0",
                            expected_output: null,
                            cpu_time_limit: "2",
                            cpu_extra_time: "0.5",
                            wall_time_limit: "5",
                            memory_limit: "128000",
                            stack_limit: "64000",
                            max_processes_and_or_threads: "60",
                            enable_per_process_and_thread_time_limit: false,
                            enable_per_process_and_thread_memory_limit: false,
                            max_file_size: "1024",
                            stderr: true,
                        };

                        let request = $.ajax({
                            url: BASE_URL,
                            type: "post",
                            data: data,
                        });

                        const delay = (ms) =>
                            new Promise((res) => setTimeout(res, ms));
                        // Callback handler that will be called on success
                        request.done(async function (
                            response,
                            textStatus,
                            jqXHR
                        ) {
                            let token = response.token;
                            await new Promise((resolve) =>
                                setTimeout(resolve, 3000)
                            ); // 1 sec
                            $.get({
                                url: BASE_URL + "/" + token,
                                success: function (response) {
                                    ENABLED_CONTROLS = true;

                                    if (response.stdout) {
                                        if (response.stdout == RIGHT_ANSWER) {
                                             clearInterval(intervalId); // Stop the interval
                                            CLAP_SFX.currentTime = 0;
                                            CLAP_SFX.volume = sfxVolume;
                                            CLAP_SFX.play();
                                            SHEESH_SFX.currentTime = 0;
                                            SHEESH_SFX.volume = sfxVolume;
                                            SHEESH_SFX.play();
                                            $("#msg").html(
                                                "Right Answer!<br>SP +" + STAKE
                                            );
                                            player.sp += STAKE;
                                            enemy.setAtkCondition = false;
                                            editor.setValue("");
                                            editor.clearHistory();
                                            $("#tasks").prop("hidden", false);
                                            $("#code-editor").prop(
                                                "hidden",
                                                true
                                            );
                                             if(maxTask <= 0){
                                            countdownEndGame();
                                        }
                                        } else {
                                            DOH.currentTime = 0;
                                            DOH.volume = sfxVolume;
                                            DOH.play();
                                            $("#msg").html(
                                                "Wrong Answer"
                                            );
                                           
                                        }
                                        $("#err-console").text(
                                            "Output: " + response.stdout
                                        );
                                    }
                                    if (response.stderr) {
                                        DOH.currentTime = 0;
                                        DOH.volume = sfxVolume;
                                        DOH.play();
                                        $("#err-console").text(
                                            "Syntax error: " + response.stderr
                                        );
                                        $("#msg").html(
                                            "There's an error"
                                        );
                            
                                    }
                                    $("#msg").fadeIn();
                                    setTimeout(function () {
                                        $("#msg").fadeOut();
                                        CLAP_SFX.pause();
                                        SHEESH_SFX.pause();
                                    }, 1900);
                                },
                            });
                        });
                }
            });
        }
    }
    class Player {
        constructor(gameWith, gameHeight) {
            this.gameWith = gameWith;
            this.gameHeight = gameHeight;
            this.width = 107;
            this.height = 170;
            this.x = 0;
            this.y = this.gameHeight - this.height;
            this.image = document.getElementById("playerImage");
            this.frameX = 0;
            this.maxFrame = 18;
            this.franeY = 0;
            this.fps = 30;
            this.frameTimer = 0;
            this.frameInterval = 1000 / this.fps;
            this.speed = 0;
            this.vy = 0;
            this.weight = 1;
            this.sp = PLAYER_SP;
            this.myBtn = document.getElementById("tackle");
            this.lives = PLAYER_HP;
            this.heart = document.getElementById("life");
            this.maxLifeShow = 3;
            this.boom = document.getElementById("boom");
            this.tackle = false;
            this.sfx = document.getElementById("sfx");
            this.onHit = false;
        }
        draw(ctx) {
            ctx.strokeStyle = "white";
            ctx.drawImage(
                this.image,
                this.frameX * this.width,
                this.frameY * this.height,
                this.width,
                this.height,
                this.x,
                this.y,
                this.width,
                this.height
            );

            // for(let i = 0; i < this.lives; i++){
            //     if(i > 2){
            ctx.textAlign = "start";
            ctx.fillStyle = "black";
            ctx.font = "20px Helvetica";
            ctx.fillText("HP: " + this.lives, 20, 80);
            ctx.textAlign = "start";
            ctx.fillStyle = "#FFFF00";
            ctx.font = "20px Helvetica";
            ctx.fillText("HP: " + this.lives, 20, 82);
            //         break;
            //     }
            //     ctx.drawImage(this.heart, 20 * i + 20, 60, 25, 25);
            // }
            ctx.textAlign = "start";
            ctx.fillStyle = "black";
            ctx.font = "20px Helvetica";
            ctx.fillText("SP: " + this.sp, 20, 105);
            ctx.textAlign = "start";
            ctx.fillStyle = "#FFFF00";
            ctx.font = "20px Helvetica";
            ctx.fillText("SP: " + this.sp, 20, 107);
        }
        update(input, deltaTime, enemies, explosions) {
            if (this.lives < 0) {
                this.lives = 0;
            }
            if (ENABLED_CONTROLS) {
                if (editor.getValue()) {
                    $("#submit").prop("disabled", false);
                } else {
                    $("#submit").prop("disabled", true);
                }
                $("#main-controls *:not(#submit)").prop("disabled", false);
                $("#controls-preloader").addClass("d-none");
            } else {
                $("#main-controls *").prop("disabled", true);
                $("#controls-preloader").removeClass("d-none");
            }
            if (this.lives <= 0) {
                GAME_OVER = true;
            }
            if (this.sp > 49) {
                $("#tackle").prop("disabled", false);
            } else {
                $("#tackle").prop("disabled", true);
            }
            if (this.sp > 99) {
                $("#heal").prop("disabled", false);
                $("#supreme").prop("disabled", false);
            } else {
                $("#heal").prop("disabled", true);
                $("#supreme").prop("disabled", true);
            }
            if (this.sp > 449) {
                $("#elixir").prop("disabled", false);
            } else {
                $("#elixir").prop("disabled", true);
            }
            if (this.sp > 999) {
                $("#super").prop("disabled", false);
            } else {
                $("#super").prop("disabled", true);
            }
            if (this.sp < 0) {
                this.sp = 0;
            }
            if (this.tackle) {
                $(".skills").prop("disabled", true);
                this.speed = 20;
                this.x += this.speed;
            }
            if (this.supreme) {
                explosions[0].update(deltaTime);
                explosions[0].draw();
                explosions.splice(0, 1);
                this.supreme = false;
            }
            // Sprite animation
            if (this.frameTimer > this.frameInterval) {
                if (this.frameX >= this.maxFrame) {
                    this.frameX = 0;
                } else {
                    this.frameX++;
                }
                this.frameTimer = 0;
            } else {
                this.frameTimer += deltaTime;
            }
            if (input.keys.indexOf("tackle") > -1) {
                this.speed = 5;
            } else if (input.keys.indexOf("ArrowLeft") > -1) {
                this.speed = -5;
            } else if (input.keys.indexOf("ArrowUp") > -1 && this.onGround()) {
                this.vy -= 32;
            } else {
                this.speed = 0;
            }
            // Horizontal Movement
            // this.x += this.speed;
            if (this.x < 0) {
                this.x = 0;
            } else if (this.x > this.gameWith - this.width) {
                this.x = this.gameWith - this.width;
                enemies.lives -= 50;
                this.tackle = false;
                this.speed = 0;
                this.x = 0;
                this.onHit = true;
            }
            if (this.onHit) {
                this.speed -= 20;
                explosions[0].update();
                explosions[0].draw();
                explosions.splice(0, 1);
                this.onHit = false;
                $(".skills").prop("disabled", false);
            }
            // Vertical Movement
            this.y += this.vy;
            if (!this.onGround()) {
                this.vy += this.weight;
                this.frameY = 1;
                this.maxFrame = 5;
            } else {
                this.vy = 0;
                this.frameY = 0;
                this.maxFrame = 18;
            }
            if (this.y > this.gameHeight - this.height) {
                this.y = this.gameHeight - this.height;
            }
        }
        onGround() {
            return this.y >= this.gameHeight - this.height;
        }
    }
    class Background {
        constructor(gameWidth, gameHeight) {
            this.gameWidth = gameWidth;
            this.gameHeight = gameHeight;
            this.image = document.getElementById("backgroundImage");
            this.x = 0;
            this.y = 0;
            this.width = 1200;
            this.height = 360;
            this.speed = 7;
        }
        draw(ctx) {
            ctx.drawImage(this.image, this.x, this.y, this.width, this.height);
            ctx.drawImage(
                this.image,
                this.x + this.width - this.speed,
                this.y,
                this.width,
                this.height
            );
        }
        update() {
            this.x -= this.speed;
            if (this.x < 0 - this.width) {
                this.x = 0;
            }
        }
    }
    class Enemy {
        constructor(gameWidth, gameHeight) {
            this.gameWidth = gameWidth;
            this.gameHeight = gameHeight;
            this.width = 273;
            this.height = 282;
            this.image = document.getElementById("enemyImage");
            this.x = this.gameWidth - this.width;
            this.y = this.gameHeight - this.height;
            this.frameX = 0;
            this.maxFrame = 5;
            this.fps = 20;
            this.frameTimer = 0;
            this.frameInterval = 1000 / this.fps;
            this.speed = 8;
            this.markedForDeletion = false;
            this.sp = 0;
            this.lives = ENEMY_HP;
            this.heart = document.getElementById("life");
            this.maxLifeShow = 3;
            this.damage = ENEMY_DMG;
            this.atkTimer = 0;
            this.atkInterval = 5000 / this.fps;
            this.atkCondition = false;
            this.setAtkCondition = false;
            this.onHit = false;
            this.sound = document.getElementById("sfx2");
        }
        draw(ctx) {
            ctx.drawImage(
                this.image,
                this.frameX * this.width,
                0,
                this.width,
                this.height,
                this.x,
                canvas.height - this.height,
                this.width,
                this.height
            );

            // for(let i = 0; i < this.lives; i++){
            //     if(i > 2){

            ctx.textAlign = "end";
            ctx.fillStyle = "black";
            ctx.font = "20px Helvetica";
            ctx.fillText("HP: " + this.lives, canvas.width - 20, 80);
            ctx.textAlign = "end";
            ctx.fillStyle = "#FFFF00";
            ctx.font = "20px Helvetica";
            ctx.fillText("HP: " + this.lives, canvas.width - 22, 82);
            //         break;
            //     }
            //     ctx.drawImage(this.heart, 20 * i + 20, 60, 25, 25);
            // }

            ctx.textAlign = "white";
            ctx.fillStyle = "black";
            ctx.font = "20px Helvetica";
            ctx.fillText("Damage: " + this.damage, canvas.width - 20, 100);
            ctx.textAlign = "end";
            ctx.fillStyle = "#FFFF00";
            ctx.font = "20px Helvetica";
            ctx.fillText("Damage: " + this.damage, canvas.width - 22, 102);
        }
        update(deltaTime, player) {
            if (this.lives < 0) {
                this.lives = 0;
            }
            if (this.atkCondition) {
                this.speed = 20;
                this.x -= this.speed;
            }
            if (this.frameTimer > this.frameInterval) {
                if (this.frameX >= this.maxFrame) {
                    this.frameX = 0;
                } else {
                    this.frameX++;
                }
                this.frameTimer = 0;
            } else {
                this.frameTimer += deltaTime;
            }
            if (this.setAtkCondition) {
                this.atkTimer++;
            }

            if (!this.atkCondition && this.atkTimer > this.atkInterval) {
                this.atkCondition = true;
                this.atkTimer = 0;
            }

            // if (this.x < 0 - this.width) {
            //     this.markedForDeletion = true;
            //     score++;
            // }

            if (this.x > this.gameWidth) {
                this.x--;
                this.atkCondition = false;
            }
            if (this.x < 0) {
                this.sound.currentTime = 0;
                this.sound.volume = sfxVolume;
                this.sound.play();
                this.x = this.gameWidth - this.width;
                if (player.lives > this.damage) {
                    player.lives -= this.damage;
                } else {
                    player.lives = 0;
                }
                this.speed = 0;
                this.onHit = true;
                this.atkCondition = false;
                this.speed = 0;
            }
            if (this.sp >= 5) {
                this.sp -= 5;
                this.damage++;
            }
            // if (this.onHit) {
            //     explosions[0].update();
            //     explosions[0].draw();
            //     explosions.splice(0, 1);
            //     this.onHit = false;
            //     $("#tackle").prop("disabled", false);
            // }
            if (this.lives <= 0) {
                this.lives = 0;
                this.markedForDeletion = true;
                WIN = true;
            }
        }
    }

    function handleEnemies(deltaTime) {
        enemies.push(new Enemy(canvas.width, canvas.height));
        // if(enemyTimer > enemyInterval + randomEnemyInterval){
        //     enemies.push(new Enemy(canvas.width, canvas.height));
        //     enemyTimer = 0;
        // } else {
        //     enemyTimer += deltaTime;
        // }
        enemies.forEach((enemy) => {
            enemy.draw(ctx);
            enemy.update(deltaTime);
        });
        enemies = enemies.filter((enemy) => !enemy.markedForDeletion);
    }
    function displayStatusText(ctx) {
        ctx.textAlign = "start";
        ctx.fillStyle = "black";
        ctx.font = "30px Helvetica";
        ctx.fillText(name, 20, 50);
        ctx.textAlign = "start";
        ctx.fillStyle = "#FFFF00";
        ctx.font = "30px Helvetica";
        ctx.fillText(name, 22, 52);
        ctx.textAlign = "end";
        ctx.fillStyle = "black";
        ctx.font = "30px Helvetica";
        ctx.fillText(enemyName, canvas.width - 20, 50);
        ctx.textAlign = "end";
        ctx.fillStyle = "#FFFF00";
        ctx.font = "30px Helvetica";
        ctx.fillText(enemyName, canvas.width - 22, 52);

        if (GAME_OVER) {
            ctx.textAlign = "center";
            ctx.fillStyle = "black";
            ctx.font = "40px Helvetica";
            ctx.fillText("Game Over", canvas.width / 2, 200);
            ctx.fillStyle = "#FFFF00";
            ctx.font = "40px Helvetica";
            ctx.fillText("Game Over", canvas.width / 2 + 2, 202);
            $("#game *").prop("disabled", true);
            $("#lose-modal").modal("show");
        }

        if (paused) {
            ctx.textAlign = "center";
            ctx.fillStyle = "black";
            ctx.font = "40px Helvetica";
            ctx.fillText("Paused", canvas.width / 2, 200);
            ctx.fillStyle = "#FFFF00";
            ctx.font = "40px Helvetica";
            ctx.fillText("Paused", canvas.width / 2 + 2, 202);
            $("#game *").prop("disabled", true);
            // $("#pause").prop("disabled", false);
        } else {
            $("#game *:not(.skills)").prop("disabled", false);
        }

        if (WIN) {
            ctx.textAlign = "center";
            ctx.fillStyle = "black";
            ctx.font = "40px Helvetica";
            ctx.fillText("You Win!", canvas.width / 2, 200);
            ctx.fillStyle = "#FFFF00";
            ctx.font = "40px Helvetica";
            ctx.fillText("You Win!", canvas.width / 2 + 2, 202);
            $("#game *").prop("enabled", true);

            let totalTime = 0;
            TOTAL_TIMER.forEach((time) => {
                totalTime += time;
            });
            const displayTotal = formatTime(totalTime);

            $.post({
                url: storeRoute,
                data: {
                    _token: CSRF_TOKEN,
                    record: totalTime,
                    proglangId: PROGLANG_ID,
                    badgeId: BADGE_ID,
                    stageId: STAGE_ID,
                },
                dataType: "json",
                success: function (response) {
                    CLAP_SFX.currentTime = 0;
                    CLAP_SFX.volume = sfxVolume;
                    CLAP_SFX.play();
                    setTimeout(function () {
                        CLAP_SFX.pause();
                    }, 5000);

                    $("#win-modal").modal("show");
                    $("#total-time").text("Time: " + displayTotal);
                },
                error: function (request, status, error) {
                    // console.log(request.responseText);
                },
            });
        }
    }

    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            canvas.requestFullscreen().catch((err) => {
                // Template literals
                alert(`Error, can't enable: ${err.message}`);
            });
        } else {
            document.exitFullscreen();
        }
    }
    fullScreen.addEventListener("click", function () {
        toggleFullScreen();
    });

    class Explotion {
        constructor(x, y) {
            this.spriteWidth = 200;
            this.spriteHeight = 179;
            this.width = this.spriteWidth * 0.7;
            this.height = this.spriteHeight * 0.7;
            this.x = x;
            this.y = y;
            this.image = document.getElementById("boom");
            this.frame = 0;
            this.timer = 0;
            this.angle = Math.random() * 6.2;
            this.sound = document.getElementById("sfx");
            this.timeSinceLastFrame = 0;
            this.frameInterval = 200;
            this.markedForDeletion = false;
        }
        update(deltaTime) {
            if (this.frame === 0) {
                this.sound.currentTime = 0;
                this.sound.volume = sfxVolume;
                this.sound.play();
            }
            this.timeSinceLastFrame += deltaTime;
            if (this.timeSinceLastFrame > this.frameInterval) {
                this.frame++;
                this.timeSinceLastFrame = 0;
                if (this.frame > 5) {
                    this.markForDeletion = true;
                }
            }
        }
        draw() {
            ctx.drawImage(
                this.image,
                this.spriteWidth * this.frame,
                0,
                this.spriteWidth,
                this.spriteHeight,
                0 - this.width,
                0 - this.height,
                1000,
                1000
            );
        }
    }

    const player = new Player(canvas.width, canvas.height);
    const enemy = new Enemy(canvas.width, canvas.height);
    const input = new InputHandler(player, enemy);
    const background = new Background(canvas.width, canvas.height);
    const explosions = new Explotion(enemy.x, enemy.y);

    let lastTime = 0;
    let enemyTimer = 0;
    let enemyInterval = 1000;
    let randomEnemyInterval = Math.random() * 1000 + 500;
    let boom = [];
    let animationId;
    let elapsedTime = 0;

    function startTimer() {
        clearInterval(interval);

        interval = setInterval(() => {
            TASK_TIMER++;
        }, 1000);
    }

    function stopTimer() {
        clearInterval(interval); // Stop the interval
    }

    function animate(timeStamp) {
        const deltaTime = timeStamp - lastTime;
        lastTime = timeStamp;

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        background.draw(ctx);
        // background.update();
        // handleEnemies(deltaTime);
        enemy.draw(ctx);
        enemy.update(deltaTime, player);
        player.draw(ctx);
        if (boom.length < 5) {
            boom.push(new Explotion(enemy.x, enemy.y));
        }

        ctx.textAlign = "center";
        ctx.fillStyle = "black";
        ctx.font = "20px Helvetica";
        ctx.fillText(STAGE_NAME, canvas.width / 2, 50);
        ctx.textAlign = "center";
        ctx.fillStyle = "#FFFF00";
        ctx.font = "20px Helvetica";
        ctx.fillText(STAGE_NAME, canvas.width / 2, 52);
        if (!paused) {
            formatTimer = formatTime(TASK_TIMER);

            ctx.textAlign = "center";
            ctx.fillStyle = "black";
            ctx.font = "20px Helvetica";
            ctx.fillText(formatTimer, canvas.width / 2, 70);
            ctx.textAlign = "center";
            ctx.fillStyle = "#FFFF00";
            ctx.font = "20px Helvetica";
            ctx.fillText(formatTimer, canvas.width / 2, 72);
        } else {
            timer = 0;
        }

        player.update(input, deltaTime, enemy, boom);
        displayStatusText(ctx);
        if (!paused && !(GAME_OVER || WIN)) {
            requestAnimationFrame(animate);
        } else {
            cancelAnimationFrame(animationId);
        }
    }

    $(".pause-btn").click(function () {
        if (paused) {
            $("#pause-modal").modal("hide");
            paused = false;
            requestAnimationFrame(animate);
        } else {
            $("#pause-modal").modal("show");
            paused = true;
        }
    });
});
