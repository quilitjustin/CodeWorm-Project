<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgrammingLanguages as ProgLang;
use Illuminate\Support\Facades\Auth;

class ProgrammingLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $proglangs = ProgLang::paginate(7);

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
            'name' => ['required'],
        ]);

        $proglang = new ProgLang();
        $proglang->name = $this->capitalize($request['name']);

        $proglang->created_by = Auth::user()->id;
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
    public function show(ProgLang $proglang)
    {
        //
        return view('superadmin.game.proglang.show', [
            'proglang' => $proglang,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgLang $proglang)
    {
        //
        return view('superadmin.game.proglang.edit', [
            'proglang' => $proglang,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgLang $proglang)
    {
        //
        $request->validate([
            'name' => ['required'],
        ]);

        $proglang->name = $this->capitalize($request->name);

        $proglang->updated_by = Auth::user()->id;

        $proglang->save();

        return redirect()
            ->route('proglangs.show', [
                'proglang' => $proglang->id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgLang $proglang)
    {
        $proglang->delete();

        return redirect()
            ->route('proglangs.index')
            ->with('msg', 'Deleted Successfully');
    }
}
