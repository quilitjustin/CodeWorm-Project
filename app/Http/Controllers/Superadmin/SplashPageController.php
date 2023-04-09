<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SplashPage;
use Illuminate\Support\Facades\Auth;

class SplashPageController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = SplashPage::findorfail($id);
        return $data;
    }

    public function index()
    {
        $splash_pages = SplashPage::select('id', 'created_at', 'created_by')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('superadmin.splash_page.index', [
            'splashs' => $splash_pages,
        ]);
    }

    public function show(SplashPage $id)
    {
        // $content = SplashPage::select('content')->latest()->first();

        return view('superadmin.splash_page.show', [
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
            $splash->created_by = decrypt(Auth::user()->id);
            $splash->save();

            // Return a success response
            return response()->json(['message' => 'Saved successfully']);
        }
    }

    public function destroy($id)
    {
        $splash = $this->findRecord($id);
        $splash->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
