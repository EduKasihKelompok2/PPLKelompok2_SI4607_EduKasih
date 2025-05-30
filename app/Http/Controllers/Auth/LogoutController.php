<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Auth::logout();
        $cookie = \Cookie::forget('remember_web');
        return redirect('/login');
    }
}
