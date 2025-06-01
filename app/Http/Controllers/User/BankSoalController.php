<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use Illuminate\Http\Request;

class BankSoalController extends Controller
{
    public function index(Request $request)
    {
        $bankSoals = BankSoal::filter([
            'search' => $request->search,
            'class' => $request->class,
            'subject' => $request->subject,
        ])->latest()
            ->paginate(8)
            ->withQueryString();

        return view('user.bank-soal', compact('bankSoals'));
    }
}
