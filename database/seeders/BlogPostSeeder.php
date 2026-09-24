<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Demo posts drawn from problems the author actually worked on (shareable
 * career inventory). Clients are anonymous; nothing here is about AI or ML.
 * Post bodies live in database/seeders/posts/*.html.
 */
class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $categories = Category::all();

        if (! $admin || $categories->isEmpty()) {
            return;
        }

        $cat = fn (string $slug) => $categories->firstWhere('slug', $slug)?->id;

        $posts = [
            [
                'file' => 'never-let-the-app-set-the-price',
                'title' => 'Never Let the App Set the Price',
                'excerpt' => 'A food-ordering app was letting the phone decide part of the price. Here is how we moved pricing to the server, kept every amount in cents, and made payment calls safe to retry.',
                'category' => 'payments',
                'published_at' => '2026-09-10 09:00:00',
                'tags' => ['Idempotency', 'Stripe', 'API Design', 'Money'],
            ],
            [
                'file' => 'alert-on-silence',
                'title' => 'Alert on Silence: Catching Queues That Fail Quietly',
                'excerpt' => 'Failed jobs are easy to alert on. Jobs that simply stop running are not. A small heartbeat check that caught stale content before customers did.',
                'category' => 'devops',
                'published_at' => '2026-06-18 09:00:00',
                'tags' => ['Queues', 'Monitoring', 'Laravel', 'Reliability'],
            ],
            [
                'file' => 'login-lockouts-in-laravel',
                'title' => 'Login Lockouts in Laravel That Actually Slow Attackers Down',
                'excerpt' => 'A sliding five-minute lockout, per-IP blocking with crawler allow-lists, and the session edge cases that make naive rate limits useless.',
                'category' => 'laravel',
                'published_at' => '2026-03-27 09:00:00',
                'tags' => ['Rate Limiting', 'Authentication', 'Security', 'Laravel'],
            ],
            [
                'file' => 'swap-dont-update',
                'title' => "Swap, Don't Update: Refreshing Supplier Data Without Half-Updated Pages",
                'excerpt' => 'Seven tour operators, one catalogue, and a daily import that could leave the site half-written. Loading to the side and renaming tables into place fixed it.',
                'category' => 'system-design',
                'published_at' => '2025-11-12 09:00:00',
                'tags' => ['Data Pipelines', 'MySQL', 'Integrations', 'Queues'],
            ],
            [
                'file' => 'double-spend-penetration-test',
                'title' => 'The Double Spend a Penetration Test Found in Our Wallet',
                'excerpt' => 'Two requests, one balance, and a window of a few milliseconds. How we made every transfer all-or-nothing and rejected bad requests before touching money.',
                'category' => 'security',
                'published_at' => '2025-07-02 09:00:00',
                'tags' => ['Race Conditions', 'Transactions', 'Fintech', 'Security'],
            ],
            [
                'file' => 'reporting-every-sale-exactly-once',
                'title' => 'Reporting Every Sale Exactly Once',
                'excerpt' => 'Regulated retail has to report each sale to a state system, once, and only for tracked items. What "exactly once" meant in practice.',
                'category' => 'backend',
                'published_at' => '2025-02-19 09:00:00',
                'tags' => ['Compliance', 'Point of Sale', 'Idempotency', 'Multi-tenant'],
            ],
            [
                'file' => 'one-booking-api-ten-suppliers',
                'title' => 'One Booking API in Front of Ten Suppliers',
                'excerpt' => 'Every rental company had its own rules for extras, mileage and errors. One booking interface hid the differences from the website and its partners.',
                'category' => 'system-design',
                'published_at' => '2024-10-08 09:00:00',
                'tags' => ['Integrations', 'API Design', 'Adapters', 'Travel'],
            ],
            [
                'file' => 'replacing-a-legacy-booking-engine',
                'title' => 'Replacing a Legacy Booking Engine Without a Big-Bang Cutover',
                'excerpt' => 'Importing years of bookings, bridging a few endpoints to the old engine, and switching it off only when nothing needed it any more.',
                'category' => 'backend',
                'published_at' => '2024-05-14 09:00:00',
                'tags' => ['Legacy Migration', 'Strangler Pattern', 'Laravel', 'Travel'],
            ],
        ];

        foreach ($posts as $data) {
            $post = BlogPost::create([
                'user_id' => $admin->id,
                'category_id' => $cat($data['category']),
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'excerpt' => $data['excerpt'],
                'content' => file_get_contents(__DIR__.'/posts/'.$data['file'].'.html'),
                'seo_description' => $data['excerpt'],
                'status' => 'published',
                'published_at' => Carbon::parse($data['published_at']),
            ]);

            $tagIds = [];
            foreach ($data['tags'] as $tagName) {
                $tagIds[] = Tag::firstOrCreate(['slug' => Str::slug($tagName)], ['name' => $tagName])->id;
            }
            $post->tags()->sync($tagIds);
        }
    }
}
