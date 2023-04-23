<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class BGMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('b_g_m_s')->insert([
            'name' => 'Bambina Ost',
            'path' => 'game/BGM/1682176656-Asdf.mp3',
            'created_by' => 1,
        ]);
    }
}
