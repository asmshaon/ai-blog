<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Response;

class FeedController extends Controller
{
    public function __invoke(): Response
    {
        $posts = BlogPost::with('category:id,name')
            ->published()
            ->latest('published_at')
            ->limit(20)
            ->get(['id', 'category_id', 'title', 'slug', 'excerpt', 'published_at']);

        return response()
            ->view('feed', ['posts' => $posts])
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }
}
