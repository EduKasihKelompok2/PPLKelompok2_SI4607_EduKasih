<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    private $activity;
    public function __construct()
    {
        $this->activity = new Activity();
    }
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.home');
            }


            $this->activity->saveActivity('Login Akun');
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
