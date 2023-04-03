<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgrammingLanguages as ProgLang;

class PlayController extends Controller
{
    //
    public function index()
    {
        $proglangs = ProgLang::select('id', 'name')->get();

        return view('web.play.index', [
            'proglangs' => $proglangs,
        ]);
    }

    public function stages($id){
        $id = decrypt($id);
        dd($id);
    }
}
