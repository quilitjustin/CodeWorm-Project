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
        $proglangs = Proglang::select('id', 'name')->get();

        return view('web.leaderboard', [
            'proglangs' => $proglangs,
        ]);
    }

    public function entry(Request $request)
    {
        $proglang_id = decrypt($request['id']);

        $data = GameRecord::select('user_id')
        // MAX(id) as id, may not be the actual id of the row
            ->selectRaw('MAX(id) as id, SUM(record) as total_time')
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

        return response()->json($data);
    }
}
