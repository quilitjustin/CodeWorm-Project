<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisualEffect;
use Illuminate\Support\Facades\Auth;

class VisualEffectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vfxs = VisualEffect::paginate(7);

        return view('superadmin.effects.vfx.index', [
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
        return view('superadmin.effects.vfx.create');
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
            'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
        ]);

        $vfx = new VisualEffect();
        $vfx->name = $this->capitalize($request['name']);

        // To avoid having a file with the same name
        $newImageName = time() . '-' . $vfx['name'] . '.' . $request['image']->extension();
        // Where to store the image
        $path = 'game/BackgroundImage';
        // Store the image in public directory
        $request['image']->move(public_path($path), $newImageName);
        // Output would be like: game/BackgroundImage/image.png
        // So we can just do something like asset($foo['path']) than asset(game/BackgroundImage/$foo['path'])
        $vfx->path = $path . '/' . $newImageName;
        $vfx->created_by = Auth::user()->id;
        $vfx->save();

        return redirect()
            ->route('vfxs.show', [
                'vfx' => $vfx->id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VisualEffect $vfx)
    {
        //
        return view('superadmin.effects.vfx.show', [
            'vfx' => $vfx,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(VisualEffect $vfx)
    {
        //
        return view('superadmin.effects.vfx.edit', [
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
    public function update(Request $request, VisualEffect $vfx)
    {
        //
        $request->validate([
            'name' => ['required'],
            'action' => ['required', 'in:true,false'],
        ]);

        $rule = strip_tags($request['action']);

        $vfx->name = $this->capitalize($request->name);

        // For more clarity
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
            $path = 'game/BackgroundImage';
            // Store the image in public directory
            $request['image']->move(public_path($path), $newImageName);
            // Output would be like: game/BackgroundImage/image.png
            // So we can just do something like asset($foo['path']) than asset(game/BackgroundImage/$foo['path'])
            $vfx->path = $path . '/' . $newImageName;
        }

        $vfx->updated_by = Auth::user()->id;

        $vfx->save();

        return redirect()
            ->route('vfxs.show', [
                'vfx' => $vfx->id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VisualEffect $vfx)
    {
        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($vfx['path'])) {
            $foo = unlink($vfx['path']);
        }

        $vfx->delete();

        return redirect()
            ->route('vfxs.index')
            ->with('msg', 'Deleted Successfully');
    }
}
