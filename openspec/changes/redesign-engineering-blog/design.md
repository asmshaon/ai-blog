## Context

See proposal.md for motivation and the specs for requirements. The current state that shapes the approach:

- **Stack:** Laravel 13 (PHP 8.5 locally) with Inertia v3 + React 19 (`.jsx`, no TypeScript), Vite 8 and Tailwind v4 (CSS-first `resources/css/app.css`), plus Ziggy. Feature tests run on in-memory SQLite via `php artisan test`, in `tests/Feature/BlogTest.php` (10 tests).
- **Repo state:** `main` is the deploy branch. Pushing to it deploys, runs `migrate --force` and caches config, routes and views. There are no uncommitted code changes; only `.claude/` and `openspec/` are untracked.
- **Tokens:**
  - `app.css` defines semantic tokens (`--background`, `--foreground`, `--accent`, `--accent-hover`, `--accent-light`, `--card-bg`, `--border`, `--muted`) that every page uses as `bg-card-bg`, `text-muted`, `border-border`, `text-accent` and so on.
  - It also has `dark-*`/`slate-*` scales and violet gradient classes (`btn-primary`, `hero-gradient`, `text-gradient`, `card-hover`, the nav underline, scroll progress).
  - Flash messages and form errors use `green-500`/`red-500`/`red-400` (24 usages).
- **Theme:** `app.blade.php` hard-codes `class="dark"` and an inline script that defaults to dark using the `blog-theme` localStorage key. `ThemeProvider.jsx` defaults to dark as well. Only Inter is loaded, from Google Fonts.
- **Article styling:** `Show.jsx` uses `prose` classes, but `@tailwindcss/typography` isn't installed, so article HTML is currently unstyled.
- **Listing:** `BlogController@index` paginates 9 posts with `user`, `category` and `tags` eager-loaded and sends full `content` to the client. Filters are `search`, `category` and `tag`.
- **Model:** `BlogPost` computes `reading_time` in its `creating`/`updating` hooks. Bookmarks exist only as a route, `BookmarkController`, a `Bookmark` model and relations, with no UI.
- **Auth:** Login and register redirect with `redirect()->intended(route('home'))`. Nothing sets the intended URL for a guest who clicks "Login" on a post, so they land on home.
- **Seed data:** 3 seeders. The admin is "Admin User", with 8 AI- and ML-heavy categories and 20 posts. The local DB matches the seed. The live DB's contents are unknown.

## Goals / Non-Goals

**Goals:**
- **Same look:** the same visual system as `../landing` and `../portfolio`, re-using the blog's semantic token names so the admin pages follow without being rewritten.
- **Listing:** a listing that reads like the reference screenshot: a mono date line, a serif title, the excerpt, "~N words · Category".
- **Accounts:** accounts that only exist for commenting, with a safe round-trip back to the post.
- **Tests:** every behavioural change covered by a feature test.

**Non-Goals:**
- Syntax highlighting (code blocks get monochrome styling only), a table of contents, newsletters, likes or a public view count.
- Seeding fake comments or fake readers. Invented engagement would work against "look real".
- Changing live content. Existing posts are only backfilled with `word_count`.
- Redesigning the admin UI beyond picking up the new tokens and removing chromatic utilities.
- Dropping the `bookmarks` table. Only the code path goes.

## Decisions

### 1. Keep the semantic token names and re-value them to monochrome
`app.css` keeps `--background`, `--foreground`, `--accent`, `--accent-hover`, `--accent-light`, `--card-bg`, `--border` and `--muted`, with these new values:

| Token | Light | Dark |
|---|---|---|
| background | `#fafafa` | `#0a0a0a` |
| foreground | `#111111` | `#f4f4f4` |
| accent (ink) | `#111111` | `#f4f4f4` |
| accent-hover | `#404040` | `#d4d4d4` |
| accent-light | `#737373` | `#a3a3a3` |
| card-bg | `#ffffff` | `#111111` |
| border | `#e5e5e5` | `#262626` |
| muted | `#525252` | `#a3a3a3` |

The light background is off-white `#fafafa`, as in the reference.

The `dark-*` and `slate-*` scales become the same ash scale used on the landing site, and `gray-*` is overridden to it too. A new `--accent-contrast` (white in light, `#0a0a0a` in dark) is used as `text-accent-contrast` on ink buttons. `btn-primary` becomes solid ink with inverse text and an outline hover. The gradient, glow and violet classes are deleted.
- *Alternative:* switch to the landing site's `ink`/`slate` names. Rejected: every admin page uses the semantic names, so renaming means touching 700+ lines for no visual difference.

### 2. Fonts and mono metadata
`app.blade.php` loads one Google Fonts request for:
- Inter (400–700)
- Newsreader (opsz, 400–600, including italic)
- JetBrains Mono (400–500)

`@theme` defines `--font-sans` (Inter), `--font-display` (Newsreader) and `--font-mono` (JetBrains Mono). Metadata uses `font-mono text-xs uppercase tracking-wide`, which gives the reference's "JUL 18, 2026" look.

