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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('difficulty');
            $table->integer('reward');
            $table->text('description');
            $table->string('snippet')->nullable();
            $table->string('answer');
            $table->unsignedBigInteger('proglang_id');
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::table('tasks', function (Blueprint $table) {
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

        DB::statement("ALTER TABLE tasks
            MODIFY difficulty
            ENUM('Easy', 'Medium', 'Hard')
            NOT NULL DEFAULT 'easy'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
