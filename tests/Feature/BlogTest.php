<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_guest_can_view_published_posts(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        BlogPost::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_guest_can_view_single_post(): void
    {
        $user = User::factory()->create();
        $post = BlogPost::factory()->create([
            'user_id' => $user->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('blog.show', $post->slug));
        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_reader_cannot_access_admin(): void
    {
        $user = User::factory()->create(['role' => 'reader']);
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_authenticated_user_can_comment(): void
    {
        $user = User::factory()->create();
        $post = BlogPost::factory()->create([
            'user_id' => $user->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->actingAs($user)->post(route('comments.store', $post->id), [
            'body' => 'Great post!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', ['body' => 'Great post!']);
    }

    public function test_guest_cannot_comment(): void
    {
        $user = User::factory()->create();
        $post = BlogPost::factory()->create([
            'user_id' => $user->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->post(route('comments.store', $post->id), [
            'body' => 'Great post!',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_sitemap_returns_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200)->assertHeader('Content-Type', 'application/xml');
    }
}
