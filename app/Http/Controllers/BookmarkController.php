<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle(Request $request, BlogPost $post): RedirectResponse
    {
        $bookmark = $request->user()->bookmarks()->where('blog_post_id', $post->id)->first();

        if ($bookmark) {
            $bookmark->delete();
        } else {
            $request->user()->bookmarks()->create(['blog_post_id' => $post->id]);
        }

        return back();
    }
}
