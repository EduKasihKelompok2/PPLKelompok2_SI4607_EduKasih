<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ECourse;
use App\Models\Exam;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ExamManagementController extends Controller
{
    public function index()
    {
        $exams = Exam::with('course')->latest()->paginate(10);
        return view('admin.exams.index', compact('exams'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:e_courses,id',
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if course already has an exam
        $existingExam = Exam::where('course_id', $request->course_id)->first();
        if ($existingExam) {
            return redirect()->route('admin.e-course.show', $request->course_id)
                ->with('error', 'Kursus ini sudah memiliki ujian. Anda hanya dapat memiliki satu ujian per kursus.');
        }

        $exam = Exam::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'duration_minutes' => $request->duration_minutes
        ]);

        return redirect()->route('admin.e-course.show', $request->course_id)
            ->with('success', 'Ujian berhasil dibuat. Sekarang Anda dapat menambahkan pertanyaan.');
    }

    public function show($id)
    {
        $exam = Exam::with([
            'course',
            'questions' => function ($query) {
                $query->orderBy('order');
            }
        ])->findOrFail($id);

        return view('admin.exams.show', compact('exam'));
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $exam->update([
            'title' => $request->title,
            'duration_minutes' => $request->duration_minutes
        ]);

        return redirect()->route('admin.e-course.show', $exam->course_id)
            ->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Prevent direct deletion of exams
        return redirect()->back()
            ->with('error', 'Ujian tidak dapat dihapus. Ini adalah bagian integral dari kursus.');
    }

    // Alternative approach: comment out the entire method if you want to completely disable it
    /*
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $courseId = $exam->course_id;

        // Delete question images first
        foreach ($exam->questions as $question) {
            if ($question->image_path && Storage::exists('public/' . $question->image_path)) {
                Storage::delete('public/' . $question->image_path);
            }
        }

        $exam->delete();

        return redirect()->route('admin.e-course.show', $courseId)
            ->with('success', 'Ujian berhasil dihapus.');
    }
    */

    // Question Management

    public function storeQuestion(Request $request, $examId)
    {
        $exam = Exam::findOrFail($examId);

        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'answer_a' => 'required|string',
            'answer_b' => 'required|string',
            'answer_c' => 'required|string',
            'answer_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Get the next order number
        $nextOrder = $exam->questions()->max('order') + 1;
        if ($nextOrder === null)
            $nextOrder = 1;

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('exam-questions', 'public');
        }

        ExamQuestion::create([
            'exam_id' => $examId,
            'question' => $request->question,
            'image_path' => $imagePath,
            'answer_a' => $request->answer_a,
            'answer_b' => $request->answer_b,
            'answer_c' => $request->answer_c,
            'answer_d' => $request->answer_d,
            'correct_answer' => $request->correct_answer,
            'order' => $nextOrder
        ]);

        return redirect()->route('admin.e-course.show', $exam->course_id)
            ->with('success', 'Pertanyaan berhasil ditambahkan.')
            ->with('active_tab', 'exam');
    }

    public function editQuestion($examId, $questionId)
    {
        $question = ExamQuestion::findOrFail($questionId);
        return response()->json($question);
    }

    public function updateQuestion(Request $request, $examId, $questionId)
    {
        $exam = Exam::findOrFail($examId);
        $question = ExamQuestion::findOrFail($questionId);

        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'answer_a' => 'required|string',
            'answer_b' => 'required|string',
            'answer_c' => 'required|string',
            'answer_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image if exists
            if ($question->image_path && Storage::exists('public/' . $question->image_path)) {
                Storage::delete('public/' . $question->image_path);
            }

            // Upload new image
            $imagePath = $request->file('image')->store('exam-questions', 'public');
            $question->image_path = $imagePath;
        }

        $question->update([
            'question' => $request->question,
            'answer_a' => $request->answer_a,
            'answer_b' => $request->answer_b,
            'answer_c' => $request->answer_c,
            'answer_d' => $request->answer_d,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('admin.e-course.show', $exam->course_id)
            ->with('success', 'Pertanyaan berhasil diperbarui.')
            ->with('active_tab', 'exam');
    }

    public function destroyQuestion($examId, $questionId)
    {
        $exam = Exam::findOrFail($examId);
        $question = ExamQuestion::findOrFail($questionId);

        // Delete image if exists
        if ($question->image_path && Storage::exists('public/' . $question->image_path)) {
            Storage::delete('public/' . $question->image_path);
        }

        $question->delete();

        // Reorder remaining questions
        $remainingQuestions = ExamQuestion::where('exam_id', $examId)
            ->orderBy('order')
            ->get();

        foreach ($remainingQuestions as $index => $q) {
            $q->update(['order' => $index + 1]);
        }

        return redirect()->route('admin.e-course.show', $exam->course_id)
            ->with('success', 'Pertanyaan berhasil dihapus.')
            ->with('active_tab', 'exam');
    }
}
