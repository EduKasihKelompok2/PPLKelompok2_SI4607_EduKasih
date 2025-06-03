<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $scholarships = Scholarship::Filter($request->search)->orderBy('created_at', 'desc')->get();
        return view('admin.daftar-bantuan', compact('scholarships'));
    }

    public function show(Scholarship $scholarship)
    {
        $now = now();
        $isActive = $scholarship->registration_start <= $now && $scholarship->registration_end >= $now;

        return response()->json([
            'scholarship' => [
                'id' => $scholarship->id,
                'name' => $scholarship->name,
                'description' => $scholarship->description,
                'registration_start' => $scholarship->registration_start,
                'registration_end' => $scholarship->registration_end,
                'formatted_registration_start' => $scholarship->formatted_registration_start,
                'formatted_registration_end' => $scholarship->formatted_registration_end,
                'thumbnail' => $scholarship->thumbnail,
                'is_active' => $isActive,
                'created_at' => $scholarship->created_at->format('d F Y H:i'),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after_or_equal:registration_start',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'registration_start', 'registration_end', 'description']);

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('scholarships', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        Scholarship::create($data);

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Beasiswa berhasil ditambahkan!');
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after_or_equal:registration_start',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'registration_start', 'registration_end', 'description']);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($scholarship->thumbnail) {
                Storage::disk('public')->delete($scholarship->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('scholarships', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        $scholarship->update($data);

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Beasiswa berhasil diperbarui!');
    }

    public function destroy(Scholarship $scholarship)
    {
        // Delete thumbnail if exists
        if ($scholarship->thumbnail) {
            Storage::disk('public')->delete($scholarship->thumbnail);
        }

        $scholarship->delete();

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Beasiswa berhasil dihapus!');
    }
}
