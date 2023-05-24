<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationAccepted;

class RequestRegistrationController extends Controller
{
    public function index()
    {
        $reqregs = RequestRegistration::whereHas('users', function ($query) {
            $query->whereNotNull('email_verified_at');
        })
            ->with('users:id,email')
            ->select('id', 'status', 'user_id')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        // $reqregs = RequestRegistration::all();
        return view('superadmin.request_registration.index', [
            'reqregs' => $reqregs,
        ]);
    }

    public function show($id)
    {
        $data = RequestRegistration::with('users:id,f_name,m_name,l_name,email')->findorfail($id);

        return view('superadmin.request_registration.show', [
            'reqreg' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'decision' => ['required', 'in:approved,deny,ban'],
        ]);
        $status = '';

        $data = RequestRegistration::findorfail($id);
        $user = User::select('id', 'l_name', 'email')->findorfail($data->user_id);
        if ($request['decision'] == 'approved') {
            $status = 'accepted';
            $data->status = $status;  
        }
        if ($request['decision'] == 'deny') {
            $status = 'denied';
            $data->status = $status;
        }
        Mail::to($user->email)->send(new RegistrationAccepted($user->l_name, $status));
        $data->save();

        return back()->with(['msg' => 'Updated Successfully']);
    }
}
