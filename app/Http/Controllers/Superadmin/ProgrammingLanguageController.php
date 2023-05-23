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
            'key' => ['required', 'integer']
        ]);

        $proglang = new ProgLang();
        $proglang->name = strip_tags($request['name']);
        if(!is_null($request['key'])){
            $proglang->key = $request['key'];
        }
        $proglang->created_by = Auth::user()->id;
        $proglang->save();

        return redirect()
            ->route('super.proglangs.show', [
                'proglang' => $proglang->encrypted_id,
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
        $id = decrypt($proglang);
        $data = Proglang::with('stages:id,name,proglang_id', 'created_by_user:id,f_name,l_name', 'updated_by_user:id,f_name,l_name')->findorfail($id);

        return view('superadmin.game.proglang.show', [
            'proglang' => $data,
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
            'key' => ['required', 'integer']
        ]);
        $data = $this->findRecord($proglang);

        $data->name = strip_tags($request->name);
        if(!is_null($request['key'])){
            $proglang->key = $request['key'];
        }
        $data->updated_by = Auth::user()->id;

        $data->save();

        return redirect()
            ->route('super.proglangs.show', [
                'proglang' => $data->encrypted_id,
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
            ->route('super.proglangs.index')
            ->with('msg', 'Deleted Successfully');
    }
}
