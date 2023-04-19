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
            ->where([
                // Don't show the current user because he can edit his details in his own settings
                ['id', '!=', decrypt(Auth::user()->id)],
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
        $data->created_by = decrypt(Auth::user()->id);
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
        $created_by = User::select('id', 'f_name', 'l_name')->where('id', $data->created_by);
        $updated_by = User::select('id', 'f_name', 'l_name')->where('id', $data->updated_by);
        $other = $created_by->unionAll($updated_by)->get();
 
        return view('superadmin.users.show', [
            'user' => $data,
            'other' => $other,
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
        $data->updated_by = decrypt(Auth::user()->id);
        $data->save();

        return redirect()
            ->route('users.show', [
                'user' => $user,
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
        $data->updated_by = decrypt(Auth::user()->id);
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
        $data = $this->findRecord($user);
        $data->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
