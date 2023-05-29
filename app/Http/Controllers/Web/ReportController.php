<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //
    public function index()
    {
        return view('web.report');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'max:255'],
            // 'image' => ['required'],
            'image.*' => ['mimes:jpg,png,jpeg'],
        ]);
        $report = new Report();
        if($request['content'] != 'Something Else'){
            $report->content = $request['content'];
        } else {
            $report->content = $request['reason'];
        }
        
        $arr = [];
        if(isset($request['image'])){
            foreach ($request['image'] as $img) {
                // To avoid having a file with the same name
                $newImageName = time() . $img->extension();
                // Where to store the image
                $path = 'reports';
                // Store the image in public directory
                $img->move(public_path($path), $newImageName);
                // Change to path later
                array_push($arr, $path . '/' . $newImageName);
            }
        }
        if(isset($request['uid'])){
            $id = decrypt($request['uid']);
            $report->uid = $id;
        }
        $report->picture = json_encode($arr);
        $report->created_by = Auth::user()->id;
        $report->save();

        event(new \App\Events\Reports('Hello World'));

        return back()->with(['msg' => 'Report Submitted Successfully!']);
    }
}
