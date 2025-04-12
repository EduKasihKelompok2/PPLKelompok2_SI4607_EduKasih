<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'gender' => 'required|string|in:male,female',
            'dob' => 'required|date',
            'institution' => 'required|string|max:255',
            'password' => 'required|string|min:4|confirmed',
        ]);



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'institution' => $request->institution,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('user');

        Auth::login($user);

        return redirect()->route('home');
    }
}
