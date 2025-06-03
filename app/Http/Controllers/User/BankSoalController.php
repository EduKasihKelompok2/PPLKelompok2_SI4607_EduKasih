<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\BankSoal;
use Illuminate\Http\Request;

class BankSoalController extends Controller
{
    protected $activity;

    public function __construct()
    {
        $this->activity = new Activity();
    }
    public function index(Request $request)
    {
        $bankSoals = BankSoal::filter([
            'search' => $request->search,
            'class' => $request->class,
            'subject' => $request->subject,
        ])->latest()
            ->paginate(8)
            ->withQueryString();

        $this->activity->saveActivity('Mengakses halaman bank soal');
        return view('user.bank-soal', compact('bankSoals'));
    }
}
