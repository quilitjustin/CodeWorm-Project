<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FetchController extends Controller
{
    public function languages()
    {
        $data = \App\Models\ProgrammingLanguages::select('id', 'name')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($data);
    }

    public function tasks(Request $request)
    {
        if ($request->ajax()) {
            $id = decrypt($request['id']);

            $data = \App\Models\Tasks::select('id', 'name', 'difficulty')->where('proglang_id', $id)->whereNull('stage_id')->orderByRaw("FIELD(difficulty, 'Easy', 'Medium', 'Hard')")->get();

            return response()->json($data);
        }
    }
}
