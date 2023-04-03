<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stages;
use Illuminate\Support\Facades\Auth;

class StagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $stages = Stages::select('id', 'name')->get();
        
        return view('superadmin.game.stages.index', [
            'stages' => $stages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('superadmin.game.stages.create');
    }

    protected function capitalize($data)
    {
        // Because we are not using request this time
        // I will strip tags here instead
        $data = strip_tags($data);
        return ucwords(strtolower($data));
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
            'name' => ['required', 'unique:stages', 'max:255'],
        ]);

        $stage = new Stages();
        $stage->name = $this->capitalize($request['name']);

        $stage->created_by = Auth::user()->id;
        $stage->save();

        return redirect()
            ->route('stages.show', [
                'stage' => encrypt($stage->id),
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
        //
        $uid = decrypt($stage);
        $stage = Stages::findorfail($uid);
        $encrypted_id = encrypt($stage->id);

        //
        return view('superadmin.game.stages.show', [
            'id' => $encrypted_id,
            'stage' => $stage
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
        $uid = decrypt($stage);
        $stage = Stages::select('id', 'name')->findorfail($uid);
        $encrypted_id = encrypt($stage->id);

        return view('superadmin.game.stages.edit', [
            'id' => $encrypted_id,
            'stage' => $stage
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
