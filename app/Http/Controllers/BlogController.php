<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(Request $request): Response
    {
        $query = BlogPost::with(['user', 'category', 'tags'])
            ->published()
            ->latest('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('slug', $request->tag));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereHas('tags', fn ($tq) => $tq->where('name', 'like', "%{$search}%"));
            });
        }

        $posts = $query->paginate(9)->withQueryString();

        return Inertia::render('Blog/Index', [
            'posts' => $posts,
            'filters' => $request->only(['search', 'category', 'tag']),
            'categories' => Category::select('id', 'name', 'slug')->get(),
        ]);
    }

    public function show(string $slug): Response
    {
        $post = BlogPost::with(['user', 'category', 'tags', 'comments.user', 'comments.replies.user'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('view_count');

        $related = BlogPost::with(['user', 'category'])
            ->published()
            ->where('id', '!=', $post->id)
            ->where(function ($q) use ($post) {
                $q->where('category_id', $post->category_id)
                    ->orWhereHas('tags', fn ($tq) => $tq->whereIn('tags.id', $post->tags->pluck('id')));
            })
            ->latest('published_at')
            ->limit(3)
            ->get();

        return Inertia::render('Blog/Show', [
            'post' => $post,
            'related' => $related,
        ]);
    }
}
