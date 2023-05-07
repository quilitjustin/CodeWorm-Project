<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcements;
use Illuminate\Support\Facades\Auth;
use HTMLPurifier;
use HTMLPurifier_Config;

class AnnouncementsController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = Announcements::findorfail($id);
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
        $announcements = Announcements::with('created_by_user:id,f_name,l_name')->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        $pinned = $announcements->where('is_pinned', true);
        $data = $announcements->where('is_pinned', false);

        return view('superadmin.announcements.index', [
            'announcements' => $data,
            'pinned' => $pinned
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
            ->route('super.announcements.show', [
                'announcement' => $announcement->encrypted_id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($announcement)
    {
        $id = decrypt($announcement);
        $data = Announcements::with('created_by_user:id,f_name,l_name', 'updated_by_user:id,f_name,l_name')->findorfail($id);

        return view('superadmin.announcements.show', [
            'announcement' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($announcement)
    {
        $data = $this->findRecord($announcement);

        return view('superadmin.announcements.edit', [
            'announcement' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $announcement)
    {
        //
        $request->validate([
            'title' => ['required', 'max:255'],
            'content' => ['required'],
        ]);
        $data = $this->findRecord($announcement);

        $data->title = strip_tags($request['title']);
        $data->contents = $this->sanitize($request['content']);
        $data->updated_by = Auth::user()->id;
        $data->save();

        return redirect()
            ->route('super.announcements.show', [
                'announcement' => $data->encrypted_id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($announcement)
    {
        $data = $this->findRecord($announcement);
        $data->delete();

        return redirect()
            ->route('super.announcements.index')
            ->with('msg', 'Deleted Successfully');
    }

    public function pin(Request $request, $announcement)
    {
        $count = Announcements::where('is_pinned', 1)->count();

        $data = $this->findRecord($announcement);

        if ($data->is_pinned) {
            $data->is_pinned = 0;
        } else {
            if ($count >= 3) {
                return back()->with(['errmsg' => 'Max pinned announcements reached.\nPlease unpin other pinned announcements to proceed.']);
            }
            $data->is_pinned = 1;
        }
        $data->updated_by = Auth::user()->id;
        $data->save();

        return back()->with(['msg' => 'Pinned Successfully']);
    }
}
