<?php

use App\Http\Controllers\Admin\BadgeController;
use App\Http\Controllers\Admin\DataBankSoalController;
use App\Http\Controllers\Admin\DataCourseVideoController;
use App\Http\Controllers\Admin\DataECourseController;
use App\Http\Controllers\Admin\DataPencarianSekolahController;
use App\Http\Controllers\Admin\ExamManagementController;
use App\Http\Controllers\Admin\FaqManagementController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\BankSoalController;
use App\Http\Controllers\User\DaftarBantuanController;
use App\Http\Controllers\User\ECourseController;
use App\Http\Controllers\User\ExamController;
use App\Http\Controllers\User\FAQController;
use App\Http\Controllers\User\JadwalBelajarController;
use App\Http\Controllers\User\PencarianSekolahController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'loginPost']);
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'registerPost']);
});

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Forum
    Route::resource('forum', App\Http\Controllers\ForumController::class)->except(['show', 'edit']);
    Route::post('forum/{id}/reply', [App\Http\Controllers\ForumController::class, 'reply'])->name('forum.reply');

    //Activity
    Route::get('/activity', [App\Http\Controllers\User\ActivityController::class, 'index'])->name('activity');
    Route::delete('/activity/{id}', [App\Http\Controllers\User\ActivityController::class, 'destroy'])->name('activity.destroy');

    //Jadwal Belajar
    Route::get('/jadwal-belajar', [JadwalBelajarController::class, 'index'])->name('jadwal-belajar');
    Route::post('/jadwal-belajar', [JadwalBelajarController::class, 'store']);
    Route::put('/jadwal-belajar/{id}', [JadwalBelajarController::class, 'update']);
    Route::delete('/jadwal-belajar/{id}', [JadwalBelajarController::class, 'destroy']);

    //E-Course
    Route::get('/e-course', [ECourseController::class, 'index'])->name('e-course');
    Route::get('/e-course/{id}', [ECourseController::class, 'show'])->name('e-course.show');

    // Exam
    Route::get('/exam/{examId}/start', [ExamController::class, 'start'])->name('exam.start');
    Route::get('/exam/{sessionId}', [ExamController::class, 'showQuestion'])->name('exam.question');
    Route::post('/exam/{sessionId}', [ExamController::class, 'submitAnswer'])->name('exam.submit-answer');
    Route::post('/exam/{sessionId}/complete', [ExamController::class, 'completeExam'])->name('exam.complete');

    //Pencarian Sekolah
    Route::get('/pencarian-sekolah', [PencarianSekolahController::class, 'index'])->name('pencarian-sekolah');
    Route::get('/pencarian-sekolah/{school}', [PencarianSekolahController::class, 'show'])->name('pencarian-sekolah.show');

    //Daftar Bantuan
    Route::get('/daftar-bantuan', [DaftarBantuanController::class, 'index'])->name('daftar-bantuan');
    Route::get('/daftar-bantuan/{scholarship}', [DaftarBantuanController::class, 'show'])->name('daftar-bantuan.show');

    //FAQ
    Route::get('/faq', [FAQController::class, 'index'])->name('faq');

    //Bank Soal
    Route::get('/bank-soal', [BankSoalController::class, 'index'])->name('bank-soal');

    //Profile & Logout
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // Articles Routes
    Route::get('/artikel-motivasi', [ArticleController::class, 'indexMotivasi'])->name('articles.motivasi');
    Route::get('/artikel-pendidikan', [ArticleController::class, 'indexPendidikan'])->name('articles.pendidikan');
    Route::get('/artikel/{id}', [ArticleController::class, 'show'])->name('articles.show');

    // Notifications
    Route::get('/notification/mark-as-read/{id}', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notification/mark-all-as-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // Rewards
    Route::get('/rewards', [App\Http\Controllers\User\RewardController::class, 'index'])->name('user.rewards');
    Route::post('/rewards/{reward}/claim', [App\Http\Controllers\User\RewardController::class, 'claim'])->name('user.rewards.claim');
    Route::get('/rewards/{reward}/download', [App\Http\Controllers\User\RewardController::class, 'download'])->name('user.rewards.download');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');

    // Bank Soal Management
    Route::get('/bank-soal', [DataBankSoalController::class, 'index'])->name('admin.bank-soal');
    Route::post('/bank-soal', [DataBankSoalController::class, 'store'])->name('admin.bank-soal.store');
    Route::put('/bank-soal/{id}', [DataBankSoalController::class, 'update'])->name('admin.bank-soal.update');
    Route::delete('/bank-soal/{id}', [DataBankSoalController::class, 'destroy'])->name('admin.bank-soal.destroy');

    // E-Course Management
    Route::get('/e-course', [DataECourseController::class, 'index'])->name('admin.e-course');
    Route::get('/e-course/create', [DataECourseController::class, 'create'])->name('admin.e-course.create');
    Route::get('/e-course/{id}', [DataECourseController::class, 'show'])->name('admin.e-course.show');
    Route::post('/e-course', [DataECourseController::class, 'store'])->name('admin.e-course.store');
    Route::get('/e-course/{id}/edit', [DataECourseController::class, 'edit'])->name('admin.e-course.edit');
    Route::put('/e-course/{id}', [DataECourseController::class, 'update'])->name('admin.e-course.update');
    Route::delete('/e-course/{id}', [DataECourseController::class, 'destroy'])->name('admin.e-course.destroy');

    // Course Video Management
    Route::post('/course-video', [DataCourseVideoController::class, 'store'])->name('admin.course-video.store');
    Route::get('/course-video/{id}', [DataCourseVideoController::class, 'show'])->name('admin.course-video.show');
    Route::get('/course-video/{id}/edit', [DataCourseVideoController::class, 'edit'])->name('admin.course-video.edit');
    Route::put('/course-video/{id}', [DataCourseVideoController::class, 'update'])->name('admin.course-video.update');
    Route::delete('/course-video/{id}', [DataCourseVideoController::class, 'destroy'])->name('admin.course-video.destroy');

    // Exam Management
    Route::post('/exams', [ExamManagementController::class, 'store'])->name('admin.exams.store');
    Route::put('/exams/{id}', [ExamManagementController::class, 'update'])->name('admin.exams.update');
    Route::delete('/exams/{id}', [ExamManagementController::class, 'destroy'])->name('admin.exams.destroy');

    // Exam Questions Management
    Route::post('/exams/{examId}/questions', [ExamManagementController::class, 'storeQuestion'])->name('admin.exams.questions.store');
    Route::put('/exams/{examId}/questions/{questionId}', [ExamManagementController::class, 'updateQuestion'])->name('admin.exams.questions.update');
    Route::delete('/exams/{examId}/questions/{questionId}', [ExamManagementController::class, 'destroyQuestion'])->name('admin.exams.questions.destroy');

    // FAQ Management
    Route::get('/faq', [FaqManagementController::class, 'index'])->name('admin.faq');
    Route::post('/faq', [FaqManagementController::class, 'store'])->name('admin.faq.store');
    Route::put('/faq/{id}', [FaqManagementController::class, 'update'])->name('admin.faq.update');
    Route::delete('/faq/{id}', [FaqManagementController::class, 'destroy'])->name('admin.faq.destroy');

    // Admin School Routes
    Route::resource('pencarian-sekolah', DataPencarianSekolahController::class)->names('admin.pencarian-sekolah');

    // Admin Articles Routes
    Route::get('/artikel-motivasi', [App\Http\Controllers\Admin\DataArticleController::class, 'indexMotivasi'])->name('admin.articles.motivasi');
    Route::get('/artikel-pendidikan', [App\Http\Controllers\Admin\DataArticleController::class, 'indexPendidikan'])->name('admin.articles.pendidikan');
    Route::post('/artikel/add', [App\Http\Controllers\Admin\DataArticleController::class, 'store'])->name('admin.articles.store');
    Route::put('/artikel/update/{article}', [App\Http\Controllers\Admin\DataArticleController::class, 'update'])->name('admin.articles.update');
    Route::delete('/artikel/delete/{article}', [App\Http\Controllers\Admin\DataArticleController::class, 'destroy'])->name('admin.articles.destroy');

    // Admin Daftar Bantuan Routes
    Route::get('scholarships', [App\Http\Controllers\Admin\DataScholarshipController::class, 'index'])->name('admin.scholarships.index');
    Route::post('scholarships', [App\Http\Controllers\Admin\DataScholarshipController::class, 'store'])->name('admin.scholarships.store');
    Route::get('scholarships/{scholarship}', [App\Http\Controllers\Admin\DataScholarshipController::class, 'show'])->name('admin.scholarships.show');
    Route::put('scholarships/{scholarship}', [App\Http\Controllers\Admin\DataScholarshipController::class, 'update'])->name('admin.scholarships.update');
    Route::delete('scholarships/{scholarship}', [App\Http\Controllers\Admin\DataScholarshipController::class, 'destroy'])->name('admin.scholarships.destroy');

    //Rewards Management
    Route::get('/rewards', [App\Http\Controllers\Admin\DataRewardsController::class, 'index'])->name('admin.rewards');
    Route::post('/rewards', [App\Http\Controllers\Admin\DataRewardsController::class, 'store'])->name('admin.rewards.store');
    Route::put('/rewards/{reward}', [App\Http\Controllers\Admin\DataRewardsController::class, 'update'])->name('admin.rewards.update');
    Route::delete('/rewards/{reward}', [App\Http\Controllers\Admin\DataRewardsController::class, 'destroy'])->name('admin.rewards.destroy');

    // Badge Management
    Route::get('/badges', [BadgeController::class, 'index'])->name('admin.badges');
    Route::post('/badges', [BadgeController::class, 'store'])->name('admin.badges.store');
    Route::put('/badges/{id}', [BadgeController::class, 'update'])->name('admin.badges.update');
    Route::delete('/badges/{id}', [BadgeController::class, 'destroy'])->name('admin.badges.destroy');
});

//Fallback
Route::fallback(function () {
    return redirect()->route('home');
});
