<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{

    private $activity;
    public function __construct()
    {
        $this->activity = new Activity();
    }
    public function logout(Request $request)
    {
        $this->activity->saveActivity('Logout Akun');

        $request->session()->flush();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Auth::logout();
        $cookie = \Cookie::forget('remember_web');
        return redirect('/login');
    }
}
