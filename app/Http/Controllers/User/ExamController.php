<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\ExamQuestion;
use App\Models\ExamSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    protected $activity;

    public function __construct()
    {
        $this->activity = new Activity();
    }
    public function start($examId)
    {
        $exam = Exam::findOrFail($examId);

        // Check if there's an existing incomplete session
        $existingSession = ExamSession::where('user_id', Auth::id())
            ->where('exam_id', $examId)
            ->where('is_completed', false)
            ->first();

        if ($existingSession) {
            // Resume existing session
            return $this->showQuestion($existingSession->id);
        }

        // Create a new session
        $session = ExamSession::create([
            'user_id' => Auth::id(),
            'exam_id' => $examId,
            'started_at' => now(),
            'ends_at' => now()->addMinutes($exam->duration_minutes),
            'current_question' => 1
        ]);

        // Initialize answers for all questions
        $questions = $exam->questions;
        foreach ($questions as $question) {
            ExamAnswer::create([
                'exam_session_id' => $session->id,
                'exam_question_id' => $question->id
            ]);
        }

        $this->activity->saveActivity('Memulai ujian: ' . $exam->course->course_name);

        return $this->showQuestion($session->id);
    }

    public function showQuestion($sessionId)
    {
        $session = ExamSession::with('exam.questions')->findOrFail($sessionId);

        // Check if exam time is over
        if (now() > $session->ends_at && !$session->is_completed) {
            return $this->completeExam(new Request(), $sessionId);
        }

        // Get current question
        $currentQuestionNumber = $session->current_question;
        $question = $session->exam->questions()
            ->orderBy('order')
            ->offset($currentQuestionNumber - 1)
            ->first();

        if (!$question) {
            // If question not found, use the first question
            $question = $session->exam->questions()->orderBy('order')->first();
            $session->update(['current_question' => 1]);
        }

        // Get user's answer for this question if any
        $userAnswer = ExamAnswer::where('exam_session_id', $sessionId)
            ->where('exam_question_id', $question->id)
            ->first();

        // Get total questions count
        $totalQuestions = $session->exam->questions()->count();

        return view('user.exam', [
            'session' => $session,
            'exam' => $session->exam,
            'question' => $question,
            'currentQuestionNumber' => $currentQuestionNumber,
            'totalQuestions' => $totalQuestions,
            'userAnswer' => $userAnswer ? $userAnswer->selected_answer : null
        ]);
    }

    public function submitAnswer(Request $request, $sessionId)
    {
        $session = ExamSession::findOrFail($sessionId);
        $questionId = $request->input('question_id');
        $answer = $request->input('answer');

        // For "prev" button, we don't need to validate the answer as it might not be filled
        $goToPrev = $request->has('prev');

        if (!$goToPrev) {
            // Only validate if not going to previous question
            $request->validate([
                'question_id' => 'required|exists:exam_questions,id',
                'answer' => 'required|in:a,b,c,d'
            ]);
        }

        // Save answer only if one is provided
        if ($answer) {
            // Get the question
            $question = ExamQuestion::findOrFail($questionId);

            // Save the answer
            $examAnswer = ExamAnswer::where('exam_session_id', $sessionId)
                ->where('exam_question_id', $questionId)
                ->first();

            if (!$examAnswer) {
                $examAnswer = new ExamAnswer([
                    'exam_session_id' => $sessionId,
                    'exam_question_id' => $questionId
                ]);
            }

            $examAnswer->selected_answer = $answer;
            $examAnswer->is_correct = ($answer == $question->correct_answer);
            $examAnswer->save();
        }

        // Determine next question
        $goToNext = $request->has('next');

        if ($goToPrev) {
            $session->current_question = max(1, $session->current_question - 1);
        } elseif ($goToNext) {
            $totalQuestions = $session->exam->questions()->count();
            $session->current_question = min($totalQuestions, $session->current_question + 1);
        }

        $session->save();

        return redirect()->route('exam.question', $sessionId);
    }

    public function completeExam(Request $request, $sessionId)
    {
        $session = ExamSession::with('exam.questions')->findOrFail($sessionId);

        if (!$session->is_completed) {
            // Save the last answer if provided in the request
            $this->saveAnswerFromRequest($request, $sessionId);

            // Calculate score
            $correctAnswers = $this->evaluateAndCountCorrectAnswers($session);
            $totalQuestions = $session->exam->questions()->count();
            $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

            // Update session
            $session->update([
                'completed_at' => now(),
                'is_completed' => true,
                'score' => $score
            ]);
        }

        $isPassed = ($session->score == 100);

        if ($isPassed) {
            //count user has passed exam how many times
            $count = ExamSession::where('user_id', Auth::id())
                ->where('is_completed', true)
                ->where('score', 100)
                ->count();

            $badge = \App\Models\Badge::where('requirement', $count)->first();
            if ($badge) {
                $userBadge = \App\Models\UserBadge::where('user_id', Auth::id())
                    ->where('badge_id', $badge->id)
                    ->first();
                if (!$userBadge) {
                    $gotBadge = \App\Models\UserBadge::create([
                        'user_id' => Auth::id(),
                        'badge_id' => $badge->id
                    ]);

                    // Save activity for badge
                    $this->activity->saveActivity('Mendapatkan badge: ' . $badge->name);

                    $notif = new \App\Models\Notification();
                    $notif->send('Selamat! Kamu telah mendapatkan badge: ' . $badge->name);
                }
            }
        }
        $courseId = $session->exam->course_id;

        $this->activity->saveActivity('Menyelesaikan ujian: ' . $session->exam->course->course_name);

        return view('user.exam-completed', [
            'session' => $session,
            'score' => $session->score,
            'isPassed' => $isPassed,
            'courseId' => $courseId,
            'badge' => isset($gotBadge) ? $gotBadge : null
        ]);
    }

    /**
     * Save answer from request if present
     *
     * @param Request $request
     * @param int $sessionId
     * @return void
     */
    private function saveAnswerFromRequest(Request $request, $sessionId)
    {
        if (!$request->has('question_id') || !$request->has('answer')) {
            return;
        }

        $questionId = $request->input('question_id');
        $answer = $request->input('answer');

        if (!in_array($answer, ['a', 'b', 'c', 'd'])) {
            return;
        }

        try {
            $question = ExamQuestion::findOrFail($questionId);
            $examAnswer = ExamAnswer::where('exam_session_id', $sessionId)
                ->where('exam_question_id', $questionId)
                ->first();

            if ($examAnswer) {
                $examAnswer->selected_answer = $answer;
                $examAnswer->is_correct = ($answer == $question->correct_answer);
                $examAnswer->save();
            }
        } catch (\Exception $e) {
            // Log error but continue with exam completion
            \Log::error("Error saving final answer: " . $e->getMessage());
        }
    }

    /**
     * Evaluate all answers and return count of correct ones
     *
     * @param ExamSession $session
     * @return int
     */
    private function evaluateAndCountCorrectAnswers(ExamSession $session)
    {
        $questions = $session->exam->questions;
        $answers = ExamAnswer::where('exam_session_id', $session->id)->get();

        // Build a map of question IDs to correct answers for efficiency
        $correctAnswersMap = $questions->pluck('correct_answer', 'id')->toArray();

        $correctCount = 0;

        foreach ($answers as $answer) {
            $questionId = $answer->exam_question_id;
            $selected = $answer->selected_answer;
            $isCorrect = false;

            if ($selected && isset($correctAnswersMap[$questionId])) {
                $isCorrect = ($selected === $correctAnswersMap[$questionId]);
            }

            $answer->is_correct = $isCorrect;
            $answer->save();

            if ($isCorrect) {
                $correctCount++;
            }
        }

        return $correctCount;
    }
}
