<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class LeaderBoardController extends Controller
{
    //
    public function index(){
        $users = User::select('id', 'f_name', 'l_name')->limit(100)->get();

        return view('web.leaderboard', [
            'users' => $users
        ]);
    }
}
