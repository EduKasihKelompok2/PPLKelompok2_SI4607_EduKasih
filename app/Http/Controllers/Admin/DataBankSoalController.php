<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DataBankSoalController extends Controller
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

        return view('admin.bank-soal', compact('bankSoals'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'class' => 'required|string',
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'question_count' => 'required|integer|min:1',
            'upload_date' => 'required|date',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle file upload
        $file = $request->file('file');
        $filePath = $file->store('bank-soal', 'public');
        //$filePath = $file->storeAs('bank-soal', 'soal_test.pdf', 'public');

        // Create record
        BankSoal::create([
            'title' => $request->title,
            'class' => $request->class,
            'subject' => $request->subject,
            'description' => $request->description,
            'question_count' => $request->question_count,
            'file_path' => $filePath,
            'upload_date' => $request->upload_date,
        ]);

        return back()->with('success', 'Bank Soal berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $bankSoal = BankSoal::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'class' => 'required|string',
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'question_count' => 'required|integer|min:1',
            'upload_date' => 'required|date',
            'file' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle file upload if a new file is provided
        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($bankSoal->file_path)) {
                Storage::disk('public')->delete($bankSoal->file_path);
            }

            // Store new file
            $file = $request->file('file');
            $filePath = $file->store('bank-soal', 'public');
            $bankSoal->file_path = $filePath;
        }

        // Update other fields
        $bankSoal->title = $request->title;
        $bankSoal->class = $request->class;
        $bankSoal->subject = $request->subject;
        $bankSoal->description = $request->description;
        $bankSoal->question_count = $request->question_count;
        $bankSoal->upload_date = $request->upload_date;
        $bankSoal->save();

        return back()->with('success', 'Bank Soal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bankSoal = BankSoal::findOrFail($id);

        // Delete file from storage
        if (Storage::disk('public')->exists($bankSoal->file_path)) {
            Storage::disk('public')->delete($bankSoal->file_path);
        }

        // Delete record
        $bankSoal->delete();

        return back()->with('success', 'Bank Soal berhasil dihapus');
    }
}
