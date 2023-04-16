<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ProglangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('programming_languages')->insert([
            'name' => 'PHP',
            'created_by' => 1,
        ]);

        DB::table('programming_languages')->insert([
            'name' => 'Javascript',
            'created_by' => 1,
        ]);
    }
}
