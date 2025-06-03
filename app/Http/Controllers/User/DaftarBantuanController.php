<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class DaftarBantuanController extends Controller
{
    public function index(Request $request)
    {
        // Fetch scholarships based on search criteria
        $scholarships = Scholarship::Filter($request->search)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.daftar-bantuan', compact('scholarships'));
    }

    public function show(Scholarship $scholarship)
    {
        $now = now();
        $isActive = $scholarship->registration_start <= $now && $scholarship->registration_end >= $now;

        return response()->json([
            'scholarship' => [
                'id' => $scholarship->id,
                'name' => $scholarship->name,
                'description' => $scholarship->description,
                'registration_start' => $scholarship->registration_start,
                'registration_end' => $scholarship->registration_end,
                'formatted_registration_start' => $scholarship->formatted_registration_start,
                'formatted_registration_end' => $scholarship->formatted_registration_end,
                'thumbnail' => $scholarship->thumbnail,
                'is_active' => $isActive,
                'created_at' => $scholarship->created_at->format('d F Y H:i'),
            ]
        ]);
    }
}
