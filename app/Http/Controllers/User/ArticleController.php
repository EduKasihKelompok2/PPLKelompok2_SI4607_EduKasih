<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Articles;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    protected $activity;

    public function __construct()
    {
        $this->activity = new Activity();
    }

    public function indexMotivasi(Request $request)
    {
        $articles = Articles::motivasi()->filter($request->all())->latest('tanggal_terbit')->paginate(8);

        
        return view('user.articles.article-motivasi', compact('articles'));
    }

    public function indexPendidikan(Request $request)
    {
        $articles = Articles::pendidikan()->filter($request->all())->latest('tanggal_terbit')->paginate(8);
        return view('user.articles.article-pendidikan', compact('articles'));
    }

    public function show($id)
    {
        $article = Articles::findOrFail($id);
        return view('user.articles.show', compact('article'));
    }
}
