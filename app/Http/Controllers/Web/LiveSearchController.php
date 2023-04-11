<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class LiveSearchController extends Controller
{
    //
    public function public_portfolio(Request $request)
    {
        if ($request->ajax()) {
            $keyword = strip_tags($request['keyword']);
            $data = User::select('id', DB::raw("CONCAT(users.f_name,' ',users.l_name) as name"))
                ->where('f_name', 'LIKE', "%$keyword%")
                ->orwhere('m_name', 'LIKE', "%$keyword%")
                ->orwhere('l_name', 'LIKE', "%$keyword%")
                // ->limit(5)
                ->get();
                
            return response()->json($data);
        }
    }
}
