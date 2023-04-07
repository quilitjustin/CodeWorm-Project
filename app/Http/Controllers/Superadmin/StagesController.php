<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stages;
use App\Models\ProgrammingLanguages as Proglang;
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
        // I'm using '\DB' because I'm only using it in index(), but if you want to use it to multiple part of this controller, import it instead using 'use DB'
        // This will return a std class so use ->property_name instead of ['property_name'] 
        // If you really want to return an array, use json_decode true which is commented down below
        // Warning: using json_decode may affect the performance, but it will get the job done so yey?
        $stages = \DB::table('stages')
            ->join('programming_languages', 'stages.proglang_id', '=', 'programming_languages.id')
            ->select('stages.id', 'stages.name', 'programming_languages.id as proglang_id', 'programming_languages.name as proglang_name')
            ->get();

        // $stages = json_decode($stages, true);
        return view('superadmin.game.stages.index', [
            'stages' => $stages,
        ]);
    }

    /**
     * Display available programming language for creation of stage.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect()
    {
        //
        $proglangs = Proglang::select('id', 'name')->get();

        return view('superadmin.game.stages.redirect', [
            'proglangs' => $proglangs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($proglang)
    {
        //
        return view('superadmin.game.stages.create', [
            'proglang' => $proglang,
        ]);
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
            'proglang' => ['required'],
        ]);
        $proglang = Proglang::findorfail($request['proglang']);

        $stage = new Stages();
        $stage->name = $this->capitalize($request['name']);
        $stage->proglang_id = $proglang->id;
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
            'stage' => $stage,
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
            'stage' => $stage,
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
        //
        $uid = decrypt($stage);
        $stage = Stages::findorfail($uid);
        
        $request->validate([
            'name' => ['required', 'unique:stages', 'max:255'],
        ]);

        $stage->name = $this->capitalize($request['name']);
        $stage->updated_by = Auth::user()->id;
        $stage->save();

        return redirect()
            ->route('stages.show', [
                'stage' => encrypt($stage->id),
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
        $uid = decrypt($stage);
        $user = Stages::findorfail($uid);
        $user->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
