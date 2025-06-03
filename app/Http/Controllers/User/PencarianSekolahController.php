<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Activity;
use Illuminate\Http\Request;

class PencarianSekolahController extends Controller
{

    protected $activity;

    public function __construct()
    {
        $this->activity = new Activity();
    }

    public function index()
    {
        // Catat aktivitas user mengakses halaman pencarian sekolah
        $this->activity->saveActivity('Mengakses halaman pencarian sekolah');

        $schools = School::all();
        return view('user.pencarian-sekolah.index', compact('schools'));
    }

    public function show(School $school)
    {
        // Catat aktivitas user melihat detail sekolah
        $this->activity->saveActivity('Melihat detail sekolah: ' . $school->name);

        return view('user.pencarian-sekolah.show', compact('school'));
    }
}
