<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SplashPage;
use Illuminate\Support\Facades\Auth;

class SplashPageController extends Controller
{
    //
    public function index()
    {
        $splash_pages = SplashPage::paginate(7);
        $latest = SplashPage::select('id')->latest()->first();

        return view('superadmin.splash_page.index', [
            'splashs' => $splash_pages,
            'latest' => $latest
        ]);
    }

    public function show(SplashPage $id)
    {
        // $content = SplashPage::select('content')->latest()->first();

        return view('superadmin.splash_page.show', [
            'content' => $id
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
            ->route('users.index')
            ->with('msg', 'Deleted Successfully');
    }
}
