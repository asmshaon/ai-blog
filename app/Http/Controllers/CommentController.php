<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function store(Request $request, BlogPost $post): RedirectResponse
    {
        if (! $request->user()) {
            throw ValidationException::withMessages([
                'auth' => 'You must be logged in to comment.',
            ]);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $post->comments()->create([
            'user_id' => $request->user()->id,
            'parent_id' => $validated['parent_id'] ?? null,
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Comment posted.');
    }

    public function destroy(Request $request, Comment $comment): RedirectResponse
    {
        if ($request->user()->id !== $comment->user_id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
