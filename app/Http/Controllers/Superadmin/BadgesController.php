<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Badges;
use Illuminate\Support\Facades\Auth;

class BadgesController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = Badges::findorfail($id);
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
        $badges = Badges::select('id', 'name')->get();

        return view('superadmin.badges.index', [
            'badges' => $badges,
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
        return view('superadmin.badges.create');
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
            'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
        ]);

        $badge = new Badges();
        $badge->name = $this->capitalize($request['name']);

        // To avoid having a file with the same name
        $newImageName = time() . '-' . $badge['name'] . '.' . $request['image']->extension();
        // Where to store the image
        $path = 'game/Effects/Badgess';
        // Store the image in public directory
        $request['image']->move(public_path($path), $newImageName);
        // Output would be like: game/Effects/Badgess/image.png
        // So we can just do something like asset($foo['path']) than asset(game/Effects/Badgess/$foo['path'])
        $badge->path = $path . '/' . $newImageName;
        $badge->created_by = decrypt(Auth::user()->id);
        $badge->save();

        return redirect()
            ->route('badges.show', [
                'badge' => $badge->encrypted_id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($badge)
    {
        $data = $this->findRecord($badge);

        return view('superadmin.badges.show', [
            'badge' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($badge)
    {
        $data = $this->findRecord($badge);

        return view('superadmin.badges.edit', [
            'badge' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $badge)
    {
        //
        $request->validate([
            'name' => ['required', 'max:255'],
            'action' => ['required', 'in:true,false'],
        ]);
        $data = $this->findRecord($badge);

        $rule = strip_tags($request['action']);

        $data->name = $this->capitalize($request->name);

        // For more clarity I use == 'true'
        if ($rule == 'true') {
            $request->validate([
                'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
            ]);
            // Make sure you delete the file first before updating the record in db
            // But before that, you need to make sure that the file still exist in the first place
            if (file_exists($data->path)) {
                unlink($data->path);
            }
            // To avoid having a file with the same name
            $newImageName = time() . '-' . $data->name . '.' . $request['image']->extension();
            // Where to store the image
            $path = 'game/Effects/Badgess';
            // Store the image in public directory
            $request['image']->move(public_path($path), $newImageName);
            // Output would be like: game/Effects/Badgess/image.png
            // So we can just do something like asset($foo['path']) than asset(game/Effects/Badgess/$foo['path'])
            $data->path = $path . '/' . $newImageName;
        }

        $data->updated_by = decrypt(Auth::user()->id);

        $data->save();

        return redirect()
            ->route('badges.show', [
                'badge' => $data->encrypted_id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($badge)
    {
        $data = $this->findRecord($badge);
        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($data['path'])) {
            unlink($data['path']);
        }

        $data->delete();

        return redirect()
            ->route('badges.index')
            ->with('msg', 'Deleted Successfully');
    }
}
