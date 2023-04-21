<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameRecord;
use App\Models\Stages;

class LeaderBoardController extends Controller
{
    //
    protected function formatTime($time)
    {
        $timeInSeconds = round($time / 1000);
        $hours = floor($timeInSeconds / 3600);
        $minutes = floor(($timeInSeconds % 3600) / 60);
        $seconds = $timeInSeconds % 60;
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    public function index(Request $request)
    {
        $proglang_id = 2;

        $records = GameRecord::select('user_id')
            ->selectRaw('SUM(record) as total_time')
            ->where('proglang_id', $proglang_id)
            ->groupBy('user_id')
            ->havingRaw('COUNT(DISTINCT stage_id) = ?', [Stages::where('proglang_id', $proglang_id)->count()])
            ->orderBy('total_time', 'asc')
            ->with('users:id,f_name,l_name,profile_picture')
            ->limit(100)
            ->get()
            ->map(function ($item) {
                $item->total_time = $this->formatTime($item->total_time);
                return $item;
            });

        return view('web.leaderboard', [
            'records' => $records,
        ]);
    }
}
