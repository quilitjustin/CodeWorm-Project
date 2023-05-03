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
    protected function sanitize_code($data){
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $data = $purifier->purify($data);

        // Remove HTML tags and attributes except for <code> and <pre>
        $data = preg_replace('/<(?!(\/?(code|pre)))\w+.*?>/si', '', $data);

        // Remove any remaining script tags and attributes
        $data = preg_replace('/<script\b[^>]*>(.*?)<\/script>/si', '', $data);
        return $data;
    }

    private function sanitize_description($content)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p[style],b,i,u,span[style],font[style],br,ol,ul,li[style],table,tbody,tr,td,h1,h2,h3,h4,h5,h6');
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($content);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Tasks::with('proglang:id,name')->select('id', 'name', 'difficulty', 'proglang_id')->get();

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
        $proglangs = Proglang::select('id', 'name')->get(); 

        return view('superadmin.game.tasks.create', [
            'proglangs' => $proglangs,
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
            'difficulty' => ['required', 'in:Easy,Medium,Hard'],
            'snippet' => ['max:255'],
            'description' => ['required'],
            'answer' => ['required', 'max:255'],
            'proglang' => ['required'],
            'reward' => ['required', 'integer'],
        ]);

        $proglang_id = decrypt($request['proglang']);
        $proglang = Proglang::findorfail($proglang_id);

        $task = new Tasks();
        $task->name = strip_tags($request['name']);
        $task->difficulty = strip_tags($request['difficulty']);
        $task->description = $this->sanitize_description($request['description']);
        if($request['snippet'] != ""){
            $task->snippet = $this->sanitize_code($request['snippet']);
        }
        $task->answer = strip_tags($request['answer']);
        $task->reward = strip_tags($request['reward']);
        $task->proglang_id = $proglang_id;
        $uid = Auth::user()->id;
        $task->created_by = $uid;
        $task->updated_by = $uid;
        $task->save();

        return redirect()
            ->route('super.tasks.show', [
                'task' => $task->encrypted_id,
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
        $id = decrypt($task);
        $data = Tasks::with('proglang:id,name', 'created_by_user:id,f_name,l_name', 'updated_by_user:id,f_name,l_name')->findorfail($id);

        return view('superadmin.game.tasks.show', [
            'task' => $data,
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
        $id = decrypt($task);
        $data = Tasks::with('proglang:id,name')->findorfail($id);

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
            'difficulty' => ['required', 'in:Easy,Medium,Hard'],
            'description' => ['required'],
            'snippet' => ['max:255'],
            'answer' => ['required', 'max:255'],
            'proglang' => ['required'],
            'reward' => ['required', 'integer'],
        ]);
        
        $proglang_id = decrypt($request['proglang']);
        $proglang = Proglang::findorfail($proglang_id);
        
        $data = $this->findRecord($task);

        $data->name = strip_tags($request['name']);
        $data->difficulty = strip_tags($request['difficulty']);
        $data->description = $this->sanitize_description($request['description']);
        if($request['snippet'] != ""){
            $data->snippet = $this->sanitize_code($request['snippet']);
        }
        $data->answer = strip_tags($request['answer']);
        $data->reward = strip_tags($request['reward']);
        $data->proglang_id = $proglang_id;
        $data->updated_by = Auth::user()->id;
        $data->save();
   
        return redirect()
            ->route('super.tasks.show', [
                'task' => $data->encrypted_id,
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

        return redirect()
            ->route('super.tasks.index')
            ->with('msg', 'Deleted Successfully');
    }
}
