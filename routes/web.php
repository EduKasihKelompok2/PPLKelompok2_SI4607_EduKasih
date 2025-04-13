<?php

use App\Http\Controllers\Admin\DataBankSoalController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\BankSoalController;
use App\Http\Controllers\User\ECourseController;
use App\Http\Controllers\User\FAQController;
use App\Http\Controllers\User\JadwalBelajarController;
use App\Http\Controllers\User\PencarianSekolahController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'loginPost']);
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'registerPost']);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Jadwal Belajar
    Route::get('/jadwal-belajar', [JadwalBelajarController::class, 'index'])->name('jadwal-belajar');
    Route::post('/jadwal-belajar', [JadwalBelajarController::class, 'store']);
    Route::put('/jadwal-belajar/{id}', [JadwalBelajarController::class, 'update']);
    Route::delete('/jadwal-belajar/{id}', [JadwalBelajarController::class, 'destroy']);

    //E-Course
    Route::get('/e-course', [ECourseController::class, 'index'])->name('e-course');
    Route::get('/e-course/{id}', [ECourseController::class, 'show'])->name('e-course.show');
    //Pencarian Sekolah
    Route::get('/pencarian-sekolah', [PencarianSekolahController::class, 'index'])->name('pencarian-sekolah');

    //FAQ
    Route::get('/faq', [FAQController::class, 'index'])->name('faq');

    //Bank Soal
    Route::get('/bank-soal', [BankSoalController::class, 'index'])->name('bank-soal');
    

    //Profile & Logout
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');

    // Bank Soal Routes
    Route::get('/bank-soal', [DataBankSoalController::class, 'index'])->name('admin.bank-soal');
    Route::post('/bank-soal', [DataBankSoalController::class, 'store'])->name('admin.bank-soal.store');
    Route::put('/bank-soal/{id}', [DataBankSoalController::class, 'update'])->name('admin.bank-soal.update');
    Route::delete('/bank-soal/{id}', [DataBankSoalController::class, 'destroy'])->name('admin.bank-soal.destroy');
});

//Fallback
Route::fallback(function () {
    return redirect()->route('home');
});

