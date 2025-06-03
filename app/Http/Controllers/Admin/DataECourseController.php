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
    
    public function index(Request $request)
    {
        $query = ECourse::query();

        
        if ($request->has('kategori')) {
            $query->byCategory($request->kategori);
        }

      
        if ($request->has('query')) {
            $query->search($request->query('query'));
        }

        $courses = $query->paginate(9);

        return view('admin.e-course', compact('courses'));
    }

    
    public function create()
    {
        return view('admin.e-course-create');
    }

    
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

        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'course_' . Str::slug($request->course_name) . '_' . time() . '.' . $image->extension();
            $image->storeAs('public/courses', $imageName);
            $data['image'] = 'storage/courses/' . $imageName;
        }

        
        if (!isset($data['rating'])) {
            $data['rating'] = 5.0;
        }

       
        $course = ECourse::create($data);

        
        Exam::create([
            'course_id' => $course->id,
            'title' => 'Soal ' . $course->nama_mapel,
            'duration_minutes' => 60 // Default 1 hour exam
        ]);

        return redirect()->route('admin.e-course')
            ->with('success', 'E-Course berhasil ditambahkan beserta ujiannya!');
    }

    
    public function show(string $id)
    {
        $course = ECourse::findOrFail($id);
        $courseVideos = $course->getCourseVideos();

        return view('admin.e-course-detail', compact('course', 'courseVideos'));
    }

    
    public function edit(string $id)
    {
        $course = ECourse::findOrFail($id);
        return view('admin.e-course-edit', compact('course'));
    }

   
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

        if ($request->hasFile('image')) {
            
            if ($course->image && Storage::exists('public/' . str_replace('storage/', '', $course->image))) {
                Storage::delete('public/' . str_replace('storage/', '', $course->image));
            }

            
            $image = $request->file('image');
            $imageName = 'course_' . Str::slug($request->course_name) . '_' . time() . '.' . $image->extension();
            $image->storeAs('public/courses', $imageName);
            $data['image'] = 'storage/courses/' . $imageName;
        }

        $course->update($data);

        return redirect()->route('admin.e-course.show', $course->id)
            ->with('success', 'E-Course berhasil diperbarui!');
    }

    
    public function destroy(string $id)
    {
        $course = ECourse::findOrFail($id);

        
        if ($course->image && Storage::exists('public/' . str_replace('storage/', '', $course->image))) {
            Storage::delete('public/' . str_replace('storage/', '', $course->image));
        }

        $course->delete();

        return redirect()->route('admin.e-course')
            ->with('success', 'E-Course berhasil dihapus!');
    }
}