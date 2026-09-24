## 1. Setup

- [x] 1.1 Create and switch to branch `redesign-engineering-blog` from `main`. Verify with `git branch --show-current`.
- [x] 1.2 Record the baseline: run `php artisan test` and `npm run build`, and note that all 10 tests pass before any change. Verify that both commands succeed.

## 2. Theme, fonts and typography

- [x] 2.1 Rewrite the token block in `resources/css/app.css` (design §1):
  - monochrome values for the semantic tokens in `:root` and `.dark`
  - the ash `dark-*`/`slate-*`/`gray-*` scales
  - `--accent-contrast`
  - `--font-display` and `--font-mono`
  - `btn-primary` as solid ink
  - the gradient, glow and violet classes deleted
  - the scroll-progress bar, nav underline, scrollbar and selection in ink

  Verify that `grep -nE '#7c3aed|#a78bfa|#6d28d9|rgba\(124|linear-gradient' resources/css/app.css` returns nothing.
- [x] 2.2 Install `@tailwindcss/typography` as a dev dependency and add `@plugin "@tailwindcss/typography";` to `app.css`. Verify that `npm run build` passes and the built CSS contains `.prose`.
- [x] 2.3 Update `resources/views/app.blade.php`:
  - one Google Fonts link for Inter, Newsreader (opsz and italic) and JetBrains Mono
  - `class="dark"` removed from `<html>`
  - an inline script that adds `dark` only when `blog-theme` is `dark`
  - the RSS autodiscovery link (added in 4.2)

  In `ThemeProvider.jsx`, default to `light`. Verify in a private window that the first paint is light, and that choosing dark persists across a reload.

## 3. Word count

- [x] 3.1 Add a migration for `blog_posts.word_count` (unsigned int, default 0). Backfill existing rows in chunks in `up()`, and drop the column in `down()`. Add `BlogPost::countWords()` and use it in the `creating`/`updating` hooks for both `word_count` and `reading_time`. Verify that `php artisan migrate` succeeds locally and every local post has `word_count > 0`.
- [x] 3.2 Add feature tests: creating a post stores `word_count`, and updating its content recalculates `word_count` and `reading_time`. Verify with `php artisan test --filter=word`.

## 4. Backend behaviour

- [x] 4.1 Update `BlogController@index` (design §6):
  - 10 per page
  - `->through()` mapping without `content`
  - eager load only `category`
  - the `showLatestBadge` prop
  - `categories` with published-post counts, only categories that have posts

  Add feature tests (Inertia assertions): listed posts have no `content`, the badge prop is true on page 1 unfiltered and false with `?search=` or `?category=`, and category counts are correct. Verify that the tests pass.
- [x] 4.2 Add an invokable `FeedController`, `resources/views/feed.blade.php` (RSS 2.0 with `atom:link` self, the 20 latest published posts) and the `feed` route. Add a test asserting the XML content type, that a published post is present, and that a draft and a future-dated post are absent. Verify that the test passes.
- [x] 4.3 Add `App\Support\SafeRedirect` and call it from `LoginController@create` and `RegisteredUserController@create` to set `url.intended` to `<path>#comments` for valid local paths. Add tests for three cases:
  - signing in via `/login?redirect=/blog/{slug}` lands on `/blog/{slug}#comments`
  - registering via `/register?redirect=/blog/{slug}` does the same
  - `?redirect=//evil.example` and `?redirect=https://evil.example` land on home

  Verify that the tests pass.

## 5. Accounts only for comments

- [x] 5.1 Rewrite `Layouts/AppLayout.jsx` (design §9):
  - the brand block
  - the uppercase mono links Writing, Portfolio ↗ and About ↗, using constants from a new `resources/js/site.js`
  - the theme toggle
  - for signed-in users only: name, Admin (admin only) and Sign out
  - no guest Log in/Register links
  - a matching mobile menu
  - monochrome flash messages with icons
  - a mono footer line

  Verify as a guest that no Log in/Register link and no RSS link appear in the nav, mobile menu or footer.
