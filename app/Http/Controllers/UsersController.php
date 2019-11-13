<?php

namespace App\Http\Controllers;

use App\User;
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
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $edit = '<a href="#" class="edit" id="' . $data->id . '" data-toggle="modal" data-target="#usersForm"><i class="fa fa-edit"></i></a>';
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
     * Validates the data
     *
     * @param null
     * @return \Illuminate\Http\Response
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
