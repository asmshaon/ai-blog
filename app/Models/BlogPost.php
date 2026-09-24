<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'canonical_url',
        'og_image',
        'featured',
        'view_count',
        'status',
        'published_at',
        'reading_time',
        'word_count',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'word_count' => 'integer',
        'published_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 160);
            }
            $post->fillWordStats();
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if ($post->isDirty('content')) {
                $post->fillWordStats();
            }
        });
    }

    public static function countWords(?string $html): int
    {
        // Replace tags with spaces first so "<h2>Title</h2><p>Text" counts as two words.
        return str_word_count(strip_tags(preg_replace('/<[^>]*>/', ' ', (string) $html)));
    }

    protected function fillWordStats(): void
    {
        $this->word_count = static::countWords($this->content);
        $this->reading_time = max(1, (int) ($this->word_count / 200));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