- [x] 5.2 In `Show.jsx`, replace the guest comment line with the "Sign in to join the discussion" prompt, linking to `/login?redirect=/blog/{slug}` and `/register?redirect=/blog/{slug}`, and give the comments section `id="comments"`. Make the Login and Register pages keep the `redirect` query when linking to each other. Verify manually that signing in from a post returns to its comments.
- [x] 5.3 Remove bookmarks: the route, `BookmarkController`, the `bookmarks()` relations on `BlogPost` and `User`, and the `Bookmark` model, once `grep -rn "Bookmark" app routes resources tests` shows no other references. Keep the migration. Add a test that `POST /blog/{id}/bookmarks` returns 404 for a signed-in user. Verify that `php artisan test` passes.

## 6. Pages

- [x] 6.1 Create `resources/js/Components/Post.jsx` with `PostDate`, `CategoryLabel` and `formatWords`. Verify that `formatWords(716)` returns `~716 words` and `formatWords(2840)` returns `~2.8K words`, with a quick node check.
- [x] 6.2 Create `resources/js/Components/SearchBar.jsx` with a search icon, input, `⌘K`/`Ctrl K` hint and the keydown handler for ⌘K, Ctrl+K and "/" (ignored while typing in a field). Verify in the browser that "/" and Ctrl+K focus the input and that typing "/" inside the comment box doesn't.
- [x] 6.3 Rewrite `Pages/Blog/Index.jsx` (design §7): the search row (no RSS button), category chips with counts, the result line with "Clear search", entries (date + Latest badge, serif title, excerpt, words · category), the empty state, and Newer/Older pagination with "Page N of M". Verify with the seeded data at 375px and 1280px in both themes against the reference screenshot's structure.
- [x] 6.4 Rewrite `Pages/Blog/Show.jsx` (design §8): header without the view count, `prose` body with the monochrome overrides, the author box, flat comments, and related posts as a list. Verify that a post with a long code line doesn't cause page-level horizontal scroll at 375px.
- [x] 6.5 Restyle `Pages/Auth/Login.jsx` and `Register.jsx` (serif heading, flat fields, "You only need an account to comment." line), and replace the `green-*`/`red-*` utilities across `resources/js` with monochrome equivalents (design §12). Verify that `grep -rnE '(green|red|blue|purple|violet|amber|yellow|indigo|emerald|pink|cyan)-[0-9]' resources/js` returns nothing, and that the admin post list and editor stay legible in both themes.

## 7. Demo content

- [x] 7.1 Rewrite `UserSeeder` (admin "Abu Saleh") and `CategorySeeder` (Backend, Payments, System Design, Laravel, Security, DevOps). Verify with `php artisan migrate:fresh --seed` on a local database (after confirming the local DB holds nothing worth keeping) that the admin name and categories match the spec.
- [x] 7.2 Rewrite `BlogPostSeeder` with the eight posts in design §11. Each is 700–2,000 words of HTML with `<h2>` sections and at least one `<pre><code>` example, drawn from the shareable inventory, with no client names and no AI or ML topics. Verify with a tinker check that there are 8 published posts, every `word_count` is between 700 and 2,000, every post contains `<pre>`, and a grep of the seeder for "AI", "LLM", "machine learning" and known client or supplier names finds nothing.

## 8. Verification

- [x] 8.1 Run `./vendor/bin/pint --test` (fix with `pint` if needed), `php artisan test` and `npm run build`. All pass.
- [x] 8.2 In the browser (`composer dev`), in light and dark at 375px and 1280px:
  - listing, post, login, register and the admin post list all show no chromatic UI in a computed-colour scan
  - muted text meets 4.5:1 contrast
  - titles use Newsreader and dates use JetBrains Mono
  - no horizontal page scroll
  - `/feed.xml` loads
- [x] 8.3 Run `openspec validate redesign-engineering-blog --strict`. It passes.
