<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoundEffect;
use Illuminate\Support\Facades\Auth;

class SoundEffectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sfxs = SoundEffect::paginate(7);

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

    protected function capitalize($data)
    {
        // Because we are not using request this time
        // I will strip tags here instead
        $data = strip_tags($data);
        return ucwords(strtolower($data));
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
            'name' => ['required'],
            'audio' => ['required', 'mimes:application/audio/mpeg,mpga,mp3,wav'],
        ]);

        $sfx = new SoundEffect();
        $sfx->name = $this->capitalize($request['name']);

        // To avoid having a file with the same name
        $newAudioName = time() . '-' . $sfx['name'] . '.' . $request['audio']->extension();
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
            ->route('sfxs.show', [
                'sfx' => $sfx->id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SoundEffect $sfx)
    {
        //
        return view('superadmin.game.effects.sfx.show', [
            'sfx' => $sfx,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SoundEffect $sfx)
    {
        //
        return view('superadmin.game.effects.sfx.edit', [
            'sfx' => $sfx,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoundEffect $sfx)
    {
        //
        $request->validate([
            'name' => ['required'],
            'action' => ['required', 'in:true,false'],
        ]);

        $rule = strip_tags($request['action']);

        $sfx->name = $this->capitalize($request->name);

        // For more clarity I use == 'true'
        if ($rule == 'true') {
            $request->validate([
                'audio' => ['required', 'mimes:application/audio/mpeg,mpga,mp3,wav'],
            ]);
            // Make sure you delete the file first before updating the record in db
            // But before that, you need to make sure that the file still exist in the first place
            if (file_exists($sfx['path'])) {
                $foo = unlink($sfx['path']);
            }
            // To avoid having a file with the same name
            $newAudioName = time() . '-' . $sfx['name'] . '.' . $request['audio']->extension();
            // Where to store the image
            $path = 'game/Effects/SoundEffects';
            // Store the image in public directory
            $request['audio']->move(public_path($path), $newAudioName);
            // Output would be like: game/Effects/SoundEffects/image.png
            // So we can just do something like asset($foo['path']) than asset(game/Effects/SoundEffects/$foo['path'])
            $sfx->path = $path . '/' . $newAudioName;
        }

        $sfx->updated_by = Auth::user()->id;

        $sfx->save();

        return redirect()
            ->route('sfxs.show', [
                'sfx' => $sfx->id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoundEffect $sfx)
    {
        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($sfx['path'])) {
            $foo = unlink($sfx['path']);
        }

        $sfx->delete();

        return redirect()
            ->route('sfxs.index')
            ->with('msg', 'Deleted Successfully');
    }
}
