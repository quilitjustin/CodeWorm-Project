<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stages;
use Illuminate\Support\Facades\Auth;

class PlayController extends Controller
{
    //
    public function index()
    {
        $proglangs = \App\Models\ProgrammingLanguages::select('id', 'name')->get();

        return view('web.play.index', [
            'proglangs' => $proglangs,
        ]);
    }

    public function stages($id)
    {
        $id = decrypt($id);
        $stages = Stages::select('id', 'name')
            ->where('proglang_id', $id)
            ->get();

        return view('web.play.stages', [
            'stages' => $stages,
        ]);
    }

    public function game_start($id)
    {
        $id = decrypt($id);
        $stage = Stages::with('proglang:id,name', 'badges:id,name,path')->findOrFail($id, ['id', 'name', 'tasks', 'proglang_id', 'badge_id']);
        $proglang = \App\Models\ProgrammingLanguages::select('id', 'name')->where('id', $stage->proglang_id);
        $next_stage = Stages::select('id', 'name')
            ->where('id', '>', $id)
            ->where('proglang_id', $stage->proglang_id);
        $other = $proglang->unionAll($next_stage);
        $other = $other->get();

        $arr = [];
        foreach ($stage->tasks as $task) {
            array_push($arr, \App\Models\Tasks::select('id', 'name', 'description', 'snippet', 'difficulty', 'answer', 'reward')->where('id', $task));
        }
        $result = collect($arr)->reduce(function ($query1, $query2) {
            if ($query1 && $query2) {
                return $query1->union($query2);
            } else {
                return $query1 ?? $query2;
            }
        });
        $tasks = $result->get();

        return view('layouts.play', [
            'stage' => $stage,
            'tasks' => $tasks,
            'other' => $other,
        ]);
    }

    public function save_record(Request $request)
    {
        $uid = Auth::user()->id;
        $badge_id = decrypt($request['badgeId']);

        $record = new \App\Models\GameRecord();
        $record->record = $request['record'];
        $record->proglang_id = $request['proglangId'];
        $record->stage_id = decrypt($request['stageId']);
        $record->user_id = $uid;
        $record->save();

        $user = \App\Models\User::findorfail($uid);
        $badge = \App\Models\Badges::findorfail($badge_id);
        // Check if the badge is already attached to the user
        if (!$user->badges->contains($badge)) {
            $user->badges()->syncWithoutDetaching($badge);
        }

        return response()->json(['message' => 'success']);
    }
}
