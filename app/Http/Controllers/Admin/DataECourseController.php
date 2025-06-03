<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ECourse;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DataECourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ECourse::query();

        // Apply category filter if provided
        if ($request->has('kategori')) {
            $query->byCategory($request->kategori);
        }

        // Apply search query if provided
        if ($request->has('query')) {
            $query->search($request->query('query'));
        }

        $courses = $query->paginate(9);

        return view('admin.e-course', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.e-course-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|unique:e_course,course_code',
            'course_name' => 'required|string|max:255',
            'nama_mapel' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|numeric|min:1|max:5',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'course_' . Str::slug($request->course_name) . '_' . time() . '.' . $image->extension();
            $image->storeAs('public/courses', $imageName);
            $data['image'] = 'storage/courses/' . $imageName;
        }

        // Set default values
        if (!isset($data['rating'])) {
            $data['rating'] = 5.0;
        }

        // Create the e-course
        $course = ECourse::create($data);

        // Automatically create a default exam for this course
        Exam::create([
            'course_id' => $course->id,
            'title' => 'Soal ' . $course->nama_mapel,
            'duration_minutes' => 60 // Default 1 hour exam
        ]);

        return redirect()->route('admin.e-course')
            ->with('success', 'E-Course berhasil ditambahkan beserta ujiannya!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = ECourse::findOrFail($id);
        $courseVideos = $course->getCourseVideos();

        return view('admin.e-course-detail', compact('course', 'courseVideos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = ECourse::findOrFail($id);
        return view('admin.e-course-edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = ECourse::findOrFail($id);

        $request->validate([
            'course_code' => 'required|string|unique:e_course,course_code,' . $id,
            'course_name' => 'required|string|max:255',
            'nama_mapel' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|numeric|min:1|max:5',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($course->image && Storage::exists('public/' . str_replace('storage/', '', $course->image))) {
                Storage::delete('public/' . str_replace('storage/', '', $course->image));
            }

            // Upload new image
            $image = $request->file('image');
            $imageName = 'course_' . Str::slug($request->course_name) . '_' . time() . '.' . $image->extension();
            $image->storeAs('public/courses', $imageName);
            $data['image'] = 'storage/courses/' . $imageName;
        }

        $course->update($data);

        return redirect()->route('admin.e-course.show', $course->id)
            ->with('success', 'E-Course berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = ECourse::findOrFail($id);

        // Delete associated image
        if ($course->image && Storage::exists('public/' . str_replace('storage/', '', $course->image))) {
            Storage::delete('public/' . str_replace('storage/', '', $course->image));
        }

        $course->delete();

        return redirect()->route('admin.e-course')
            ->with('success', 'E-Course berhasil dihapus!');
    }
}
