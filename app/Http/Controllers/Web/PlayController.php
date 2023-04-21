<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stages;

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
        $stages = Stages::select('id', 'name')->where('proglang_id', $id)->get();

        return view('web.play.stages', [
            'stages' => $stages
        ]);
    }

    public function game_start($id){
        $id = decrypt($id);
        $stage = Stages::findorfail($id)->select('id', 'name', 'tasks', 'proglang_id')->where('id', $id)->get();
        $proglang = \App\Models\ProgrammingLanguages::select('id', 'name')->where('id', $stage[0]->proglang_id);
        $next_stage = Stages::select('id', 'name')->where('id', '>',  $id);
        $other = $proglang->unionAll($next_stage);
        $other = $other->get();
        
        $arr = [];
        foreach ($stage[0]->tasks as $task) {
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
        $record = new \App\Models\GameRecord();
        $record->record = $request['record'];
        $record->proglang_id = $request['proglangId'];
        $record->stage_id = decrypt($request['stageId']);
        $record->user_id = decrypt($request['userId']);
        $record->save();

        return response()->json(['message' => 'success']);
    }
}
