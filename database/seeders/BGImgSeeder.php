<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class BGImgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('b_g_imgs')->insert([
            'name' => 'Halloween Forest',
            'path' => 'game/BackgroundImage/1682176636-tmp.png',
            'created_by' => 1,
        ]);
    }
}
