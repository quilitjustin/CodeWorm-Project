<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgrammingLanguages as ProgLang;
use Illuminate\Support\Facades\Auth;

class ProgrammingLanguageController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = ProgLang::findorfail($id);
        return $data;
    }

    protected function capitalize($data)
    {
        // Because we are not using request this time
        // I will strip tags here instead
        $data = strip_tags($data);
        return ucwords(strtolower($data));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $proglangs = ProgLang::select('id', 'name')->get();

        return view('superadmin.game.proglang.index', [
            'proglangs' => $proglangs,
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
        return view('superadmin.game.proglang.create');
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
            'name' => ['required', 'unique:programming_languages', 'max:255'],
        ]);

        $proglang = new ProgLang();
        $proglang->name = $this->capitalize($request['name']);

        $proglang->created_by = decrypt(Auth::user()->id);
        $proglang->save();

        return redirect()
            ->route('proglangs.show', [
                'proglang' => $proglang->id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($proglang)
    {
        $data = $this->findRecord($proglang);
        // You can import this above with use statement
        // But since I'm only going to use it once here so I won't
        $stages = \App\Models\Stages::select('id', 'name')->where('proglang_id', $data->id)->get();
        
        return view('superadmin.game.proglang.show', [
            'proglang' => $data,
            'stages' => $stages,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($proglang)
    {
        $data = $this->findRecord($proglang);

        return view('superadmin.game.proglang.edit', [
            'proglang' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $proglang)
    {
        //
        $request->validate([
            'name' => ['required', 'unique:programming_languages', 'max:255'],
        ]);
        $data = $this->findRecord($proglang);

        $data->name = $this->capitalize($request->name);

        $data->updated_by = decrypt(Auth::user()->id);

        $data->save();

        return redirect()
            ->route('proglangs.show', [
                'proglang' => $data->id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($proglang)
    {
        $data = $this->findRecord($proglang);

        $data->delete();

        return redirect()
            ->route('proglangs.index')
            ->with('msg', 'Deleted Successfully');
    }
}
