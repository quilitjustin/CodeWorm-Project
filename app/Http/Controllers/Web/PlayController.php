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
        \Cache::put('tutorial_seen', true, 999999);

        $proglangs = \App\Models\ProgrammingLanguages::select('id', 'name')->get();

        return view('web.play.index', [
            'proglangs' => $proglangs,
        ]);
    }

    protected function formatTime($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    public function stages($id)
    {
        $id = decrypt($id);
        $stages = Stages::with('bgim:id,path', 'game_records_users:record,stage_id,user_id')
            ->select('id', 'name', 'bgim_id')
            ->where('proglang_id', $id)
            ->get()
            ->map(function ($stage) {
                $stage->game_records_users->each(function ($record) {
                    $record->record = $this->formatTime($record->record);
                });
                return $stage;
            });

        return view('web.play.stages', [
            'stages' => $stages,
        ]);
    }

    public function game_start($id)
    {
        $id = decrypt($id);
        $stage = Stages::with([
            'proglang:id,name,key',
            'tasks' => function ($query) {
                $query->inRandomOrder();
            },
            'badges:id,name,path',
            'bgim:id,path',
            'bgm:id,path',
        ])->findOrFail($id, ['id', 'name', 'proglang_id', 'bgm_id', 'bgim_id', 'badge_id', 'player_base_hp', 'player_base_sp', 'enemy_base_hp', 'enemy_base_dmg']);
        $next_stage = Stages::select('id', 'name')
            ->where('id', '>', $id)
            ->where('proglang_id', $stage->proglang_id)
            ->first();

        return view('layouts.play', [
            'stage' => $stage,
            'next_stage' => $next_stage,
        ]);
    }

    public function save_record(Request $request)
    {
        $uid = Auth::user()->id;
        $stage_id = decrypt($request['stageId']);
        $proglang_id = decrypt($request['proglangId']);
        $userRecord = \App\Models\GameRecord::where('user_id', $uid)
            ->where('stage_id', $stage_id)
            ->first();

        if (is_null($userRecord)) {
            // User does not have a record for this stage, create a new record
            $record = new \App\Models\GameRecord();
            $record->record = $request['record'];
            $record->proglang_id = $proglang_id;
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

            $user->badges()->syncWithoutDetaching($badge);
        }

        return response()->json(['message' => 'success']);
    }
}
