<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            'name' => 'Print Hello World',
            'difficulty' => 'Easy',
            'reward' => 50,
            'description' => 'Print Hello World using console.log()',
            'answer' => 'Hello World',
            'proglang_id' => 2,
            'created_by' => 1,
        ]);

        DB::table('tasks')->insert([
            'name' => 'Print Hello World',
            'difficulty' => 'Easy',
            'reward' => 50,
            'description' => 'Print Hello World using echo',
            'answer' => 'Hello World',
            'proglang_id' => 1,
            'created_by' => 1,
        ]);
    }
}
