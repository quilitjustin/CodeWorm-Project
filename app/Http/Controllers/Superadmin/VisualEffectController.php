<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisualEffect;
use Illuminate\Support\Facades\Auth;

class VisualEffectController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = VisualEffect::findorfail($id);
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
        $vfxs = VisualEffect::select('id', 'name')->get();

        return view('superadmin.game.effects.vfx.index', [
            'vfxs' => $vfxs,
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
        return view('superadmin.game.effects.vfx.create');
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

        $vfx = new VisualEffect();
        $vfx->name = $this->capitalize($request['name']);

        // To avoid having a file with the same name
        $newImageName = time() . '-' . $vfx['name'] . '.' . $request['image']->extension();
        // Where to store the image
        $path = 'game/Effects/VisualEffects';
        // Store the image in public directory
        $request['image']->move(public_path($path), $newImageName);
        // Output would be like: game/Effects/VisualEffects/image.png
        // So we can just do something like asset($foo['path']) than asset(game/Effects/VisualEffects/$foo['path'])
        $vfx->path = $path . '/' . $newImageName;
        $vfx->created_by = decrypt(Auth::user()->encrypted_id);
        $vfx->save();

        return redirect()
            ->route('vfxs.show', [
                'vfx' => $vfx->encrypted_id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($vfx)
    {
        //
        $data = $this->findRecord($vfx);

        return view('superadmin.game.effects.vfx.show', [
            'vfx' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($vfx)
    {
        //
        $vfx = $this->findRecord($vfx);

        return view('superadmin.game.effects.vfx.edit', [
            'vfx' => $vfx,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vfx)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'action' => ['required', 'in:true,false'],
        ]);

        $vfx = $this->findRecord($vfx);

        $rule = strip_tags($request['action']);

        $vfx->name = $this->capitalize($request->name);

        // For more clarity I use == 'true'
        if ($rule == 'true') {
            $request->validate([
                'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
            ]);
            // Make sure you delete the file first before updating the record in db
            // But before that, you need to make sure that the file still exist in the first place
            if (file_exists($vfx['path'])) {
                $foo = unlink($vfx['path']);
            }
            // To avoid having a file with the same name
            $newImageName = time() . '-' . $vfx['name'] . '.' . $request['image']->extension();
            // Where to store the image
            $path = 'game/Effects/VisualEffects';
            // Store the image in public directory
            $request['image']->move(public_path($path), $newImageName);
            // Output would be like: game/Effects/VisualEffects/image.png
            // So we can just do something like asset($foo['path']) than asset(game/Effects/VisualEffects/$foo['path'])
            $vfx->path = $path . '/' . $newImageName;
        }

        $vfx->updated_by = decrypt(Auth::user()->encrypted_id);

        $vfx->save();

        return redirect()
            ->route('vfxs.show', [
                'vfx' => $vfx->encrypted_id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vfx)
    {
        $vfx = $this->findRecord($vfx);
        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($vfx['path'])) {
            unlink($vfx['path']);
        }

        $vfx->delete();

        return redirect()
            ->route('vfxs.index')
            ->with('msg', 'Deleted Successfully');
    }
}
