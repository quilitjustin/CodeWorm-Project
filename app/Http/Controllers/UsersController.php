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
        $users = User::select('id', 'f_name', 'l_name', 'role')
        ->where([
            // Don't show the current user because he can edit his details in his own settings 
            ['id', '!=', Auth::user()->id],
            // Don't get the superadmin
            // ['role', '!=', 'superadmin'],
        ])
        ->get();
        // Encrypt the ids
        // $users = $users->map(function ($user) {
        //     try {
        //         $encryptedId = encrypt($user->id);
        //         $user->encrypted_id = $encryptedId;
        //     } catch (EncryptException $e) {
        //         $user->encrypted_id = null;
        //     }
        //     return $user;
        // });
       
        // dd($users[0]->encrypted_id);
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
            'user' => encrypt($user->id)
        ])->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $uid = decrypt($user);
        $user = User::findorfail($uid);
        $encrypted_id = encrypt($user->id);

        //
        return view('superadmin.users.show', [
            'id' => $encrypted_id,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        //
        $uid = decrypt($user);
        $user = User::findorfail($uid);
        $encrypted_id = encrypt($user->id);

        return view('superadmin.users.edit', [
            'id' => $encrypted_id,
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
    public function update(UpdateUserRequest $request, $user)
    {
        //
        $uid = decrypt($user);
        $user = User::findorfail($uid);
        
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
        $encrypted_id = encrypt($user->id);

        return redirect()->route('users.show', [
            'user' => $encrypted_id
        ])->with('msg', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        //
        $uid = decrypt($user);
        $user = User::findorfail($uid);
        $user->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
