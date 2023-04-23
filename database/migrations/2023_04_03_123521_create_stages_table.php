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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('tasks');
            $table->unsignedBigInteger('proglang_id');
            $table->unsignedBigInteger('badge_id')->nullable();
            $table->unsignedBigInteger('bgim_id');
            $table->unsignedBigInteger('bgm_id');
            $table->integer('player_base_hp');
            $table->integer('enemy_base_hp');
            $table->integer('player_base_sp');
            $table->integer('enemy_base_dmg');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::table('stages', function (Blueprint $table) {
            $table
                ->foreign('proglang_id')
                ->references('id')
                ->on('programming_languages')
                ->onDelete('cascade');
            $table
                ->foreign('badge_id')
                ->references('id')
                ->on('badges')
                ->onDelete('cascade');
            $table
                ->foreign('bgim_id')
                ->references('id')
                ->on('b_g_imgs')
                ->onDelete('cascade');
            $table
                ->foreign('bgm_id')
                ->references('id')
                ->on('b_g_m_s')
                ->onDelete('cascade');
            $table
                ->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table
                ->foreign('updated_by')
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
        Schema::dropIfExists('stages');
    }
};
