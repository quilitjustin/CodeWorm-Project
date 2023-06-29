<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            $name = $faker->name;
            DB::table('tasks')->insert([
                'name' => 'Print ' . $name,
                'difficulty' => 'Easy',
                'reward' => 0,
                'description' => '<p>Print "Goodmorning" using echo or print</p><p><b>Example:</b></p><p>echo "Goodmorning";</p><p>print "Goodmorning";</p><p>output: Goodmorning</p><p><b>Definition</b></p><p>The differences between echo and print are minimal. Both of these are employed to display data on a screen.</p><p>The changes are negligible: print can be used in expressions while echo does not, and print has a return value of 1. While print only needs one argument, echo can accept several parameters (although this usage is uncommon). Print is slightly quicker than echo.</p>',
                'snippet' => '',
                'answer' => $name,
                'proglang_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
