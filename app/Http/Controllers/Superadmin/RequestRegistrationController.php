<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestRegistration;
use App\Models\User;

class RequestRegistrationController extends Controller
{
    public function index()
    {
        $reqregs = RequestRegistration::with('users:id,email')
            ->select('id', 'status', 'user_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('superadmin.request_registration.index', [
            'reqregs' => $reqregs,
        ]);
    }

    public function show($id)
    {
        $data = RequestRegistration::with('users:id,f_name,l_name,email')->findorfail($id);

        return view('superadmin.request_registration.show', [
            'reqreg' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'decision' => ['required', 'in:approved,deny,ban'],
        ]);
        $data = RequestRegistration::findorfail($id);

        if ($request['decision'] == 'approved') {
            $data->status = 'accepted';
            $user = User::findorfail($data->user_id);

            $url = route('verification.verify', [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]);

            $user->sendEmailVerificationNotification($url);
        }
        if ($request['decision'] == 'deny') {
            $data->status = 'denied';
        }
        $data->save();

        return back()->with(['msg' => 'Updated Successfully']);
    }
}
