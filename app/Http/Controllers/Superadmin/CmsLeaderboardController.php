<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsLeaderboard;
use Illuminate\Support\Facades\Auth;

class CmsLeaderboardController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = CmsLeaderboard::findorfail($id);
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cmsleaderboards = CmsLeaderboard::all();

        return view('superadmin.cms.background_image.leaderboard.index', [
            'cmsleaderboards' => $cmsleaderboards,
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
            'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
        ]);

        $cmsleaderboard = new CmsLeaderboard();
        $name = \Illuminate\Support\Str::random(5);

        // To avoid having a file with the same name
        $newImageName = time() . '-' . $name . '.' . $request['image']->extension();
        // Where to store the image
        $path = 'assets/bgims/leaderboard';
        // Check first if the directory exist, so we can create it first if there's none
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        // Store the image in public directory
        $request['image']->move(public_path($path), $newImageName);
        // Output would be like: assets/bgims/leaderboard/image.png
        // So we can just do something like asset($foo['path']) than asset(assets/bgims/leaderboard/$foo['path'])
        $cmsleaderboard->path = $path . '/' . $newImageName;
        $cmsleaderboard->created_by = decrypt(Auth::user()->encrypted_id);
        $cmsleaderboard->save();

        return ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cmsleaderboard)
    {
        // This controller doesn't need show
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cmsleaderboard)
    {
        // This controller doesn't need edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cmsleaderboard)
    {
        // This controller doesn't need update
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cmsleaderboard)
    {
        $data = $this->findRecord($cmsleaderboard);

        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($data->path)) {
            unlink($data->path);
        }

        $data->delete();

        return redirect()
            ->route('cmsleaderboards.index')
            ->with('msg', 'Deleted Successfully');
    }
}
