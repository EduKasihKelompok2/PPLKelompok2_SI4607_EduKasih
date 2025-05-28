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

    //yang sini isi sha yang indexmotivasi

    public function indexPendidikan(Request $request)
    {
        $articles = Articles::pendidikan()->filter($request->all())->latest('tanggal_terbit')->paginate(8);
        return view('user.articles.article-pendidikan', compact('articles'));
    }

    //sama yang show
}
