<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stages;
use App\Models\ProgrammingLanguages as Proglang;
use Illuminate\Support\Facades\Auth;

class StagesController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = Stages::findorfail($id);
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stages = Stages::select('id', 'name', 'proglang_id')->with('proglang:id,name')->get();
dd($stages->proglang->name);
        // $stage = json_decode($stage, true);
        return view('superadmin.game.stages.index', [
            'stages' => $stages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.game.stages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => ['required', 'max:255'],
            'tasks' => ['required', 'array'],
            'proglang' => ['required'],
        ]);

        $proglang_id = decrypt($request['proglang']);
        $proglang = Proglang::findorfail($proglang_id);

        $stage = new Stages();
        $stage->name = strip_tags($request['name']);

        $arr = [];
        foreach ($request['tasks'] as $task) {
            array_push($arr, decrypt($task));
        }
        $stage->tasks = $arr;
        $stage->proglang_id = $proglang_id;
        $stage->created_by = decrypt(Auth::user()->id);
        $stage->save();

        return redirect()
            ->route('stages.show', [
                'stage' => $stage->id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($stage)
    {
        $data = $this->findRecord($stage);
        $arr = [];
        foreach ($data->tasks as $task) {
            array_push($arr, \App\Models\Tasks::select('id', 'name')->where('id', $task));
        }
        $result = collect($arr)->reduce(function ($query1, $query2) {
            if ($query1 && $query2) {
                return $query1->union($query2);
            } else {
                return $query1 ?? $query2;
            }
        });
        $tasks = $result->get();
        // Just a work around to make union work or it'll throw an error ('name', 'name')
        $proglang = Proglang::select('id', 'name as f_name', 'name as l_name')->where('id', $data->proglang_id);
        $created_by = \App\Models\User::select('id', 'f_name', 'l_name')->where('id', $data->created_by);
        $updated_by = \App\Models\User::select('id', 'f_name', 'l_name')->where('id', $data->updated_by);
        $other = $created_by->unionAll($updated_by)->get();

        return view('superadmin.game.stages.show', [
            'stage' => $data,
            'other' => $other,
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($stage)
    {
        //
        $data = $this->findRecord($stage);

        return view('superadmin.game.stages.edit', [
            'stage' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $stage)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'proglang' => ['required'],
        ]);

        $proglang_id = decrypt($request['proglang']);
        $proglang = Proglang::findorfail($proglang_id);

        $data = $this->findRecord($stage);

        $data->name = strip_tags($request['name']);
        $data->proglang_id = $proglang_id;
        $data->updated_by = decrypt(Auth::user()->id);
        $data->save();

        return redirect()
            ->route('stages.show', [
                'stage' => $data->id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($stage)
    {
        //
        $data = $this->findRecord($stage);
        $data->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
