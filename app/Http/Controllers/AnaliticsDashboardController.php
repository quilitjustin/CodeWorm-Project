<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AnaliticsDashboardController extends Controller
{
    //
    public function index(){
        $data = User::all()->count();

        return response()->json($data);
    }
}
