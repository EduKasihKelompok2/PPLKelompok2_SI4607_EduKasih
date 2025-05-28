<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Faq;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    protected $activity;

    public function __construct()
    {
        $this->activity = new Activity();
    }
    public function index(Request $request)
    {
        $faqs = Faq::all();

        $this->activity->saveActivity('Mengakses halaman FAQ');
        return view('user.faq', compact('faqs'));
    }
}
