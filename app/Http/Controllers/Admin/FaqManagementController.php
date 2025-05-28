<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqManagementController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faq', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Failed to create FAQ.');
        }

        Faq::create($validator->validated());

        return redirect()->route('admin.faq')->with('success', 'FAQ created successfully');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Failed to update FAQ.');
        }

        $faq = Faq::findOrFail($id);
        $faq->update($validator->validated());

        return redirect()->route('admin.faq')->with('success', 'FAQ updated successfully');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq')->with('success', 'FAQ deleted successfully');
    }
}
