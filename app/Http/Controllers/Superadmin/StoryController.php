<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use HTMLPurifier;
use HTMLPurifier_Config;

class StoryController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = Story::findorfail($id);
        return $data;
    }

    private function sanitize($content)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,b,i,u,pre,font[style],br');
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
        //
        $stories = Story::paginate(7);

        return view('superadmin.story.index', [
            'stories' => $stories,
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
        return view('superadmin.story.create');
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
            'title' => ['required', 'max:255'],
            'content' => ['required'],
        ]);

        $story = new Story();
        $story->title = strip_tags($request['title']);
        $story->contents = $this->sanitize($request['content']);
        $story->created_by = Auth::user()->id;
        $story->save();

        return redirect()
            ->route('super.stories.show', [
                'story' => $story->encrypted_id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($story)
    {
        $id = decrypt($story);
        $data = story::with('created_by_user:id,f_name,l_name', 'updated_by_user:id,f_name,l_name')->findorfail($id);

        return view('superadmin.story.show', [
            'story' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($story)
    {
        $data = $this->findRecord($story);

        return view('superadmin.story.edit', [
            'story' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $story)
    {
        //
        $request->validate([
            'title' => ['required', 'max:255'],
            'content' => ['required'],
        ]);
        $data = $this->findRecord($story);

        $data->title = strip_tags($request['title']);
        $data->contents = $this->sanitize($request['content']);
        $data->updated_by = Auth::user()->id;
        $data->save();

        return redirect()
            ->route('super.stories.show', [
                'story' => $data->encrypted_id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($story)
    {
        $data = $this->findRecord($story);
        $data->delete();

        return redirect()
            ->route('super.stories.index')
            ->with('msg', 'Deleted Successfully');
    }
}
