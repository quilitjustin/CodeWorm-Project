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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('message');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->foreign('reviewed_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        DB::statement("ALTER TABLE inquiries 
            MODIFY status 
            ENUM('pending', 'done') 
            NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiries');
    }
};
