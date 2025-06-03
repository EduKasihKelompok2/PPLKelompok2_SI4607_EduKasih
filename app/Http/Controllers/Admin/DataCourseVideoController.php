<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseVideo;
use App\Models\ECourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DataCourseVideoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|exists:e_course,course_code',
            'title' => 'required|string|max:255',
            'video_url' => 'required|string|max:255',
            'duration' => 'required|numeric|min:1',
            'order' => 'nullable|numeric|min:1',
        ]);

        $data = $request->all();

        // If order is not provided, set it as the last one
        if (!isset($data['order'])) {
            $lastOrder = CourseVideo::where('course_code', $request->course_code)
                ->max('order');
            $data['order'] = $lastOrder ? $lastOrder + 1 : 1;
        }

        $courseVideo = CourseVideo::create($data);

        $course = ECourse::where('course_code', $request->course_code)->first();

        return redirect()->route('admin.e-course.show', $course->id)
            ->with('success', 'Materi video berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = CourseVideo::findOrFail($id);
        return response()->json($video);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = CourseVideo::findOrFail($id);
        return response()->json($video);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $video = CourseVideo::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|string|max:255',
            'duration' => 'required|numeric|min:1',
            'order' => 'nullable|numeric|min:1',
        ]);

        $data = $request->except(['_token', '_method']);

        $video->update($data);

        $course = $video->eCourse;

        return redirect()->route('admin.e-course.show', $course->id)
            ->with('success', 'Materi video berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = CourseVideo::findOrFail($id);
        $courseId = $video->eCourse->id;
        $courseCode = $video->course_code;
        $currentOrder = $video->order;

        // Delete the video
        $video->delete();

        // Decrement order for all videos that come after the deleted one
        CourseVideo::where('course_code', $courseCode)
            ->where('order', '>', $currentOrder)
            ->decrement('order');

        return redirect()->route('admin.e-course.show', $courseId)
            ->with('success', 'Materi video berhasil dihapus!');
    }
}
