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
            $table->string('role')->default('user');
        });

        DB::statement("ALTER TABLE users 
            MODIFY role 
            ENUM('superadmin', 'admin', 'user') 
            NOT NULL DEFAULT 'user'");
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
            $table->dropColumn('role');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
};
