<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stories')->insert([
            'title' => 'Prologue',
            'contents' => '<p>There was a god who was omnipotent and omniscient in a
            universe unlike any other. For years, people had worshiped this deity, who had
            given them direction and safety. But one day the deity suddenly vanished,
            leaving behind bits of worms of code.</p><p></p>
            
            <p>It was said that the code worms were dispersed around the
            country and that the powers of the god would pass to the person who could
            collect them all. The most daring and ambitious explorers start on a quest to
            locate the code worm fragments and obtain the god\'s inheritance.</p>
            
            <p>The group\'s trek brought them to a tower that protruded far
            into the sky, and it was rumored that there were numerous elusive beings and
            creatures guarding the god\'s code worm fragments there. The adventurers
            encountered many difficulties as they ascended the tower, fending off hazardous
            animals and completing challenging puzzles to reach each floor.</p><p></p>
            
            <p>But as they gained strength from each triumph, they
            eventually reached the pinnacle of the tower. They discovered a powerful person
            there who was the final keeper of the god\'s fragments. The explorers battled
            the being in a ferocious struggle, employing all of their abilities to vanquish
            it.</p><p></p>
            
            <p>After taking down the last guardian, the explorers were able
            to finally take possession of the god\'s inheritance—the bits of his code worms.
            However, they were unaware that their journey had only just begun because the
            powers they had attained were much more than they had ever anticipated, and
            carrying the weight of being the god\'s heirs would be a tremendous load.</p><p></p>',
            'created_by' => 1,
        ]);
    }
}
