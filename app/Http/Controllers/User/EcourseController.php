<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ECourse;
use App\Models\CourseVideo;
use App\Models\Exam;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ECourseController extends Controller
{

    protected $activity;

    public function __construct()
    {
        $this->activity = new Activity();
    }
    public function index(Request $request)
    {
        $query = ECourse::query();

        // Filter by category if provided
        if ($request->has('kategori')) {
            $query->byCategory($request->kategori);
        }

        // Filter by search query if provided
        if ($request->has('query')) {
            $query->search($request->query('query'));
        }

        // Paginate the results
        $courses = $query->paginate(6);


        $this->activity->saveActivity('Mengakses halaman e-course');

        return view('user.e-course', compact('courses'));
    }

    public function show($id)
    {
        $course = ECourse::findOrFail($id);
        $courseVideos = $course->getCourseVideos();

        // Get exam related to this course
        $exam = Exam::where('course_id', $id)->first();

        // Check if user has any existing exam session for this exam
        $examSession = null;
        if ($exam) {
            $examSession = ExamSession::where('user_id', Auth::id())
                ->where('exam_id', $exam->id)
                ->latest()
                ->first();
        }

        if ($courseVideos->count() == 0) {
            return view('user.e-course-detail', [
                'course' => $course,
                'courseVideos' => collect(),
                'currentVideo' => null,
                'exam' => $exam,
                'examSession' => $examSession
            ]);
        }

        // Get the first video to display initially
        $firstVideo = $courseVideos->sortBy('order')->first();

        $this->activity->saveActivity('Melihat detail e-course: ' . $course->course_name);

        return view('user.e-course-detail', [
            'course' => $course,
            'courseVideos' => $courseVideos,
            'currentVideo' => $firstVideo,
            'exam' => $exam,
            'examSession' => $examSession
        ]);
    }
}