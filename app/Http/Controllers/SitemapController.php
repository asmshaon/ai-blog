<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $posts = BlogPost::published()->latest('published_at')->get(['slug', 'updated_at']);

        $content = view('sitemap', compact('posts'))->render();

        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
