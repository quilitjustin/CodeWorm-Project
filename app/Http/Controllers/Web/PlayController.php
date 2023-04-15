<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        dd($id);
    }

    public function save_record(Request $request)
    {
        $record = new \App\Models\GameRecord();
        $record->record = $request['record'];
        $record->proglang_id = $request['proglangId'];
        $record->stage_id = $request['stageId'];
        $record->player_id = decrypt($request['userId']);
        $record->save();

        return response()->json(['message' => 'success']);
    }
}
