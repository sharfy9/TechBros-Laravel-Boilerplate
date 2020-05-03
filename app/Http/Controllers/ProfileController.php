<?php

namespace App\Http\Controllers;

use Auth;
use Gate;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        if(\Auth::user()->cannot("profile.change.info"))
            abort(403);

        $user = Auth::user();
        $request->validate([
            'email' => 'required|email|unique:users,id,'.$user->id.',email',
            'phone' => 'required|numeric|digits:11|unique:users,id,'.$user->id.',phone',
        ]);

        $user->update($request->all());

        return back()->with(["successMsg" => __('Profile successfully updated.')]);
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        if(\Auth::user()->cannot("profile.change.password"))
            abort(403);

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->with(["successMsg" => __('Profile successfully updated.')]);
    }
}
