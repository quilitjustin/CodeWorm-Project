<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_records', function (Blueprint $table) {
            $table->id();
            $table->string('record');
            $table->unsignedBigInteger('proglang_id');
            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('player_id');
            $table->timestamps();
        });

        Schema::table('game_records', function (Blueprint $table) {
            $table
                ->foreign('proglang_id')
                ->references('id')
                ->on('programming_languages')
                ->onDelete('cascade');
            $table
                ->foreign('stage_id')
                ->references('id')
                ->on('stages')
                ->onDelete('cascade');
            $table
                ->foreign('player_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_records');
    }
};
