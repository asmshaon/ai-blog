## Purpose

Presents the blog's posts as a calm, text-first reading list in the style of a professional engineering blog, so readers can scan titles, dates and topics quickly.

## ADDED Requirements

### Requirement: Single-column text listing
The home page SHALL list published posts, newest first, in a single reading column without featured images. Each entry SHALL show, in order:
- the publication date in monospace uppercase (for example "JUL 18, 2026") with a calendar icon
- the post title in a large serif, linking to the post
- the excerpt
- a metadata line with the approximate word count and the post's category label

#### Scenario: Listing entry content
- **WHEN** a visitor opens the home page
- **THEN** each post appears as a date line, a serif title link, an excerpt and a line such as "~2.8K words · Payments", with no post images

### Requirement: Latest post badge
The newest published post SHALL carry a "Latest post" badge next to its date, on the first page of the unfiltered listing only.

#### Scenario: Badge placement
- **WHEN** a visitor opens the first page with no search or category filter
- **THEN** only the first entry shows the "Latest post" badge

#### Scenario: No badge when filtered
- **WHEN** a visitor filters by a category or searches
- **THEN** no entry shows the "Latest post" badge

### Requirement: Approximate word count
Each post SHALL have a stored word count of its content without markup. The listing SHALL show it rounded: exact below 1,000 (for example "~716 words") and in thousands with one decimal from 1,000 up (for example "~2.8K words").

#### Scenario: Formatting
- **WHEN** posts with 716 and 2,840 words are listed
- **THEN** they show "~716 words" and "~2.8K words"

#### Scenario: Count stays current
- **WHEN** an admin edits a post's content and saves
- **THEN** its stored word count and reading time are recalculated

### Requirement: Search with keyboard shortcut
Above the list, the page SHALL offer a search field. Pressing ⌘K (macOS), Ctrl+K or "/" while not typing in another field SHALL focus it, and the shortcut hint SHALL be shown inside the field. Submitting SHALL filter posts by title, content or tag, keep the query in the URL, and show how many posts matched along with a way to clear the search.

#### Scenario: Shortcut focuses search
- **WHEN** a visitor presses "/" on the listing while no input is focused
- **THEN** the search field receives focus

#### Scenario: Searching
- **WHEN** a visitor searches for "race condition"
- **THEN** only matching posts are listed, the URL contains the query, and a "Clear search" control is shown

### Requirement: Category filter
The page SHALL show the categories that have published posts as neutral chips with post counts, plus "All". Selecting a chip SHALL filter the listing and mark the chip as selected.

#### Scenario: Filter by category
- **WHEN** a visitor selects the "Payments" chip
- **THEN** only posts in that category are listed and the chip is marked selected

### Requirement: Newer and older pagination
When there are more posts than fit on one page, the listing SHALL paginate and show "Newer posts" and "Older posts" links, plus the current page number. Filters and search SHALL be preserved across pages.

#### Scenario: Paging with a filter
- **WHEN** a visitor is on page 1 of a category with more than one page and selects "Older posts"
- **THEN** page 2 of the same category is shown

### Requirement: Empty state
When no posts match, the page SHALL say so in plain language and offer a link back to all posts.

#### Scenario: No results
- **WHEN** a search matches no posts
- **THEN** the page shows a no-results message and a link to show all posts

### Requirement: Lean listing payload
The listing SHALL NOT send full post content to the browser. Only the fields each entry displays SHALL be sent.

#### Scenario: Payload
- **WHEN** the listing page's data is inspected
- **THEN** listed posts contain no `content` field
