<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestRegistration;

class RequestRegistrationController extends Controller
{
    public function index(){
        $reqregs = RequestRegistration::all();

        return view('superadmin.request_registration.index', [
            'reqregs' => $reqregs
        ]);
    }
}
