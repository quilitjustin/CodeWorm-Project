<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stages')->insert([
            'name' => 'Stage 1',
            'proglang_id' => 1,
            'badge_id' => null,
            'bgim_id' => 1,
            'bgm_id' => 1,
            'player_base_hp' => 100,
            'enemy_base_hp' => 100,
            'player_base_sp' => 0,
            'enemy_base_dmg' => 5,
            'created_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('stages')->insert([
            'name' => 'Stage 1',
            'proglang_id' => 2,
            'badge_id' => null,
            'bgim_id' => 1,
            'bgm_id' => 1,
            'player_base_hp' => 100,
            'enemy_base_hp' => 100,
            'player_base_sp' => 0,
            'enemy_base_dmg' => 5,
            'created_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
