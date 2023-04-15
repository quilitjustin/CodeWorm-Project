<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\ProgrammingLanguages as Proglang;
use Illuminate\Support\Facades\Auth;
use HTMLPurifier;
use HTMLPurifier_Config;

class TasksController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = Tasks::findorfail($id);
        return $data;
    }

    // Clean the snippet
    protected function sanitize($data){
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $data = $purifier->purify($data);

        // Remove HTML tags and attributes except for <code> and <pre>
        $data = preg_replace('/<(?!(\/?(code|pre)))\w+.*?>/si', '', $data);

        // Remove any remaining script tags and attributes
        $data = preg_replace('/<script\b[^>]*>(.*?)<\/script>/si', '', $data);
        return $data;
    }

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
        $tasks = \DB::table('tasks')
            ->join('programming_languages', 'tasks.proglang_id', '=', 'programming_languages.id')
            ->select('tasks.id', 'tasks.name', 'programming_languages.id as proglang_id', 'programming_languages.name as proglang_name')
            ->get();

        // $tasks = json_decode($tasks, true);
        return view('superadmin.game.tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.game.tasks.create');
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
            'snippet' => ['required', 'max:255'],
            'answer' => ['required', 'max:255'],
            'proglang' => ['required'],
        ]);

        $proglang_id = decrypt($request['proglang']);
        $proglang = Proglang::findorfail($proglang_id);

        $task = new Tasks();
        $task->name = strip_tags($request['name']);
        $task->snippet = $this->sanitize($request['snippet']);
        $task->answer = strip_tags($request['answer']);
        $task->proglang_id = $proglang_id;
        $task->created_by = decrypt(Auth::user()->id);
        $task->save();

        return redirect()
            ->route('tasks.show', [
                'task' => $task->id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($task)
    {
        $data = $this->findRecord($task);
        $created_by = \App\Models\User::select('id', 'f_name', 'l_name')->where('id', $data->created_by);
        $updated_by = \App\Models\User::select('id', 'f_name', 'l_name')->where('id', $data->updated_by);
        $other = $created_by->unionAll($updated_by)->get();
    
        return view('superadmin.game.tasks.show', [
            'task' => $data,
            'other' => $other,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($task)
    {
        //
        $data = $this->findRecord($task);

        return view('superadmin.game.tasks.edit', [
            'task' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $task)
    {   
        $request->validate([
            'name' => ['required', 'max:255'],
            'snippet' => ['required', 'max:255'],
            'answer' => ['required', 'max:255'],
            'proglang' => ['required'],
        ]);
        
        $proglang_id = decrypt($request['proglang']);
        $proglang = Proglang::findorfail($proglang_id);
        
        $data = $this->findRecord($task);

        $data->name = strip_tags($request['name']);
        $data->snippet = $this->sanitize($request['snippet']);
        $data->answer = strip_tags($request['answer']);
        $data->proglang_id = $proglang_id;
        $data->updated_by = decrypt(Auth::user()->id);
        $data->save();
   
        return redirect()
            ->route('tasks.show', [
                'task' => $data->id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($task)
    {
        //
        $data = $this->findRecord($task);
        $data->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
