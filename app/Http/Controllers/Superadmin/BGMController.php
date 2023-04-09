<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BGM;
use Illuminate\Support\Facades\Auth;

class BGMController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = BGM::findorfail($id);
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
        $bgms = BGM::select('id', 'name')->get();

        return view('superadmin.game.bgm.index', [
            'bgms' => $bgms,
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
        return view('superadmin.game.bgm.create');
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
            'audio' => ['required', 'mimes:application/audio/mpeg,mpga,mp3,wav'],
        ]);

        $bgm = new BGM();
        $bgm->name = $this->capitalize($request['name']);

        // To avoid having a file with the same name
        $newAudioName = time() . '-' . $bgm->name . '.' . $request['audio']->extension();
        // Where to store the image
        $path = 'game/Effects/BGM';
        // Store the image in public directory
        $request['audio']->move(public_path($path), $newAudioName);
        // Output would be like: game/Effects/BGM/image.png
        // So we can just do something like asset($foo['path']) than asset(game/Effects/BGM/$foo['path'])
        $bgm->path = $path . '/' . $newAudioName;
        $bgm->created_by = decrypt(Auth::user()->id);
        $bgm->save();

        return redirect()
            ->route('bgms.show', [
                'bgm' => $bgm->id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bgm)
    {
        $data = $this->findRecord($bgm);

        return view('superadmin.game.bgm.show', [
            'bgm' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BGM $bgm)
    {
        $data = $this->findRecord($bgm);

        return view('superadmin.game.bgm.edit', [
            'bgm' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bgm)
    {
        //
        $request->validate([
            'name' => ['required', 'max:255'],
            'action' => ['required', 'in:true,false'],
        ]);
        $data = $this->findRecord($bgm);

        $rule = strip_tags($request['action']);

        $data->name = $this->capitalize($request->name);

        // For more clarity I use == 'true'
        if ($rule == 'true') {
            $request->validate([
                'audio' => ['required', 'mimes:application/audio/mpeg,mpga,mp3,wav'],
            ]);
            // Make sure you delete the file first before updating the record in db
            // But before that, you need to make sure that the file still exist in the first place
            if (file_exists($data->path)) {
                unlink($data->path);
            }
            // To avoid having a file with the same name
            $newAudioName = time() . '-' . $data->name . '.' . $request['audio']->extension();
            // Where to store the image
            $path = 'game/Effects/BGM';
            // Store the image in public directory
            $request['audio']->move(public_path($path), $newAudioName);
            // Output would be like: game/Effects/BGM/image.png
            // So we can just do something like asset($foo['path']) than asset(game/Effects/BGM/$foo['path'])
            $data->path = $path . '/' . $newAudioName;
        }

        $data->updated_by = decrypt(Auth::user()->id);

        $data->save();

        return redirect()
            ->route('bgms.show', [
                'bgm' => $data->id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bgm)
    {
        $data = $this->findRecord($bgm);

        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($data->path)) {
            unlink($data->path);
        }

        $data->delete();

        return redirect()
            ->route('bgms.index')
            ->with('msg', 'Deleted Successfully');
    }
}
