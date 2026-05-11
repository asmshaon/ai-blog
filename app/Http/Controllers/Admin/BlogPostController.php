<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class BlogPostController extends Controller
{
    public function index(Request $request): Response
    {
        $query = BlogPost::with(['user', 'category'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return Inertia::render('Admin/Posts/Index', [
            'posts' => $query->paginate(15)->withQueryString(),
            'filters' => $request->only('status'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Posts/Create', [
            'categories' => Category::select('id', 'name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'featured_image' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'og_image' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $post = BlogPost::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        $this->syncTags($post, $validated['tags'] ?? []);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(BlogPost $post): Response
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post->load('tags'),
            'categories' => Category::select('id', 'name')->get(),
        ]);
    }

    public function update(Request $request, BlogPost $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,'.$post->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'featured_image' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'og_image' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $post->update($validated);
        $this->syncTags($post, $validated['tags'] ?? []);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(BlogPost $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    private function syncTags(BlogPost $post, array $tagNames): void
    {
        $tagIds = [];
        foreach ($tagNames as $name) {
            $tag = Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
            $tagIds[] = $tag->id;
        }
        $post->tags()->sync($tagIds);
    }
}
