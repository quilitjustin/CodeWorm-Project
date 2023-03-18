<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BGImg;
use Illuminate\Support\Facades\Auth;

class BGImgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bgims = BGImg::paginate(7);

        return view('superadmin.game.background_image.index', [
            'bgims' => $bgims,
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
        return view('superadmin.game.background_image.create');
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
            'name' => ['required', 'max:255'],
            'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
        ]);

        $bgim = new BGImg();
        $bgim->name = $this->capitalize($request['name']);

        // To avoid having a file with the same name
        $newImageName = time() . '-' . $bgim['name'] . '.' . $request['image']->extension();
        // Where to store the image
        $path = 'game/BackgroundImage';
        // Store the image in public directory
        $request['image']->move(public_path($path), $newImageName);
        // Output would be like: game/BackgroundImage/image.png
        // So we can just do something like asset($foo['path']) than asset(game/BackgroundImage/$foo['path'])
        $bgim->path = $path . '/' . $newImageName;
        $bgim->created_by = Auth::user()->id;
        $bgim->save();

        return redirect()
            ->route('bgims.show', [
                'bgim' => $bgim->id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BGImg $bgim)
    {
        //
        return view('superadmin.game.background_image.show', [
            'bgim' => $bgim,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BGImg $bgim)
    {
        //
        return view('superadmin.game.background_image.edit', [
            'bgim' => $bgim,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BGImg $bgim)
    {
        //
        $request->validate([
            'name' => ['required', 'max:255'],
            'action' => ['required', 'in:true,false'],
        ]);

        $rule = strip_tags($request['action']);

        $bgim->name = $this->capitalize($request->name);

        // For more clarity I use == 'true'
        if ($rule == 'true') {
            $request->validate([
                'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
            ]);
            // Make sure you delete the file first before updating the record in db
            // But before that, you need to make sure that the file still exist in the first place
            if (file_exists($bgim['path'])) {
                $foo = unlink($bgim['path']);
            }
            // To avoid having a file with the same name
            $newImageName = time() . '-' . $bgim['name'] . '.' . $request['image']->extension();
            // Where to store the image
            $path = 'game/BackgroundImage';
            // Store the image in public directory
            $request['image']->move(public_path($path), $newImageName);
            // Output would be like: game/BackgroundImage/image.png
            // So we can just do something like asset($foo['path']) than asset(game/BackgroundImage/$foo['path'])
            $bgim->path = $path . '/' . $newImageName;
        }

        $bgim->updated_by = Auth::user()->id;

        $bgim->save();

        return redirect()
            ->route('bgims.show', [
                'bgim' => $bgim->id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BGImg $bgim)
    {
        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($bgim['path'])) {
            $foo = unlink($bgim['path']);
        }

        $bgim->delete();

        return redirect()
            ->route('bgims.index')
            ->with('msg', 'Deleted Successfully');
    }
}
