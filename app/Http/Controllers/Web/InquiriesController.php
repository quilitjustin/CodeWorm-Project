<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiries;
use App\Http\Requests\InquiriesRequest;

class InquiriesController extends Controller
{
    public function store(InquiriesRequest $request){
        $request = $request->validated();

        $inquiry = new Inquiries;
        $inquiry->name = $request['name'];
        $inquiry->email = $request['email'];
        $inquiry->phone = $request['phone'];
        $inquiry->message = $request['message'];
        $inquiry->save();

        return response()->json(['message' => 'Saved successfully']);
    }
}
