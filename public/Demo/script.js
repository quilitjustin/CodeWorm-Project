window.addEventListener("load", function () {
    const canvas = this.document.getElementById("canvas1");
    const ctx = canvas.getContext("2d");
    canvas.width = 800;
    canvas.height = 360;
    let enemies = [];
    let score = 0;
    let paused = false;
    const enemyName = "Antagonist";
    let gameOver = false;
    let win = false;
    let timer = 0;
    const fullScreen = this.document.getElementById("fullScreenButton");
    // We do this first we don't overwrite the default console.log
    console.compile = console.log;
    // Asign the value of console.log to window.$log
    console.log = function (data) {
        console.compile(data);
        window.$log = data;
    };

    $("#playBtn button").click(function () {
        $(this).prop("hidden", true);
        $("#game").prop("hidden", false);
        $("#playBtn").attr("style", "");
        const bgm = document.getElementById("bgm");
        bgm.volume = 0.3;
        bgm.play();
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
    class InputHandler {
        constructor(player, enemy) {
            this.keys = [];
            // lexical scoping
            // window.addEventListener('keydown', e => {
            //     if(e.key === 'ArrowDown' || e.key === 'ArrowUp' ||
            //     e.key === 'ArrowLeft' || e.key === 'ArrowRight' && this.keys.indexOf(e.key) === -1){
            //         this.keys.push(e.key);
            //     }
            // });
            // window.addEventListener('keyup', e => {
            //     if(e.key === 'ArrowDown' || e.key === 'ArrowUp' ||
            //     e.key === 'ArrowLeft' || e.key === 'ArrowRight'){
            //         this.keys.splice(this.keys.indexOf(e.key), 1);
            //     }
            // });
            $("#tackle").click(function () {
                player.tackle = true;
                player.sp -= 5;
            });

            $("#heal").click(function () {
                player.lives += 100;
                player.sp -= 100;
            });
            
            $("#supreme").click(function () {
                player.supreme = true;
                enemy.lives -= 100;
                player.sp -= 100;
            });

            $("#submit").click(function () {
                let code = editor.getValue();
                if(language == "php"){
                $.post({
                    url: phpRoute,
                    data: {
                        _token: "{{ csrf_token() }}",
                        data: code,
                    },
                    success: function (response) {
                        // console.log(response);
                        if(response['success'] == true){
                            if (response['result'] == RIGHT_ANSWER) {
                                $("#msg").text("Right Answer!");
                                player.sp+= STAKE;
                                $("#tasks").prop("hidden", false);
                                $("#code-editor").prop("hidden", true);
                            } else {
                                $("#msg").text("Wrong Answer!");
                                enemy.damage++;
                            }
                            $("#err-console").text("Output: " + response['result']);
                        } else {
                            $("#err-console").text("Syntax error: " + response['result']);
                            $("#msg").text("There's an error!");
                            enemy.damage++;
                        }
                        
                    },
                    error: function (xhr, status, error) {
                        console.log("Error: " + error.message);
                        $("#err-console").text("Error: Did not follow the given format");
                        $("#msg").text("There's an error!");
                        enemy.damage++;
                    },
                });
            } else if(language == 'js'){
                try {
                    "use strict";
                    eval(`${code}`);

                    if(window.$log == RIGHT_ANSWER){
                        $("#msg").text("Right Answer!");
                        $("#tasks").prop("hidden", false);
                        $("#code-editor").prop("hidden", true);
                        player.sp+= STAKE;
                    } else {
                        $("#msg").text("Wrong Answer!");
                        enemy.damage++;
                    }
                    $("#err-console").text("Output: " + $log);
                } catch (error) {
                    $("#err-console").text("Syntax error: " + error.message);
                    $("#msg").text("There's an error!");
                    enemy.damage++;
                }
            }
                // if(evaluateCode(code)){
                //     player.sp++;
                // } else {
                //     enemy.sp++;
                // }
                // const tiles = $("#answer .tile");
                // let myAnswer = [];
                // for(let i = 0; i < tiles.length; i++){
                //     myAnswer.push($(tiles[i]).text().trim());
                // }
                // if(myAnswer.join("") == givenAnswer){
                //     player.sp++;
                // } else {
                //     enemy.sp++;
                // }
                // for(let i = 0; i < tiles.length; i++){
                //     $(tiles[i]).appendTo("#tiles");
                //     $(tiles[i]).removeClass("h-100 selected col-sm-1 rounded");
                //     $(tiles[i]).addClass("h-25 col-sm-1");
                // }
            });
        }

        // generateRandomLetters(word) {
        //     const alphabet = "abcdefghijklmnopqrstuvwxyz";
        //     let word = word.splice();
        //     let result = "";

        //     for (let i = 0; i < ; i++) {
        //       const letter = word[i];
        //       const randomIndex = Math.floor(Math.random() * alphabet.length);
        //       const randomLetter = alphabet[randomIndex];
        //       result += randomLetter;
        //     }

        //     return result;
        // }
    }
    class Player {
        constructor(gameWith, gameHeight) {
            this.gameWith = gameWith;
            this.gameHeight = gameHeight;
            this.width = 200;
            this.height = 200;
            this.x = 0;
            this.y = this.gameHeight - this.height;
            this.image = document.getElementById("playerImage");
            this.frameX = 0;
            this.maxFrame = 8;
            this.franeY = 0;
            this.fps = 20;
            this.frameTimer = 0;
            this.frameInterval = 1000 / this.fps;
            this.speed = 0;
            this.vy = 0;
            this.weight = 1;
            this.sp = 100;
            this.myBtn = document.getElementById("tackle");
            this.lives = 99999;
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
            ctx.fillStyle = "white";
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
            ctx.fillStyle = "white";
            ctx.font = "20px Helvetica";
            ctx.fillText("SP: " + this.sp, 20, 105);
        }
        update(input, deltaTime, enemies, explosions) {
            if (this.sp >= 5) {
                $("#tackle").prop("disabled", false);
            } else {
                $("#tackle").prop("disabled", true);
            }
            if (this.sp >= 100) {
                $("#heal").prop("disabled", false);
                $("#supreme").prop("disabled", false);
            } else {
                $("#heal").prop("disabled", true);
                $("#supreme").prop("disabled", true);
            }
            // Colliision detection
            // enemies.forEach(enemy => {
            //     const dx = enemy.x - this.x;
            //     const dy = enemy.y - this.y;
            //     const distance = Math.sqrt(dx * dx + dy * dy);
            //     if(distance < enemy.width / 2 + this.width / 2){

            //     }
            // });
            if (this.tackle) {
                $(".skills").prop("disabled", true);
                this.speed = 20;
                this.x += this.speed;
            }
            if (this.supreme){
                $(".skills").prop("disabled", true);
                explosions[0].update();
                explosions[0].draw();       
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
                enemies.lives -= 5;
                this.tackle = false;
                this.speed = 0;
                this.x = 0;
                this.onHit = true;
            }
            if (this.onHit) {
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
                this.maxFrame = 8;
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
            this.width = 160;
            this.height = 119;
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
            this.lives = 1000;
            this.heart = document.getElementById("life");
            this.maxLifeShow = 3;
            this.rage = false;
            this.rageTimer = 300000;
            this.damage = 5;
            this.atkTimer = 0;
            this.atkInterval = 5000 / this.fps;
            this.atkCondition = false;
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
            ctx.fillStyle = "white";
            ctx.font = "20px Helvetica";
            ctx.fillText("HP: " + this.lives, canvas.width - 22, 82);
            //         break;   
            //     }
            //     ctx.drawImage(this.heart, 20 * i + 20, 60, 25, 25);
            // }

            ctx.textAlign = "end";
            ctx.fillStyle = "black";
            ctx.font = "20px Helvetica";
            ctx.fillText("Damage: " + this.damage, canvas.width - 20, 105);
            ctx.textAlign = "end";
            ctx.fillStyle = "white";
            ctx.font = "20px Helvetica";
            ctx.fillText("Damage: " + this.damage, canvas.width - 22, 107);

            
            const formattedTime = (this.rageTimer * 0.001).toFixed(1); 
            if (!this.rage){
                ctx.textAlign = "end";
                ctx.fillStyle = "black";
                ctx.font = "20px Helvetica";
                ctx.fillText("Rage: " + formattedTime, canvas.width - 20, 125);
                ctx.textAlign = "end";
                ctx.fillStyle = "white";
                ctx.font = "20px Helvetica";
                ctx.fillText("Rage: " + formattedTime, canvas.width - 22, 127);
            } else {
                ctx.textAlign = "end";
                ctx.fillStyle = "black";
                ctx.font = "20px Helvetica";
                ctx.fillText("Rage: Activated", canvas.width - 20, 145);
                ctx.textAlign = "end";
                ctx.fillStyle = "white";
                ctx.font = "20px Helvetica";
                ctx.fillText("Rage: Activated", canvas.width - 22, 147);
            }
            
        }
        update(deltaTime, player) {
            if(this.atkCondition){
                this.atkTimer = 0;
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
            this.atkTimer++;
            if (!this.atkCondition && this.atkTimer > this.atkInterval){
                this.atkCondition = true;
                this.atkTimer = 0;
                if (this.rage && this.damage < 1000){
                    this.damage *= this.damage;
                } 
            }

            // if (this.x < 0 - this.width) {
            //     this.markedForDeletion = true;
            //     score++;
            // }
            if (!this.rage){
                this.rageTimer-= deltaTime;
                if (this.rageTimer <= 0){
                    this.rage = true;
                }
            }   
            // Vertical
            if (this.x < 0) {
                this.sound.currentTime = 0;
                this.sound.play();
                this.x = this.gameWidth - this.width;
                player.lives -= this.damage;
                this.speed = 0;
                this.onHit = true;
                this.atkCondition = false;
                this.speed = 0;
            } 
            if (this.sp >= 5){
                this.sp-= 5;
                this.damage++;
            }
            // if (this.onHit) {
            //     explosions[0].update();
            //     explosions[0].draw();
            //     explosions.splice(0, 1);
            //     this.onHit = false;
            //     $("#tackle").prop("disabled", false);
            // }    
            if (this.lives <= 0){
                this.markedForDeletion = true;
                win = true;
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
        ctx.fillStyle = "white";
        ctx.font = "30px Helvetica";
        ctx.fillText(name, 22, 52);
        ctx.textAlign = "end";
        ctx.fillStyle = "black";
        ctx.font = "30px Helvetica";
        ctx.fillText(enemyName, canvas.width - 20, 50);
        ctx.textAlign = "end";
        ctx.fillStyle = "white";
        ctx.font = "30px Helvetica";
        ctx.fillText(enemyName, canvas.width - 22, 52);

        if (gameOver) {
            ctx.textAlign = "center";
            ctx.fillStyle = "black";
            ctx.font = "40px Helvetica";
            ctx.fillText("Game Over", canvas.width / 2, 200);
            ctx.fillStyle = "white";
            ctx.font = "40px Helvetica";
            ctx.fillText("Game Over", canvas.width / 2 + 2, 202);
        }

        if (win) {
            ctx.textAlign = "center";
            ctx.fillStyle = "black";
            ctx.font = "40px Helvetica";
            ctx.fillText("You Win!", canvas.width / 2, 200);
            ctx.fillStyle = "white";
            ctx.font = "40px Helvetica";
            ctx.fillText("You Win!", canvas.width / 2 + 2, 202);
            let proglangId = "",
            stageId = "";
            if(language == "php"){
                proglangId = 1;
                stageId = 1;
            } else if (language == "js"){
                proglangId = 2;
                stageId = 2;
            }

            $.post({
                url: storeRoute,
                data: {
                    "_token": CSRF_TOKEN,
                    "record": timer,
                    "proglangId": proglangId,
                    "stageId": stageId,
                    "userId": userId,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response.message);
                },
                error: function(request, status, error) {
                    console.log(request.responseText);
                }
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
            this.markedForDeletion = false;
        }
        update() {
            if (this.frame === 0) {
                this.sound.currentTime = 0;
                this.sound.play();
            }
            this.timer++;
            if (this.timer % 10 === 0) {
                this.frame += 0.5;
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
        ctx.fillStyle = "white";
        ctx.font = "20px Helvetica";
        ctx.fillText(STAGE_NAME, canvas.width / 2, 52);

        timer+= deltaTime;
        const formattedTime = (timer * 0.001).toFixed(1); 
        
        ctx.textAlign = "center";
        ctx.fillStyle = "black";
        ctx.font = "20px Helvetica";
        ctx.fillText(formattedTime, canvas.width / 2, 70);
        ctx.textAlign = "center";
        ctx.fillStyle = "white";
        ctx.font = "20px Helvetica";
        ctx.fillText(formattedTime, canvas.width / 2, 72);

        player.update(input, deltaTime, enemy, boom);
        displayStatusText(ctx);
        if (!(gameOver || paused || win)) {
            requestAnimationFrame(animate);
        }
    }
    

    $(".tile").click(function () {
        let selected = $(this).hasClass("selected");
        if (!selected) {
            $(this).fadeOut("slow", function () {
                $(this).appendTo("#answer");
                $(this).removeClass("h-25 col-sm-1");
                $(this).addClass("h-100 selected col-sm-1 rounded");
            });
        } else {
            $(this).fadeOut("slow", function () {
                $(this).appendTo("#tiles");
                $(this).removeClass("h-100 selected col-sm-1 rounded");
                $(this).addClass("h-25 col-sm-1");
            });
        }
    });

    $("#clear").click(function () {
        const tiles = $("#answer .tile");

        for (let i = 0; i < tiles.length; i++) {
            $(tiles[i]).appendTo("#tiles");
            $(tiles[i]).removeClass("h-100 selected col-sm-1 rounded");
            $(tiles[i]).addClass("h-25 col-sm-1");
        }
    });

    $("#pause").click(function () {
        if(paused){
            paused = false;
            animate(timer);
        } else {
            paused = true;
        }
        
    });
});
