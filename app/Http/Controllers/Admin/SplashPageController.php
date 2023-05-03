<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SplashPage;
use Illuminate\Support\Facades\Auth;

class SplashPageController extends Controller
{
    public function index()
    {
        $splash_pages = SplashPage::with('created_by_user:id,f_name,l_name')->select('id', 'created_at', 'created_by')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.splash_page.index', [
            'splashs' => $splash_pages,
        ]);
    }

    public function show(SplashPage $id)
    {
        // $content = SplashPage::select('content')->latest()->first();

        return view('admin.splash_page.show', [
            'content' => $id,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'content' => ['required', 'json'],
            ]);

            $splash = new SplashPage();
            $splash->content = $request->content;
            $splash->created_by = Auth::user()->id;
            $splash->save();

            // Return a success response
            return response()->json(['message' => 'Saved successfully']);
        }
    }

    public function destroy(SplashPage $id)
    {
        $id->delete();

        return redirect()
            ->route('admin.splashs.index')
            ->with('msg', 'Deleted Successfully');
    }
}
