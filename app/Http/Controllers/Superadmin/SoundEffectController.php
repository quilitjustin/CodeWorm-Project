<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SoundEffect;
use Illuminate\Support\Facades\Auth;

class SoundEffectController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = SoundEffect::findorfail($id);
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
        $sfxs = SoundEffect::select('id', 'name')->get();

        return view('superadmin.game.effects.sfx.index', [
            'sfxs' => $sfxs,
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
        return view('superadmin.game.effects.sfx.create');
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

        $sfx = new SoundEffect();
        $sfx->name = $this->capitalize($request['name']);

        // To avoid having a file with the same name
        $newAudioName = time() . '-' . $sfx->name . '.' . $request['audio']->extension();
        // Where to store the image
        $path = 'game/Effects/SoundEffects';
        // Store the image in public directory
        $request['audio']->move(public_path($path), $newAudioName);
        // Output would be like: game/Effects/SoundEffects/image.png
        // So we can just do something like asset($foo['path']) than asset(game/Effects/SoundEffects/$foo['path'])
        $sfx->path = $path . '/' . $newAudioName;
        $sfx->created_by = Auth::user()->id;
        $sfx->save();

        return redirect()
            ->route('super.sfxs.show', [
                'sfx' => $sfx->encrypted_id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sfx)
    {
        $id = decrypt($sfx);
        $data = SoundEffect::with('created_by_user:id,f_name,l_name', 'updated_by_user:id,f_name,l_name')->findorfail($id);

        return view('superadmin.game.effects.sfx.show', [
            'sfx' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($sfx)
    {
        $data = $this->findRecord($sfx);

        return view('superadmin.game.effects.sfx.edit', [
            'sfx' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sfx)
    {
        //
        $request->validate([
            'name' => ['required', 'max:255'],
            'action' => ['required', 'in:true,false'],
        ]);
        $data = $this->findRecord($sfx);

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
            $path = 'game/Effects/SoundEffects';
            // Store the image in public directory
            $request['audio']->move(public_path($path), $newAudioName);
            // Output would be like: game/Effects/SoundEffects/image.png
            // So we can just do something like asset($foo['path']) than asset(game/Effects/SoundEffects/$foo['path'])
            $data->path = $path . '/' . $newAudioName;
        }

        $data->updated_by = Auth::user()->id;

        $data->save();

        return redirect()
            ->route('super.sfxs.show', [
                'sfx' => $data->encrypted_id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sfx)
    {
        $data = $this->findRecord($sfx);

        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($data->path)) {
            unlink($data->path);
        }

        $data->delete();

        return redirect()
            ->route('super.sfxs.index')
            ->with('msg', 'Deleted Successfully');
    }
}
