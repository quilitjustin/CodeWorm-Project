<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $stories = Story::paginate(50);

        return view('web.story.index', [
            'stories' => $stories,
        ]);
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
        $data = Story::findOrFail($id);

        $previous = Story::select('id')->where('id', '<', $id)
            ->orderBy('id', 'desc')
            ->first();

        $next = Story::select('id')->where('id', '>', $id)
            ->orderBy('id', 'asc')
            ->first();

        return view('web.story.show', [
            'story' => $data,
            'previous' => $previous,
            'next' => $next
        ]);
    }
}
