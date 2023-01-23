<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LeaderBoardController extends Controller
{
    //
    public function index(){
        $users = User::all();
        return view('public.leaderboard', [
            'users' => $users
        ]);
    }
}
