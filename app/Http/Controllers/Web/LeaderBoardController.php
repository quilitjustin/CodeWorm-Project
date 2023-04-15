<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaderBoardController extends Controller
{
    //
    public function index()
    {
        $records = \DB::table('game_records')
            ->join('users', 'game_records.player_id', '=', 'users.id')
            ->select('game_records.record', 'users.id' , 'users.f_name', 'users.l_name')
            ->orderBy('game_records.record', 'ASC')
            ->limit(100)
            ->get();

        return view('web.leaderboard', [
            'records' => $records,
        ]);
    }
}
