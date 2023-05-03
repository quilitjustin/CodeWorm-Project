<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    // Decrypt the id then find if it exist in db, if not: return 404, it yes: return the data
    protected function findRecord($id)
    {
        $id = decrypt($id);
        $data = User::findorfail($id);
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
        $users = User::select('id', 'f_name', 'l_name', 'status', 'role')
            ->where('role', 'user')
            ->get();

        return view('admin.users.index', [
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
        return view('admin.users.create');
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
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()
            ->route('admin.users.show', [
                'user' => $data->encrypted_id,
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
        $id = decrypt($user);
        if(Auth::user()->id == $id){
            return redirect()->route('admin.profile');
        }
        $data = User::with('created_by_user:id,f_name,l_name,role', 'updated_by_user:id,f_name,l_name,role')->findorfail($id);
        
        return view('admin.users.show', [
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

        return view('admin.users.edit', [
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
        $request = $request->validated();

        $data = $this->findRecord($user);

        if ($request['action'] == 'picture') {
            // Make sure you delete the file first before deleting the record in db
            // But before that, you need to make sure that the file still exist in the first place
            if (!is_null($data->profile_picture) && file_exists($data->profile_picture)) {
                unlink($data->profile_picture);
            }
            // To avoid having a file with the same name
            $newImageName = time() . '-' . $data->l_name . '.' . $request['image']->extension();
            // Where to store the image
            $path = 'profile';
            // Store the image in public directory
            $request['image']->move(public_path($path), $newImageName);
            // Output would be like: game/BackgroundImage/image.png
            // So we can just do something like asset($foo['path']) than asset(game/BackgroundImage/$foo['path'])
            $data->profile_picture = $path . '/' . $newImageName;
        }
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
        $data->updated_by = Auth::user()->id;
        $data->save();

        return redirect()
            ->route('admin.users.show', [
                'user' => $encrypted_id,
            ])
            ->with('msg', 'Updated Successfully');
    }

    // Ban or unban user
    public function ban_user(Request $request, $user)
    {
        $request->validate([
            'duration' => ['required', 'in:hour,day,week,month,year,forever'],
        ]);

        $data = $this->findRecord($user);
        $data->status = 'banned';
        $carbon = new \Carbon\Carbon();
        switch ($request['duration']) {
            case 'hour':
                $data->banned_until = $carbon::now()->addHour();
                break;
            case 'day':
                $data->banned_until = $carbon::now()->addDay();
                break;
            case 'week':
                $data->banned_until = $carbon::now()->addWeek();
                break;
            case 'month':
                $data->banned_until = $carbon::now()->addMonth();
                break;
            case 'year':
                $data->banned_until = $carbon::now()->addYear();
                break;
            case 'forever':
                $data->banned_until = $carbon::now()->addYears(1000);
                break;
            default:
                $data->banned_until = null;
                break;
        }
        $data->updated_by = Auth::user()->id;
        $data->save();

        return response()->json(['message' => 'Banned successfully']);
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
        // $data = $this->findRecord($user);
        $id = decrypt($user);
        if($id == 1){
            return 403;
        }
        $data = User::findorfail($id);
        $data->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('msg', 'Deleted Successfully');
    }
}
