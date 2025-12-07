<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()->latest()->paginate(9);
        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        $news->increment('views_count');
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }
}
