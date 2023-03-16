<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'f_name' => Str::random(10),
            'm_name' => Str::random(10),
            'l_name' => Str::random(10),
            'email' => 'superadmin@gmail.com',
            'role' => 'superadmin',
            'created_by' => 1,
            'password' => Hash::make('password'),
        ]);
    }
}
