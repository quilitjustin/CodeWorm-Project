<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('splash_pages', function (Blueprint $table) {
            $table->id();
            $table->json('content');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });

        Schema::table('splash_pages', function (Blueprint $table) {
            $table->foreign('created_by')
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
        Schema::dropIfExists('splash_pages');
    }
};
