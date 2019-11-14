<?php

namespace App\Http\Controllers;

use App\User;
use App\UserGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $role = UserGroup::where('user_id', 1)->first();
        // dd($role->class_id);
        if ($request->ajax()) {
            $users = DB::table('users')
            ->join('user_groups', 'users.id', '=', 'user_groups.user_id')
            ->join('user_classes', 'user_groups.class_id', '=', 'user_classes.id')
            ->select([
                'users.id as id',
                'users.name as name',
                'users.email as email',
                'users.active as active',
                'users.created_at as created_at',
                'user_classes.class as role',
                'user_groups.id as role_id'
            ])
            ->get();
            return DataTables::of($users)
                ->editColumn('created_at', function ($users) {
                    return $users->created_at ? with(new Carbon($users->created_at))->format('d.m.Y h:m:s') : '';
                })
                ->addIndexColumn()
                ->addColumn('action', function ($users) {

                    $edit = '<a href="#" class="edit" id="' . $users->id . '" data-toggle="modal" data-target="#editUsersForm"><i class="fa fa-edit"></i></a>';
                    $role = '<a href="#" class="role-form" id="' . $users->id . '" data-toggle="modal" data-target="#changeRoleForm"><i class="fa fa-arrow-up"></i></a>';
                    return $edit . " " . $role;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('users.index');
    }

    /**
     * Checks for errors and stores the user into the database
     *
     * @param null
     * @return redirect
     */
    public function store(User $user, Request $request)
    {
        $data = $this->validateRequest();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password1']);
        $user->save();
        return back();
    }

    /**
     * Fetch the user details via ajax request
     *
     * @param \Illuminate\Http\Request  $request
     * @return json
     */
    public function fetchUser(Request $request)
    {
        $user = DB::table('users')
            ->join('user_groups', 'users.id', '=', 'user_groups.user_id')
            ->select([
                'users.id as id',
                'users.name as name',
                'users.email as email',
                'users.active as active',
                'users.created_at as created_at',
                'user_groups.class_id as role',
                'user_groups.id as role_id'
            ])
            ->where('users.id', $request->id)->get();
        // $user = User::findOrFail($request->id);
        $output = [
            'id' => $user[0]->id,
            'name' => $user[0]->name,
            'email' => $user[0]->email,
            'active' => $user[0]->active,
            'role' => $user[0]->role,
            'role_id' => $user[0]->role_id
        ];

        return json_encode($output);
    }

    /**
     * Update the data of the selected user
     *
     * @param \App\User $user
     * @return redirect
     */
    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'active' => 'required',
            'password1' => 'sometimes'
        ]);

        if(!$data['password1']) {
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->active = $data['active'];
            $user->update();            
        } else {
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->active = $data['active'];
            $user->password = bcrypt($data['password1']);
            $user->update();
        }

        return redirect('/users');
    }

    /**
     * Change the class of the selected user
     *
     * @param \App\UserGroup $userGroup
     * @return redirect
     */
    public function changeRole(UserGroup $userGroup, Request $request)
    {
        // dd($userGroup);
        $userGroup->class_id = $request->role;
        $userGroup->update();
        return back();
    }

    /**
     * Validates the data
     *
     * @param null
     * @return array
     */
    public function validateRequest()
    {
        $error_messages = [
            'name.required' => 'Completati numele!',
            'email.required' => 'Completati adresa de email!',
            'password1.required' => 'Parola este necesara!',
        ];
        return request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password1' => 'required',
        ], $error_messages);
    }
}
