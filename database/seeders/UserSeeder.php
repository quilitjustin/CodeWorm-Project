<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        //
        DB::table('users')->insert([
            'f_name' => $faker->firstName,
            'm_name' => $faker->lastName,
            'l_name' => $faker->lastName,
            'email' => 'superadmin@gmail.com',
            'role' => 'superadmin',
            'created_by' => 1,
            'password' => Hash::make('password'),
        ]);
        // Generate another 100 random user
        for ($i = 0; $i < 100; $i++) {
            DB::table('users')->insert([
                'f_name' => $faker->firstName,
                'm_name' => $faker->lastName,
                'l_name' => $faker->lastName,
                // Trick to avoid constraint violation
                'email' => preg_replace('/@example\..*/', '@domain.com', $faker->unique()->safeEmail),
                'role' => $faker->randomElement(['admin', 'user']),
                'password' => Hash::make('password'),
                'created_by' => 1,
            ]);
        }
    }
}
