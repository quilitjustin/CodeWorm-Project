<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('superadmin.register');
    }

    protected function capitalize($data){
        return ucwords(strtolower($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        //
        $data = $request->validated();

        $user = new User;
        $user->f_name = $this->capitalize($data['f-name']);
        $user->l_name = $this->capitalize($data['l-name']);
        $user->m_name = $this->capitalize($data['m-name']);
        // $user->gender = $this->capitalize($data['gender']);
        $user->email = $data['email'];
        // $user->contact_no = $data['contact-no'];
        $user->password = Hash::make($data['password']);
        $user->save();
        dd($user);
        // return redirect()->route('admin.users.show', [
        //     'user' => $user->id
        // ])->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return view('superadmin.update_user', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        return view('superadmin.update_user', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
        $data = $request->validated();
        
        if($data['action'] == 'password'){
            $user->password = Hash::make($data['password']);
        }
        if($data['action'] == 'details'){
            $user->f_name = $this->capitalize($data['f-name']);
            $user->l_name = $this->capitalize($data['l-name']);
            $user->m_name = $this->capitalize($data['m-name']);
            $user->email = $data['email'];
        }
        
        $user->save();

        dd($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
