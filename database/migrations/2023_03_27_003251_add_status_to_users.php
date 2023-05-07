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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('status')->default('active');
            $table->timestamp('suspended_until')->nullable();
        });

        DB::statement("ALTER TABLE users 
            MODIFY status 
            ENUM('active', 'suspended') 
            NOT NULL DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('status');
            $table->dropColumn('banned_until');
        });
    }
};
