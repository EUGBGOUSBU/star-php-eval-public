<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::with(['category', 'author'])->latest('published_at')->get();

        return view('articles.index', ['articles' => $articles]);
    }

    public function show(string $permalink): View
    {
        $article = Article::with(['category', 'author'])->where('permalink', $permalink)->firstOrFail();

        return view('articles.show', ['article' => $article]);
    }
}
