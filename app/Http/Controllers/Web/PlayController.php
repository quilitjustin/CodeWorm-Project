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
        $stage = Stages::with('proglang:id,name', 'badges:id,name,path', 'bgim:id,path', 'bgm:id,path')->findOrFail($id, ['id', 'name', 'tasks', 'proglang_id', 'bgm_id', 'bgim_id', 'badge_id', 'player_base_hp', 'player_base_sp', 'enemy_base_hp', 'enemy_base_dmg']);
        $next_stage = Stages::select('id', 'name')
            ->where('id', '>', $id)
            ->where('proglang_id', $stage->proglang_id)
            ->first();

        $tasks = \App\Models\Tasks::select('id', 'name', 'description', 'snippet', 'difficulty', 'answer', 'reward')
            ->whereIn('id', $stage->tasks)
            ->get();

        return view('layouts.play', [
            'stage' => $stage,
            'tasks' => $tasks,
            'next_stage' => $next_stage,
        ]);
    }

    public function save_record(Request $request)
    {
        $uid = Auth::user()->id;
        $stage_id = decrypt($request['stageId']);

        $userRecord = \App\Models\GameRecord::where('user_id', $uid)
            ->where('stage_id', $stage_id)
            ->first();

        if (is_null($userRecord)) {
            // User does not have a record for this stage, create a new record
            $record = new \App\Models\GameRecord();
            $record->record = $request['record'];
            $record->proglang_id = $request['proglangId'];
            $record->stage_id = $stage_id;
            $record->user_id = $uid;
            $record->save();
        } else {
            // User already has a record for this stage
            if ($userRecord->record > $request['record']) {
                // Update the record with the new time if it is faster than the existing record
                $userRecord->record = $request['record'];
                $userRecord->save();
            }
        }

        if (!is_null($request['badgeId'])) {
            $badge_id = decrypt($request['badgeId']);
            $user = \App\Models\User::findorfail($uid);
            $badge = \App\Models\Badges::findorfail($badge_id);

            $user->badges()->attach($badge);
        }

        return response()->json(['message' => 'success']);
    }
}
