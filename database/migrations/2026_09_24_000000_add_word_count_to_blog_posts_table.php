<?php

use App\Models\BlogPost;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->unsignedInteger('word_count')->default(0)->after('reading_time');
        });

        // Backfill only word_count; no other column or post is changed.
        DB::table('blog_posts')->select(['id', 'content'])->orderBy('id')->chunkById(100, function ($posts) {
            foreach ($posts as $post) {
                DB::table('blog_posts')->where('id', $post->id)->update([
                    'word_count' => BlogPost::countWords($post->content),
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('word_count');
        });
    }
};
