<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stages;
use App\Models\Badges;
use App\Models\BGImg;
use App\Models\BGM;
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
        $stages = Stages::with('proglang:id,name')
            ->select('id', 'name', 'proglang_id')
            ->get();

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
        $proglangs = Proglang::select('id', 'name')->get();
        $rewards = Badges::select('id', 'name')->get();
        $bgims = BGImg::select('id', 'name')->get();
        $bgms = BGM::select('id', 'name')->get();

        return view('superadmin.game.stages.create', [
            'proglangs' => $proglangs,
            'rewards' => $rewards,
            'bgims' => $bgims,
            'bgms' => $bgms,
        ]);
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
            'bgim' => ['required'],
            'bgm' => ['required'],
            'player-base-hp' => ['required', 'integer'],
            'enemy-base-hp' => ['required', 'integer'],
            'player-base-sp' => ['required', 'integer'],
            'enemy-rage-timer' => ['required', 'integer'],
        ]);

        $proglang_id = decrypt($request['proglang']);
        $proglang = Proglang::findorfail($proglang_id);
        $bgim_id = decrypt($request['bgim']);
        $bgm_id = decrypt($request['bgm']);

        $stage = new Stages();
        $stage->name = strip_tags($request['name']);

        $arr = [];
        foreach ($request['tasks'] as $task) {
            array_push($arr, decrypt($task));
        }
        $stage->tasks = $arr;
        $stage->proglang_id = $proglang_id;
        // Only if there is a reward for this stage
        if (!is_null($request['reward'])) {
            $reward_id = decrypt($request['reward']);
            $badge = Badges::findorfail($reward_id);
            $stage->badge_id = $reward_id;
        }
        $stage->bgim_id = $bgim_id;
        $stage->bgm_id = $bgm_id;
        $stage->player_base_hp = strip_tags($request['player-base-hp']);
        $stage->enemy_base_hp = strip_tags($request['enemy-base-hp']);
        $stage->player_base_sp = strip_tags($request['player-base-sp']);
        $stage->enemy_rage_timer = strip_tags($request['enemy-rage-timer']);
        $stage->created_by = Auth::user()->id;
        $stage->save();

        return redirect()
            ->route('stages.show', [
                'stage' => $stage->encrypted_id,
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
        $id = decrypt($stage);
        $data = Stages::with('proglang:id,name', 'created_by_user:id,f_name,l_name', 'updated_by_user:id,f_name,l_name')->findorfail($id);

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

        return view('superadmin.game.stages.show', [
            'stage' => $data,
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
        $data->updated_by = Auth::user()->id;
        $data->save();

        return redirect()
            ->route('stages.show', [
                'stage' => $data->encrypted_id,
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

        return redirect()
            ->route('stages.index')
            ->with('msg', 'Deleted Successfully');
    }
}
