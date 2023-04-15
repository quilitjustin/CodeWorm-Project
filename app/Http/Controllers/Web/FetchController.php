<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tasks;

class FetchController extends Controller
{
    //
    public function fetch_task_php(){
        $data = Tasks::select('name', 'snippet', 'answer')->where('proglang_id', '1')->get();
        return response()->json($data);
    }

    public function fetch_task_js(){
        $data = Tasks::select('name', 'snippet', 'answer')->where('proglang_id', '2')->get();
        return response()->json($data);
    }
}
