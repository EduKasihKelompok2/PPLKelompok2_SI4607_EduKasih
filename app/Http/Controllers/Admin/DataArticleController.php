<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Http\Request;

class DataArticleController extends Controller
{
    public function indexMotivasi(Request $request)
    {
        $articles = Articles::motivasi()->filter(request(['search']))->latest()->paginate(10)->withQueryString();
        return view('admin.articles.article-motivasi', compact('articles'));
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required',
            'judul' => 'required',
            'tanggal_terbit' => 'required|date',
            'deskripsi' => 'required',
            'image' => 'image|file|max:2048'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('articles-images', 'public');
        }

        Articles::create($validatedData);

        if ($request->type == 'motivasi') {
            return redirect()->route('admin.articles.motivasi')->with('success', 'Artikel berhasil ditambahkan');
        } else {
            return redirect()->route('admin.articles.pendidikan')->with('success', 'Artikel berhasil ditambahkan');
        }
    }


}
