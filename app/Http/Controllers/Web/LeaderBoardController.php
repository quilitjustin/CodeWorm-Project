<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameRecord;

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
        $records = GameRecord::select('user_id')
            ->selectRaw('SUM(record) as total_time')
            ->groupBy('user_id')
            ->orderByAsc('total_time')
            ->with('users:id,f_name,l_name,profile_picture')
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
