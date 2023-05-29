<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportResponse;

class ReportController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = Report::findorfail($id);
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::with('created_by_user:id,f_name,l_name')->select('id', 'created_by', 'created_at')->where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return view('superadmin.reports.index', [
            'reports' => $reports
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = decrypt($id);
        $data = Report::with('created_by_user:id,f_name,l_name')->findOrFail($id);

        if(!is_null($data->uid)){
            $user = \App\Models\User::select('id', 'f_name', 'l_name')->first();
        }
        return view('superadmin.reports.show', [
            'report' => $data,
            'user' => $user,
        ]);
    }

    public function respond(Request $request, $id){
        $data = $this->findRecord($id);
        $data->status = 'done';
        $data->save();

        $user = \App\Models\User::select('id', 'l_name', 'email')->where('id', decrypt($request['reporter_id']))->first();

        Mail::to($user->email)->send(new ReportResponse($user->f_name, $request['response']));

        return redirect()->route('super.reports.index')->with(['msg' => 'Responded Successfully']);
    }
}
