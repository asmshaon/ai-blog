<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class BlogRedesignTest extends TestCase
{
    use RefreshDatabase;

    private function publishedPost(array $attributes = []): BlogPost
    {
        return BlogPost::factory()->create(array_merge([
            'status' => 'published',
            'published_at' => now()->subDay(),
        ], $attributes));
    }

    public function test_word_count_is_stored_on_create(): void
    {
        $post = $this->publishedPost(['content' => '<p>'.str_repeat('word ', 450).'</p>']);

        $this->assertSame(450, $post->fresh()->word_count);
        $this->assertSame(2, $post->fresh()->reading_time);
    }

    public function test_word_count_and_reading_time_update_when_content_changes(): void
    {
        $post = $this->publishedPost(['content' => '<p>'.str_repeat('word ', 100).'</p>']);

        $post->update(['content' => '<h2>Title</h2><p>'.str_repeat('word ', 999).'</p>']);

        $this->assertSame(1000, $post->fresh()->word_count);
        $this->assertSame(5, $post->fresh()->reading_time);
    }

    public function test_listing_does_not_send_post_content(): void
    {
        $this->publishedPost();

        $this->get('/')->assertInertia(fn (Assert $page) => $page
            ->component('Blog/Index')
            ->has('posts.data', 1, fn (Assert $post) => $post
                ->hasAll(['id', 'slug', 'title', 'excerpt', 'published_at', 'word_count', 'category'])
                ->missing('content')
                ->etc()
            )
        );
    }

    public function test_latest_badge_only_on_unfiltered_first_page(): void
    {
        $category = Category::factory()->create(['slug' => 'payments']);
        $this->publishedPost(['category_id' => $category->id, 'title' => 'Never Let the App Set the Price']);

        $this->get('/')->assertInertia(fn (Assert $page) => $page->where('showLatestBadge', true));
        $this->get('/?search=price')->assertInertia(fn (Assert $page) => $page->where('showLatestBadge', false));
        $this->get('/?category=payments')->assertInertia(fn (Assert $page) => $page->where('showLatestBadge', false));
    }

    public function test_categories_list_only_those_with_published_posts_and_counts(): void
    {
        $payments = Category::factory()->create(['name' => 'Payments', 'slug' => 'payments']);
        $empty = Category::factory()->create(['name' => 'Empty', 'slug' => 'empty']);
        $this->publishedPost(['category_id' => $payments->id]);
        $this->publishedPost(['category_id' => $payments->id]);
        $this->publishedPost(['category_id' => $payments->id, 'status' => 'draft']);
        $this->publishedPost(['category_id' => $empty->id, 'published_at' => now()->addWeek()]);

        $this->get('/')->assertInertia(fn (Assert $page) => $page
            ->has('categories', 1)
            ->where('categories.0.slug', 'payments')
            ->where('categories.0.posts_count', 2)
        );
    }

    public function test_feed_lists_only_published_posts(): void
    {
        $this->publishedPost(['title' => 'Published Post']);
        $this->publishedPost(['title' => 'Draft Post', 'status' => 'draft']);
        $this->publishedPost(['title' => 'Future Post', 'published_at' => now()->addWeek()]);

        $response = $this->get('/feed.xml');

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8')
            ->assertSee('<rss version="2.0"', false)
            ->assertSee('Published Post')
            ->assertDontSee('Draft Post')
            ->assertDontSee('Future Post');
    }

    public function test_pages_declare_feed_for_autodiscovery(): void
    {
        $this->get('/')->assertSee('type="application/rss+xml"', false);
    }

    public function test_signing_in_from_a_post_returns_to_its_comments(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret-password')]);
        $post = $this->publishedPost(['slug' => 'retry-mechanisms']);

        $this->get('/login?redirect=/blog/'.$post->slug)->assertOk();

        $this->post('/login', ['email' => $user->email, 'password' => 'secret-password'])
            ->assertRedirect(url('/blog/retry-mechanisms').'#comments');
    }

    public function test_registering_from_a_post_returns_to_its_comments(): void
    {
        $post = $this->publishedPost(['slug' => 'retry-mechanisms']);

        $this->get('/register?redirect=/blog/'.$post->slug)->assertOk();

        $this->post('/register', [
            'name' => 'New Reader',
            'email' => 'new-reader@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(url('/blog/retry-mechanisms').'#comments');
    }

    public function test_unsafe_redirects_fall_back_to_home(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret-password')]);

        foreach (['//evil.example', 'https://evil.example', '/\\evil.example'] as $unsafe) {
            $this->get('/login?redirect='.urlencode($unsafe))->assertOk();

            $this->post('/login', ['email' => $user->email, 'password' => 'secret-password'])
                ->assertRedirect('/');

            $this->post('/logout');
        }
    }

    public function test_bookmark_route_no_longer_exists(): void
    {
        $user = User::factory()->create();
        $post = $this->publishedPost();

        $this->actingAs($user)->post('/blog/'.$post->id.'/bookmarks')->assertNotFound();
    }
}
