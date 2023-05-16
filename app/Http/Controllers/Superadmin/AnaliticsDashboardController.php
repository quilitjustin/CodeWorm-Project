<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RequestRegistration;

class AnaliticsDashboardController extends Controller
{
    //
    public function index()
    {
        $data = User::all()->count();

        return response()->json($data);
    }

    public function user_reg_count()
    {
        $count = RequestRegistration::whereHas('users', function ($query) {
            $query->whereNotNull('email_verified_at');
        })->count();

        return response()->json(['count' => $count]);
    }
}
