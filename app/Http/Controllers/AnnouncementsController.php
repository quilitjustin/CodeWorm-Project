<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcements;
use Illuminate\Support\Facades\Auth;
use HTMLPurifier;
use HTMLPurifier_Config;

class AnnouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $announcements = Announcements::paginate(7);

        return view('superadmin.announcements.index', [
            'announcements' => $announcements,
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
        return view('superadmin.announcements.create');
    }

    private function sanitize($content)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,b,i,u,pre,font[style],br');
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($content);
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

        $announcement = new Announcements();
        $announcement->title = strip_tags($request['title']);
        $announcement->contents = $this->sanitize($request['content']);
        $announcement->created_by = Auth::user()->id;
        $announcement->save();

        return redirect()
            ->route('announcements.show', [
                'announcement' => $announcement->id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Announcements $announcement)
    {
        //
        return view('superadmin.announcements.show', [
            'announcement' => $announcement
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcements $announcement)
    {
        //
        return view('superadmin.announcements.edit', [
            'announcement' => $announcement
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcements $announcement)
    {
        //
        $request->validate([
            'title' => ['required', 'max:255'],
            'content' => ['required'],
        ]);

        $announcement->title = strip_tags($request['title']);
        $announcement->contents = $this->sanitize($request['content']);
        $announcement->updated_by = Auth::user()->id;
        $announcement->save();

        return redirect()
            ->route('announcements.show', [
                'announcement' => $announcement->id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcements $announcement)
    {
        //
        $announcement->delete();

        return redirect()
            ->route('announcements.index')
            ->with('msg', 'Deleted Successfully');
    }
}
