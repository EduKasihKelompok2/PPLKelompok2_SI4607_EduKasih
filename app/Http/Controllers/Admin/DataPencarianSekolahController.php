<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DataPencarianSekolahController extends Controller
{
    /**
     * Display a listing of the schools.
     */
    public function index(Request $request)
    {
        $schools = School::filter($request->search)
            ->latest()
            ->paginate(10);

        return view('admin.pencarian-sekolah.index', compact('schools'));
    }

    /**
     * Show the form for creating a new school.
     */
    public function create()
    {
        return view('admin.pencarian-sekolah.create');
    }

    /**
     * Store a newly created school in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'accreditation' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'founded_year' => 'required|integer',
            'status' => 'required|string|max:255',
            'students' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'description' => 'required|string',
            'address' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama perguruan tinggi wajib diisi',
            'type.required' => 'Jenis perguruan tinggi wajib diisi',
            'accreditation.required' => 'Akreditasi wajib diisi',
            'city.required' => 'Kota wajib diisi',
            'province.required' => 'Provinsi wajib diisi',
            'founded_year.required' => 'Tahun berdiri wajib diisi',
            'founded_year.integer' => 'Tahun berdiri harus berupa angka',
            'status.required' => 'Status wajib diisi',
            'students.required' => 'Jumlah mahasiswa wajib diisi',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'description.required' => 'Deskripsi wajib diisi',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('schools', 'public');
        }

        DB::beginTransaction();

        try {
            // Add @ to instagram if not present
            if (!empty($validated['instagram']) && !str_starts_with($validated['instagram'], '@')) {
                $validated['instagram'] = '@' . $validated['instagram'];
            }

            $school = School::create($validated);

            // Handle faculties - simpan programs sebagai HTML
            if ($request->has('faculties')) {
                $facultiesData = json_decode($request->faculties, true);

                if (is_array($facultiesData)) {
                    foreach ($facultiesData as $faculty) {
                        if (!empty($faculty['name'])) {
                            // Simpan programs_html langsung tanpa pemrosesan
                            $school->faculties()->create([
                                'name' => $faculty['name'],
                                'programs' => $faculty['programs_html'] ?? ''
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.pencarian-sekolah.index')
                ->with('success', 'Perguruan tinggi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Terjadi kesalahan saat menambahkan data perguruan tinggi.');
        }
    }

    /**
     * Display the specified school.
     */
    public function show(School $pencarianSekolah)
    {
        return view('admin.pencarian-sekolah.show', ['school' => $pencarianSekolah]);
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit(School $pencarianSekolah)
    {
        return view('admin.pencarian-sekolah.edit', ['school' => $pencarianSekolah]);
    }

    /**
     * Update the specified school in storage.
     */
    public function update(Request $request, School $pencarianSekolah)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'accreditation' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'founded_year' => 'required|integer',
            'status' => 'required|string|max:255',
            'students' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'description' => 'required|string',
            'address' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama perguruan tinggi wajib diisi',
            'type.required' => 'Jenis perguruan tinggi wajib diisi',
            'accreditation.required' => 'Akreditasi wajib diisi',
            'city.required' => 'Kota wajib diisi',
            'province.required' => 'Provinsi wajib diisi',
            'founded_year.required' => 'Tahun berdiri wajib diisi',
            'founded_year.integer' => 'Tahun berdiri harus berupa angka',
            'status.required' => 'Status wajib diisi',
            'students.required' => 'Jumlah mahasiswa wajib diisi',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'description.required' => 'Deskripsi wajib diisi',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($pencarianSekolah->image && Storage::disk('public')->exists($pencarianSekolah->image)) {
                Storage::disk('public')->delete($pencarianSekolah->image);
            }
            $validated['image'] = $request->file('image')->store('schools', 'public');
        }

        DB::beginTransaction();

        try {
            // Add @ to instagram if not present
            if (!empty($validated['instagram']) && !str_starts_with($validated['instagram'], '@')) {
                $validated['instagram'] = '@' . $validated['instagram'];
            }

            $pencarianSekolah->update($validated);

            // Handle faculties - simpan programs sebagai HTML
            if ($request->has('faculties')) {
                $facultiesData = json_decode($request->faculties, true);
                // dd($facultiesData);

                $pencarianSekolah->faculties()->delete();

                // Create new faculties
                if (is_array($facultiesData)) {
                    foreach ($facultiesData as $faculty) {
                        if (!empty($faculty['name'])) {
                            // Simpan programs_html langsung tanpa pemrosesan
                            $pencarianSekolah->faculties()->create([
                                'name' => $faculty['name'],
                                'programs' => $faculty['programs_html'] ?? ''
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.pencarian-sekolah.index')
                ->with('success', 'Data perguruan tinggi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Terjadi kesalahan saat memperbarui data perguruan tinggi.');
        }
    }

    /**
     * Remove the specified school from storage.
     */
    public function destroy(School $pencarianSekolah)
    {
        try {
            // Delete the image if it exists
            if ($pencarianSekolah->image && Storage::disk('public')->exists($pencarianSekolah->image)) {
                Storage::disk('public')->delete($pencarianSekolah->image);
            }

            // Delete the school (faculties will be deleted via cascade)
            $pencarianSekolah->delete();

            return redirect()->route('admin.pencarian-sekolah.index')
                ->with('success', 'Perguruan tinggi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data perguruan tinggi.');
        }
    }
}
