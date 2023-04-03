<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcements;

class AnnouncementsController extends Controller
{
    //
    public function index(){
        $announcements = Announcements::paginate(7);

        return view('web.announcements', [
            'announcements' => $announcements,
        ]);
    }
}
