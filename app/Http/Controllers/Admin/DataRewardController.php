<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataRewardsController extends Controller
{
    public function index(Request $request)
    {
        $rewards = Reward::orderby('created_at', 'desc')
            ->Filter($request->search)
            ->paginate(10);

        $badges = Badge::orderby('created_at', 'desc')
            ->get();
        return view('admin.rewards', compact('rewards', 'badges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,txt|max:2048',
            'badge_id' => 'required|exists:badge,id'
        ]);

        $data = $request->only(['name', 'description', 'badge_id']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['file_path'] = $file->storeAs('rewards', $filename, 'public');
        }

        Reward::create($data);

        return redirect()->route('admin.rewards')->with('success', 'Reward created successfully!');
    }

    public function update(Request $request, Reward $reward)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:2048',
            'badge_id' => 'required|exists:badge,id'
        ]);

        $data = $request->only(['name', 'description', 'badge_id']);

        if ($request->hasFile('file')) {
          
            if ($reward->file_path) {
                Storage::disk('public')->delete($reward->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['file_path'] = $file->storeAs('rewards', $filename, 'public');
        }

        $reward->update($data);

        return redirect()->route('admin.rewards')->with('success', 'Reward updated successfully!');
    }

    public function destroy(Reward $reward)
    {
        
        if ($reward->file_path) {
            Storage::disk('public')->delete($reward->file_path);
        }

        $reward->delete();

        return redirect()->route('admin.rewards')->with('success', 'Reward deleted successfully!');
    }
}