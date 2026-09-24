## Why

The blog (blog.asmshaon.tech) is the third of the owner's public sites. The landing and portfolio sites were just redesigned into one black, white and ash brand aimed at recruiters and business readers. The blog still looks different and doesn't read like a working engineer's blog:
- **Look:** it keeps the old violet gradients.
- **Post list:** the posts are image cards in a three-column grid.
- **Accounts:** the nav pushes Register and Log in.
- **Demo content:** the seeded posts are mostly about AI and machine learning, which contradicts the rule on the other sites that AI is only something the owner is studying.

The owner wants the blog to feel like a real professional engineering blog. The post list should follow a text-first, single-column layout (reference screenshot: dated entries with a serif title, excerpt, word count and topic). Accounts should exist only so readers can comment.

## What Changes

- **Brand theme:** the blog moves to the same monochrome palette, the same Newsreader + Inter type and the same light-by-default theme as the landing and portfolio sites. A monospace face is added for dates and metadata, as in the reference. Violet, gradients and green or red flash colours are removed.
- **Post listing (new layout):** a single reading column replaces the card grid. Each entry shows a monospace date with a calendar icon, a "Latest post" badge on the newest post, a large serif title, the excerpt, and an approximate word count ("~2.8K words") with a neutral category label. Above the list: a search field with a ⌘K / Ctrl+K and "/" shortcut, and category filter chips. There is no visible RSS button. Pagination becomes "Newer posts / Older posts". There are no featured images in the list.
- **Reading page:**
  - a restyled article with proper typography for headings, lists, quotes and code blocks
  - a clear header (date, words, reading time, category, tags)
  - an author box that links to the portfolio and the main site
  - related posts as a text list
  - the public view count is no longer shown
- **Accounts only for comments:**
  - Register and Log in are removed from the nav. They appear only as a "Sign in to join the discussion" prompt in each post's comments.
  - After signing in or registering from that prompt, the reader returns to the same post's comments.
  - A signed-in reader sees their name and a sign-out link, and an admin also sees an Admin link.
  - **BREAKING:** the bookmarks feature (a route and controller with no interface) is removed. The table is left in place.
- **RSS feed (new):** `/feed.xml` with the latest published posts. Feed readers find it through the autodiscovery tag in the page head. At the owner's request, the site shows no visible RSS link or button.
- **Word count:** posts store a `word_count` alongside `reading_time`, computed on save and backfilled for existing posts by a migration.
- **Demo content:**
  - The seeders are rewritten. The author is "Abu Saleh", and the categories are engineering topics (Backend, Payments, System Design, Laravel, Security, DevOps).
  - About 8 posts are drawn from problems the owner actually solved. Clients stay anonymous and nothing is about AI.
  - This affects seed data only, never live content.

## Capabilities

### New Capabilities
- `brand-visual-theme`: the monochrome palette, the typefaces (serif, sans and monospace), light as the default with dark available, and legibility across public, auth and admin pages.
- `post-listing`: the text-first listing layout, the latest-post badge, word counts, search with its keyboard shortcut, category filters, pagination and the empty state.
- `post-reading`: the article page layout, typography including code blocks, the post metadata, the author box, related posts, and no public view count.
- `comment-only-accounts`: accounts used only for commenting, the sign-in prompt that returns the reader to the post, the reduced nav, and the removal of bookmarks.
- `rss-feed`: the RSS feed and its autodiscovery tag, with no visible RSS link.
- `engineering-demo-content`: seed data that presents a real engineering blog from the owner's own work, with no AI topics.

### Modified Capabilities
(none, since the project has no specs yet)

## Impact

- **Frontend:**
  - `resources/css/app.css` (tokens and typography)
  - `resources/views/app.blade.php` (fonts, theme bootstrap, feed link)
  - `Layouts/AppLayout.jsx`, `Pages/Blog/Index.jsx`, `Pages/Blog/Show.jsx`, `Pages/Auth/Login.jsx`, `Pages/Auth/Register.jsx`, `Providers/ThemeProvider.jsx`, and a light pass over the `Pages/Admin/*` colours
  - new small components (PostMeta, CategoryLabel, SearchBar)
- **Backend:**
  - `BlogController` (latest-post flag, category list with counts, no `content` in the listing payload)
  - `LoginController` / `RegisteredUserController` (safe return URL)
  - a new `FeedController` and `feed` view
  - `BlogPost` (`word_count`)
  - `routes/web.php` (feed added, bookmarks removed)
  - a new migration adding `word_count`
  - `BookmarkController` deleted
- **Seeders:** `UserSeeder`, `CategorySeeder` and `BlogPostSeeder` are rewritten.
- **Tests:** `tests/Feature/BlogTest.php` is extended (feed, return-after-login, bookmarks gone, word count).
- **Dependencies:** `@tailwindcss/typography` (dev) for article typography. Nothing else.
- **Production data:** not touched by this change. If the live database was seeded with the old AI posts, they stay until they are unpublished or re-seeded; see design Open Questions.
- **Deployment:** pushing to `main` deploys and runs migrations automatically.
