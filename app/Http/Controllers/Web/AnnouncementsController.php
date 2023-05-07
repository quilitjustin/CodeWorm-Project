<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcements;

class AnnouncementsController extends Controller
{
    //
    public function index()
    {
        $announcements = Announcements::with('created_by_user:id,f_name,l_name')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        $pinned = $announcements->where('is_pinned', true);
        $data = $announcements->where('is_pinned', false);

        return view('web.announcements', [
            'announcements' => $data,
            'pinned' => $pinned
        ]);
    }
}
