<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        return view('profile.index', compact('user'));
    }

    /**
     * Change user display name
     *
     * @param \Illuminate\Http\Request  $request
     * @return back
     */
    public function changeName(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->name = $request->name;
        $user->update();
        return back();
    }

    /**
     * Change user password
     *
     * @param \Illuminate\Http\Request  $request
     * @return back
     */
    public function changePassword(Request $request)
    {
        if ($request->password1 !== $request->password2) {
            return back()->withErrors(['Parolele introduse nu sunt identice!']);
        }

        $user = User::findOrFail(auth()->user()->id);
        if (!Hash::check($request['old_password'], $user->password)) {
            return back()->withErrors(['Parola veche nu este corecta!']);
        } else {
            $user->password = bcrypt($request->password1);
            $user->update();
            return back();
        }
    }

    /**
     * Change user avatar
     *
     * @param \Illuminate\Http\Request  $request
     * @return back
     */
    public function changeAvatar(Request $request)
    {

        $request->validate([
            'avatar'  => 'required|mimes:jpeg,png',
        ]);

        $user = User::findOrFail(auth()->user()->id);

        $extension = "." . $request->avatar->getClientOriginalExtension();
        $filename = auth()->user()->id . $extension;
        $request->avatar->storeAs('profile_pictures', $filename, ['disk' => 'public']);
        $user->profile_picture = $filename;
        $user->update();
        return back();
    }
}