### 3. Theme bootstrap defaults to light
The inline script in `app.blade.php` reads `blog-theme` and adds `dark` only when the stored value is `dark`. `class="dark"` is removed from `<html>`. `ThemeProvider` switches its default to `light`. The storage key stays the same, so returning visitors keep their choice.

### 4. Article typography through `@tailwindcss/typography`
Add `@tailwindcss/typography` as a dev dependency and `@plugin "@tailwindcss/typography";` in `app.css`. `Show.jsx` uses `prose prose-neutral dark:prose-invert` with overrides:
- `max-w-[68ch]`
- serif headings (`prose-headings:font-display`)
- `prose-code` as mono with no backtick pseudo-content
- `prose-pre` on `bg-card-bg border border-border` with `overflow-x-auto`
- links underlined in ink

This is the only new dependency, and it's the standard way to style Tailwind v4 prose.

### 5. Word count stored like reading time
- **Migration:** a new migration adds `word_count` (unsigned int, default 0) to `blog_posts`. Its `up()` backfills existing rows in chunks, using the same counting as the model, and changes nothing else.
- **Counting:** `BlogPost::countWords(string $html): int` is `str_word_count(strip_tags($html))`. It is used by the `creating`/`updating` hooks for both `word_count` and `reading_time`, so the two stay consistent.
- **Display:** the React helper `formatWords(n)` returns `~716 words` below 1,000 and `~2.8K words` from 1,000 up.

### 6. Listing controller changes
`BlogController@index`:
- **Payload:** keeps the filters but paginates 10 per page and maps items through `->through()` to `{id, slug, title, excerpt, published_at, word_count, category: {name, slug}}`. The eager load drops `user` and `tags`, since they aren't displayed, and the tag filter still works through `whereHas`.
- **Latest badge:** adds `showLatestBadge = page === 1 && !search && !category && !tag`.
- **Categories:** sends `categories` as categories with at least one published post, with a `withCount` of published posts, ordered by name.

Pagination renders as "← Newer posts" (the previous page URL), "Page N of M" and "Older posts →" (the next page URL), from the paginator's `prev_page_url`/`next_page_url`.

### 7. Listing UI (`Pages/Blog/Index.jsx`)
- **Column:** a `max-w-3xl` reading column.
- **Top row:**
  - a `SearchBar` with a search icon, the input and a `⌘K` hint (`Ctrl K` on non-Mac), submitting via `useForm().get('/')`
  - under them, a horizontal row of category chips with counts; the selected chip is ink-filled
- **Keyboard shortcut:** a `useEffect` listens for `keydown`. On `k` with `metaKey`/`ctrlKey`, or `/` when the target isn't an input, textarea or contenteditable, it calls `preventDefault` and focuses the input.
- **Search results line:** "N posts matching '…'" with "Clear search".
- **Entry layout:**
  - `<article>` spaced `py-10` with no border, like the reference
  - date line: a `Calendar` icon, then the date formatted `MMM D, YYYY` in uppercase (`Intl.DateTimeFormat('en-US', {month:'short', day:'numeric', year:'numeric'})`)
  - an optional "Latest post" badge: outlined and ink-coloured
  - `<h2>` as a serif link at `text-3xl sm:text-4xl`
  - the excerpt in `text-lg text-muted`
  - the meta line: `formatWords` · `CategoryLabel` (a neutral outlined chip linking to `/?category=slug`)
- **Shared components:** `PostDate`, `CategoryLabel` and `formatWords` live in `resources/js/Components/Post.jsx` and are reused by Show and the related list.

### 8. Reading page (`Pages/Blog/Show.jsx`)
- **Layout:** a `max-w-3xl` column.
- **Header:** the `PostDate`, an `h1` serif at `text-4xl sm:text-5xl`, and a mono meta line: `~2.8K words · 14 min read · Category`. Tags follow as `#tag` neutral links. The featured image is kept only if a post has one, below the header, in its natural colours, since post imagery is exempt from the palette rule.
- **Body:** the article body as in §4.
- **Author box:** a bordered box that reads "Written by Abu Saleh, Senior Full-Stack Software Engineer. I build payment, booking, point-of-sale and marketplace systems." It links to "Portfolio →" and "About me →". The URLs live as constants in `resources/js/site.js`: `https://portfolio.asmshaon.tech/` and `https://asmshaon.tech/`, the latter assumed as in the portfolio change.
- **Comments:** `id="comments"`, restyled flat with hairline separators.
- **Related:** a text list using `PostDate` + title + `formatWords`.
- **Removed:** the view count, which is still incremented server-side but no longer shown.

### 9. Accounts only for comments
- **`AppLayout` nav:**
  - brand: the "AS" ink tile, "Abu Saleh" in serif, and "Engineering notes" in mono
  - links: uppercase mono "Writing" (`/`), "Portfolio ↗" and "About ↗"
  - right side: `ThemeToggle`, and for signed-in users the name + "Admin" (admin only) + "Sign out"
  - no guest auth links
  - the mobile menu mirrors this
