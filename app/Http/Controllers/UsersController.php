<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

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
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $users = User::where([
            // Don't show the current user because he can edit his details in his own settings 
            ['id', '!=', Auth::user()->id],
            // Don't get the superadmin
            // ['role', '!=', 'superadmin'],
        ])->paginate(7);

        return view('superadmin.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(!Auth::check()){
            return redirect()->route('login');
        }
        return view('superadmin.users.create');
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
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $data = $request->validated();

        $user = new User;
        $user->f_name = $this->capitalize($data['f-name']);
        $user->l_name = $this->capitalize($data['l-name']);
        $user->m_name = $this->capitalize($data['m-name']);
        $user->role = $data['role'];
        // $user->gender = $this->capitalize($data['gender']);
        $user->email = $data['email'];
        // $user->contact_no = $data['contact-no'];
        $user->password = Hash::make($data['password']);
        $user->created_by = Auth::user()->id;
        $user->updated_by = Auth::user()->id;
        $user->save();

        return redirect()->route('users.show', [
            'user' => $user->id
        ])->with('msg', 'Created Successfully');
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
        if(!Auth::check()){
            return redirect()->route('login');
        }
        return view('superadmin.users.show', [
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
        if(!Auth::check()){
            return redirect()->route('login');
        }
        return view('superadmin.users.edit', [
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
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $data = $request->validated();
        
        if($data['action'] == 'password'){
            $user->password = Hash::make($data['password']);
        }
        if($data['action'] == 'details'){
            $user->f_name = $this->capitalize($data['f-name']);
            $user->l_name = $this->capitalize($data['l-name']);
            $user->m_name = $this->capitalize($data['m-name']);
            $user->email = $data['email'];
            $user->role = $data['role'];
        }
        $user->updated_by = Auth::user()->id;
        $user->save();

        return redirect()->route('users.show', [
            'user' => $user->id
        ])->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $user->delete();
        
        return redirect()->route('users.index')->with('msg', 'Deleted Successfully');
    }
}
