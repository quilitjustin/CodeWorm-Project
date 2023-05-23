<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameRecord;
use App\Models\Stages;
use App\Models\ProgrammingLanguages as Proglang;

class LeaderBoardController extends Controller
{
    //
    protected function formatTime($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    public function index(Request $request)
    {
        $proglangs = Proglang::select('id', 'name')->get();

        return view('web.leaderboard', [
            'proglangs' => $proglangs,
        ]);
    }

    public function entry(Request $request)
    {
        $proglang_id = decrypt($request['id']);

        $data = GameRecord::select('user_id')
            ->selectRaw('MAX(id) as id, SUM(record) as total_time, COUNT(DISTINCT stage_id) as total_stages_cleared')
            ->where('proglang_id', $proglang_id)
            ->groupBy('user_id')
            ->orderByRaw('total_stages_cleared DESC, total_time ASC') 
            ->with('users:id,f_name,l_name,profile_picture')
            ->limit(100)
            ->get()
            ->map(function ($item) {
                $item->total_time = $this->formatTime($item->total_time);
                return $item;
            });
        
        return response()->json($data);
    }
}