- **Comment prompt:** guests see a bordered prompt, "Sign in to join the discussion", with "Sign in" and "Create an account" links to `/login?redirect=/blog/{slug}` and `/register?redirect=/blog/{slug}`.
- **Safe return URL:** `LoginController@create` and `RegisteredUserController@create` call a small helper, `App\Support\SafeRedirect::fromRequest($request)`. It accepts the value only if it:
  - starts with a single `/`
  - does not start with `//` or `/\`
  - has no scheme or host according to `parse_url`
  - is at most 255 characters

  If it's valid, the helper stores `url($path).'#comments'` as `url.intended`. The existing `redirect()->intended(route('home'))` then does the rest. The login and register pages carry the query string across when a reader switches between them.
- **Bookmarks:**
  - delete `BookmarkController` and its route
  - delete the `bookmarks()` relations on `BlogPost` and `User`, and the `Bookmark` model, if nothing else references it
  - keep the migration and table

### 10. Feed
- **Route and controller:** `Route::get('/feed.xml', FeedController::class)->name('feed')`. The invokable `FeedController` renders `resources/views/feed.blade.php`, an RSS 2.0 view with `<atom:link rel="self">`, from the latest 20 published posts with `category`, and returns `application/rss+xml; charset=UTF-8`.
- **Output:** titles and excerpts are escaped with `{{ }}`, and dates use `toRssString()`.
- **Discovery:** there is no visible RSS link anywhere (owner's request). `app.blade.php` adds `<link rel="alternate" type="application/rss+xml" title="Abu Saleh — Engineering notes" href="{{ route('feed') }}">`.

### 11. Seed content
- **`UserSeeder`:** the admin becomes "Abu Saleh", with an `example.com` email kept for local only. The reader user stays.
- **`CategorySeeder`:** Backend, Payments, System Design, Laravel, Security and DevOps, with one-line descriptions.
- **`BlogPostSeeder`:** eight posts, each a `content*()` method returning HTML with `<h2>`, paragraphs, lists and `<pre><code>` examples (PHP/Laravel, SQL, Go). Every post is written from the shareable inventory, with clients anonymized, and has fixed past `published_at` dates, newest first:

| # | Title | Category | Source in inventory | Date |
|---|---|---|---|---|
| 1 | Never Let the App Set the Price | Payments | Gourmeal server-side pricing, integer cents, idempotent Stripe calls | 2026-09-10 |
| 2 | Alert on Silence: Catching Queues That Fail Quietly | DevOps | Tour retailer queue alerts, the four-hour no-completion alert | 2026-06-18 |
| 3 | Login Lockouts in Laravel That Actually Slow Attackers Down | Laravel | Gourmeal 5-attempt/5-minute lockout; tour retailer IP blocking | 2026-03-27 |
| 4 | Swap, Don't Update: Refreshing Supplier Data Without Half-Updated Pages | System Design | Tour retailer backup → temp tables → rename; index rebuilt in a copy | 2025-11-12 |
| 5 | The Double Spend a Penetration Test Found in Our Wallet | Security | E-wallet race condition, atomic transfers | 2025-07-02 |
| 6 | Reporting Every Sale Exactly Once | Backend | Regulated-retail compliance reporting, business-hours guard | 2025-02-19 |
| 7 | One Booking API in Front of Ten Suppliers | System Design | Car-rental supplier normalization, error mapping | 2024-10-08 |
| 8 | Replacing a Legacy Booking Engine Without a Big-Bang Cutover | Backend | Car-rental historical import, bridge to the old engine | 2024-05-14 |

Tags are 3–4 per post (for example Idempotency, Stripe, Race Conditions, Queues, MySQL, Rate Limiting). The seeders only run on demand (`db:seed`). Deploys never run them.

### 12. Admin and auth pages
Admin and auth pages pick up the new tokens automatically. Remaining `green-*`/`red-*` utilities become monochrome:
- errors: `text-foreground` with an `AlertCircle` icon and a dashed border
- success: ink border with a `CheckCircle` icon

The Login and Register pages get the same serif heading and field styling as the site, plus a line explaining that an account is only needed to comment.

## Risks / Trade-offs

- [The live database may still hold the old AI demo posts] → This change can't safely touch live content. Flagged in Open Questions, and handled by the owner through the admin panel or a deliberate re-seed.
- [Assumed main-site URL for "About ↗" and the author box] → It's one constant in `resources/js/site.js`.
- [The Ctrl+K shortcut conflicts with the browser's own search shortcut in some browsers] → `preventDefault` applies only while the listing page is mounted, and "/" is also offered.
- [The backfill migration runs on deploy] → It only writes `word_count`, in chunks. `down()` drops the column.
- [Removing the `Bookmark` model could break something that references it] → Task 5.3 greps for references before deleting and keeps the table.

## Open Questions

- Does the live blog contain the old AI demo posts? If so, the owner decides whether to unpublish them in the admin panel or re-seed production. This doesn't change the specs or the tasks.
