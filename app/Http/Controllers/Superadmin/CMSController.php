<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CMSController extends Controller
{
    public function set_leaderboard_background(Request $request)
    {
        // To avoid having a file with the same name
        $image_name = 'leaderboard.png';
        // Where to store the image
        $path = 'assets/bgims/';

        // Check first if the directory exist, so we can create it first if there's none
        // if (!is_dir($path)) {
        //     mkdir($path, 0777, true);
        // }
        // Now check if file exist so we can delete the old file
     
        // Create the copy
        copy($request['path'], $path . $image_name);
        // $cmsleaderboard->created_by = decrypt(Auth::user()->id);

        return response()->json(['message' => 'Saved successfully']);
    }
}
