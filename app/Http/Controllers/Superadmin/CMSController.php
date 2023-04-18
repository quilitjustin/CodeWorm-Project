<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsBgim;
use Illuminate\Support\Facades\Auth;

class CMSController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = CmsBgim::findorfail($id);
        return $data;
    }

    public function create()
    {
        return view('superadmin.cms.background_image.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
        ]);

        $cmsleaderboard = new CmsBgim();
        $name = \Illuminate\Support\Str::random(5);

        // To avoid having a file with the same name
        $newImageName = time() . '-' . $name . '.' . $request['image']->extension();
        // Where to store the image
        $path = 'assets/bgim';
        // Check first if the directory exist, so we can create it first if there's none
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        // Store the image in public directory
        $request['image']->move(public_path($path), $newImageName);
        // Output would be like: assets/bgim/image.png
        // So we can just do something like asset($foo['path']) than asset(assets/bgim/$foo['path'])
        $cmsleaderboard->path = $path . '/' . $newImageName;
        $cmsleaderboard->created_by = decrypt(Auth::user()->id);
        $cmsleaderboard->save();

        return back()->with('msg', 'Created Successfully');
    }

    public function destroy($id)
    {
        $data = $this->findRecord($id);

        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($data->path)) {
            unlink($data->path);
        }

        $data->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function set_leaderboard_background(Request $request)
    {
        // To avoid having a file with the same name
        $image_name = 'leaderboard.png';
        // Where to store the image
        $path = 'assets/bgim/';

        // If there's an img set as leaderboard.png, delete it first
        if (file_exists($path . $image_name)) {
            unlink($path . $image_name);
        }

        // Create the copy
        copy($request['path'], $path . $image_name);
        // $cmsleaderboard->created_by = decrypt(Auth::user()->id);

        return response()->json(['message' => 'Saved successfully']);
    }

    public function set_play_background(Request $request)
    {
        // To avoid having a file with the same name
        $image_name = 'play.png';
        // Where to store the image
        $path = 'assets/bgim/';

        // If there's an img set as leaderboard.png, delete it first
        if (file_exists($path . $image_name)) {
            unlink($path . $image_name);
        }

        // Create the copy
        copy($request['path'], $path . $image_name);
        // $cmsleaderboard->created_by = decrypt(Auth::user()->id);

        return response()->json(['message' => 'Saved successfully']);
    }

    
    public function set_announcement_background(Request $request)
    {
        // To avoid having a file with the same name
        $image_name = 'announcement.png';
        // Where to store the image
        $path = 'assets/bgim/';

        // If there's an img set as leaderboard.png, delete it first
        if (file_exists($path . $image_name)) {
            unlink($path . $image_name);
        }

        // Create the copy
        copy($request['path'], $path . $image_name);
        // $cmsleaderboard->created_by = decrypt(Auth::user()->id);

        return response()->json(['message' => 'Saved successfully']);
    }

    public function leaderboard_index()
    {
        $cmdbgims = CmsBgim::all();

        return view('superadmin.cms.background_image.leaderboard.index', [
            'cmsbgims' => $cmdbgims,
        ]);
    }

    public function play_index()
    {
        $cmdbgims = CmsBgim::all();

        return view('superadmin.cms.background_image.play.index', [
            'cmsbgims' => $cmdbgims,
        ]);
    }

    public function announcement_index()
    {
        $cmdbgims = CmsBgim::all();

        return view('superadmin.cms.background_image.announcement.index', [
            'cmsbgims' => $cmdbgims,
        ]);
    }
}
