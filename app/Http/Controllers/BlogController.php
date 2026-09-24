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
        $query = BlogPost::with('category:id,name,slug')
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

        // The listing only needs what each entry shows, never the full content.
        $posts = $query->paginate(10)->withQueryString()->through(fn (BlogPost $post) => [
            'id' => $post->id,
            'slug' => $post->slug,
            'title' => $post->title,
            'excerpt' => $post->excerpt,
            'published_at' => $post->published_at,
            'word_count' => $post->word_count,
            'category' => $post->category?->only(['name', 'slug']),
        ]);

        $filtered = $request->filled('search') || $request->filled('category') || $request->filled('tag');

        return Inertia::render('Blog/Index', [
            'posts' => $posts,
            'filters' => $request->only(['search', 'category', 'tag']),
            'showLatestBadge' => ! $filtered && $posts->currentPage() === 1,
            'categories' => Category::select('id', 'name', 'slug')
                ->withCount(['blogPosts as posts_count' => fn ($q) => $q->published()])
                ->whereHas('blogPosts', fn ($q) => $q->published())
                ->orderBy('name')
                ->get(),
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
