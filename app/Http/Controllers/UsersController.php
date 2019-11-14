<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('d.m.Y h:m:s') : '';
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#editUsersForm"><i class="fa fa-edit"></i></a>';
                    return $edit;
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
        $user = User::findOrFail($request->id);
        $output = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'active' => $user->active
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
            'password1' => 'sometimes',
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
