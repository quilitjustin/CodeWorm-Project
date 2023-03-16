<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SplashPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(base_path('public/json/content.json'));

        DB::table('splash_pages')->insert([
            'content' => $json,
            'created_by' => 1,
        ]);
    }
}
