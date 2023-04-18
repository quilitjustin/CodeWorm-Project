<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsBgim;
use App\Models\CmsLogo;
use Illuminate\Support\Facades\Auth;

class CMSController extends Controller
{
    public function create()
    {
        return view('superadmin.cms.background_image.create');
    }

    public function create_logo()
    {
        return view('superadmin.cms.logo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
        ]);

        $data = new CmsBgim();
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
        $data->path = $path . '/' . $newImageName;
        $data->created_by = decrypt(Auth::user()->id);
        $data->save();

        return back()->with('msg', 'Created Successfully');
    }

    public function store_logo(Request $request)
    {
        $request->validate([
            'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
        ]);

        $data = new CmsLogo();
        $name = \Illuminate\Support\Str::random(5);

        // To avoid having a file with the same name
        $newImageName = time() . '-' . $name . '.' . $request['image']->extension();
        // Where to store the image
        $path = 'assets/logo';
        // Check first if the directory exist, so we can create it first if there's none
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        // Store the image in public directory
        $request['image']->move(public_path($path), $newImageName);
        // Output would be like: assets/bgim/image.png
        // So we can just do something like asset($foo['path']) than asset(assets/bgim/$foo['path'])
        $data->path = $path . '/' . $newImageName;
        $data->created_by = decrypt(Auth::user()->id);
        $data->save();

        return back()->with('msg', 'Created Successfully');
    }

    public function destroy($id)
    {
        $data = decrypt($id);
        $data = CmsBgim::findorfail();

        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($data->path)) {
            unlink($data->path);
        }

        $data->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function destroy_logo($id)
    {
        $data = decrypt($id);
        $data = CmsLogo::findorfail();

        // Make sure you delete the file first before deleting the record in db
        // But before that, you need to make sure that the file still exist in the first place
        if (file_exists($data->path)) {
            unlink($data->path);
        }

        $data->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    protected $file_name = '';
    protected $file_path = '';

    protected function copy_file($path)
    {
        // If there's an img set as leaderboard.png, delete it first
        if (file_exists($this->file_path . $this->file_name)) {
            unlink($this->file_path . $this->file_name);
        }

        // Create the copy
        copy($path, $this->file_path . $this->file_name);
    }

    public function set_leaderboard_background(Request $request)
    {
        // To avoid having a file with the same name
        $this->file_name = 'leaderboard.png';
        // Where to store the image
        $this->file_path = 'assets/bgim/';

        $this->copy_file($request['path']);
        // $data->created_by = decrypt(Auth::user()->id);

        return response()->json(['message' => 'Saved successfully']);
    }

    public function set_play_background(Request $request)
    {
        // To avoid having a file with the same name
        $this->file_name = 'play.png';
        // Where to store the image
        $this->file_path = 'assets/bgim/';

        $this->copy_file($request['path']);

        // $data->created_by = decrypt(Auth::user()->id);

        return response()->json(['message' => 'Saved successfully']);
    }

    public function set_announcement_background(Request $request)
    {
        // To avoid having a file with the same name
        $this->file_name = 'announcement.png';
        // Where to store the image
        $this->file_path = 'assets/bgim/';

        $this->copy_file($request['path']);
        // $data->created_by = decrypt(Auth::user()->id);

        return response()->json(['message' => 'Saved successfully']);
    }

    public function set_stalk_background(Request $request)
    {
        // To avoid having a file with the same name
        $this->file_name = 'stalk.png';
        // Where to store the image
        $this->file_path = 'assets/bgim/';

        $this->copy_file($request['path']);
        // $data->created_by = decrypt(Auth::user()->id);

        return response()->json(['message' => 'Saved successfully']);
    }

    public function set_splash_background(Request $request)
    {
        // To avoid having a file with the same name
        $this->file_name = 'splash.png';
        // Where to store the image
        $this->file_path = 'assets/bgim/';

        $this->copy_file($request['path']);
        // $data->created_by = decrypt(Auth::user()->id);

        return response()->json(['message' => 'Saved successfully']);
    }

    public function set_login_background(Request $request)
    {
        // To avoid having a file with the same name
        $this->file_name = 'login.png';
        // Where to store the image
        $this->file_path = 'assets/bgim/';

        $this->copy_file($request['path']);
        // $data->created_by = decrypt(Auth::user()->id);

        return response()->json(['message' => 'Saved successfully']);
    }

    public function set_logo(Request $request)
    {
        // To avoid having a file with the same name
        $this->file_name = 'logo.png';
        // Where to store the image
        $this->file_path = 'assets/logo/';

        $this->copy_file($request['path']);
        // $data->created_by = decrypt(Auth::user()->id);

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

    public function stalk_index()
    {
        $cmdbgims = CmsBgim::all();

        return view('superadmin.cms.background_image.stalk.index', [
            'cmsbgims' => $cmdbgims,
        ]);
    }

    public function splash_index()
    {
        $cmdbgims = CmsBgim::all();

        return view('superadmin.cms.background_image.splash.index', [
            'cmsbgims' => $cmdbgims,
        ]);
    }

    public function login_index()
    {
        $cmdbgims = CmsBgim::all();

        return view('superadmin.cms.background_image.login.index', [
            'cmsbgims' => $cmdbgims,
        ]);
    }

    public function logo_index()
    {
        $cmdbgims = CmsLogo::all();

        return view('superadmin.cms.logo.index', [
            'cmsbgims' => $cmdbgims,
        ]);
    }
}
