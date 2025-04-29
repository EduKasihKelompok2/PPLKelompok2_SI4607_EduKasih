<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProfileController extends Controller
{
    public function index()
    {
        return view('auth.edit-profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'nickname' => 'nullable|string|max:100',
                'gender' => 'nullable|string|in:MALE,FEMALE',
                'institution' => 'nullable|string|max:255',
                'nisn' => 'nullable|string|max:50',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'nullable|string|min:4|confirmed',
            ]);

            $user->name = $request->input('name');
            $user->nickname = $request->input('nickname');
            $user->gender = $request->input('gender');
            $user->institution = $request->input('institution');
            $user->nisn = $request->input('nisn');

            if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
                if ($user->photo && Storage::exists('public/profile_photos/' . $user->photo)) {
                    Storage::delete('public/profile_photos/' . $user->photo);
                }
                $photoName = time() . '_' . $user->id . '.' . $request->profile_photo->extension();
                $request->profile_photo->storeAs('public/profile_photos', $photoName);
                $user->photo = $photoName;
            }

            if ($request->filled('password')) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->save();

            return redirect()->route('profile')->with('success', 'Profile updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('profile')->with('error', 'Failed to update profile. ' . $e->getMessage());
        }
    }
}
