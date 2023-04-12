<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiries;
use Illuminate\Support\Facades\Auth;

class InquiriesController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = Inquiries::findorfail($id);
        return $data;
    }

    public function index()
    {
        $inquiries = Inquiries::select('id', 'name', 'status', 'created_at')->get();

        return view('superadmin.inquiries.index', [
            'inquiries' => $inquiries,
        ]);
    }

    public function show($inquiries)
    {
        $data = $this->findRecord($inquiries);

        return view('superadmin.inquiries.show', [
            'inquiries' => $data,
        ]);
    }
}
