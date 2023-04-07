<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    // Decrypt the id of current user so we know who create and update the record
    protected $cr_user;

    public function __construct()
    {
        // $this->cr_user = decrypt(Auth::user()->id);
    }

    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($data)
    {
        $data = $this->findRecord($user);
        return $data;
    }

    protected function capitalize($data)
    {
        return ucwords(strtolower($data));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::select('id', 'f_name', 'l_name', 'role')
            ->where([
                // Don't show the current user because he can edit his details in his own settings
                ['id', '!=', $this->cr_user],
                // Don't get the superadmin
                // This user should be the only superadmin so there is no need for this statement
                // Actually this is better since we can also see if there would be another superadmin that shouldn't exist (backdoor for example)
                // ['role', '!=', 'superadmin'],
            ])
            ->get();

        return view('superadmin.users.index', [
            'users' => $users,
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
        return view('superadmin.users.create');
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
        $request = $request->validated();

        $data = new User();
        $data->f_name = $this->capitalize($request['f-name']);
        $data->l_name = $this->capitalize($request['l-name']);
        $data->m_name = $this->capitalize($request['m-name']);
        $data->role = $request['role'];
        // $user->gender = $this->capitalize($data['gender']);
        $data->email = $request['email'];
        // $user->contact_no = $data['contact-no'];
        $data->password = Hash::make($request['password']);
        $data->created_by = $this->cr_user;
        $data->save();

        return redirect()
            ->route('users.show', [
                'user' => $data->id,
            ])
            ->with('msg', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $data = $this->findRecord($user);
        //
        return view('superadmin.users.show', [
            'user' => $data,
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
        $data = $this->findRecord($user);

        return view('superadmin.users.edit', [
            'user' => $data,
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
        $data = $this->findRecord($user);

        $request = $request->validated();

        if ($request['action'] == 'password') {
            $data->password = Hash::make($request['password']);
        }
        if ($request['action'] == 'details') {
            $data->f_name = $this->capitalize($request['f-name']);
            $data->l_name = $this->capitalize($request['l-name']);
            $data->m_name = $this->capitalize($request['m-name']);
            $data->email = $request['email'];
            $data->role = $request['role'];
        }
        $data->updated_by = $this->cr_user;
        $data->save();

        return redirect()
            ->route('users.show', [
                'user' => $user,
            ])
            ->with('msg', 'Updated Successfully');
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
        $data = $this->findRecord($user);
        $user->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
