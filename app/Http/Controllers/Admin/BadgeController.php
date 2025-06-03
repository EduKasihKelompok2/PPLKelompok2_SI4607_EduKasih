<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = Badge::all();
        return view('admin.badge', compact('badges'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'requirement' => 'required|integer|min:1',
                'icon' => 'required|image|max:2048',
            ]);

            $iconPath = null;
            if ($request->hasFile('icon')) {
                // Store the file with a unique name
                $fileName = 'badge_' . Str::random(10) . '.' . $request->icon->extension();
                $iconPath = $request->file('icon')->storeAs('public/badges', $fileName);
                $iconPath = str_replace('public/', '', $iconPath);
            }

            Badge::create([
                'name' => $request->name,
                'requirement' => $request->requirement,
                'icon' => $iconPath,
            ]);

            return redirect()->route('admin.badges')->with('success', 'Badge created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.badges')->with('error', 'Failed to create badge: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'requirement' => 'required|integer|min:1',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $badge = Badge::findOrFail($id);

        $iconPath = $badge->icon;
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($badge->icon) {
                Storage::delete('public/' . $badge->icon);
            }

            // Store the new icon
            $fileName = 'badge_' . Str::random(10) . '.' . $request->icon->extension();
            $iconPath = $request->file('icon')->storeAs('public/badges', $fileName);
            $iconPath = str_replace('public/', '', $iconPath);
        }

        $badge->update([
            'name' => $request->name,
            'requirement' => $request->requirement,
            'icon' => $iconPath,
        ]);

        return redirect()->route('admin.badges')->with('success', 'Badge updated successfully.');
    }

    public function destroy($id)
    {
        $badge = Badge::findOrFail($id);

        // Delete icon file if exists
        if ($badge->icon) {
            Storage::delete('public/' . $badge->icon);
        }

        $badge->delete();

        return redirect()->route('admin.badges')->with('success', 'Badge deleted successfully.');
    }
}