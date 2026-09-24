## Purpose

Makes a single post comfortable to read and credible as professional engineering writing, with clear metadata, well-set technical content and a way to learn about the author.

## ADDED Requirements

### Requirement: Post header
A post page SHALL open with the monospace date, the serif title, and a metadata line with the word count, the reading time and the category (linking to the filtered listing). Tags SHALL be listed as neutral links to the tag-filtered listing. The public view count SHALL NOT be shown.

#### Scenario: Header content
- **WHEN** a visitor opens a post
- **THEN** the date, title, word count, reading time and category are shown, and no view count appears

### Requirement: Readable article typography
Post content SHALL be set in a single measure of about 65–75 characters, with styled headings, paragraphs, lists, block quotes, links, inline code and code blocks. Code blocks SHALL use the monospace face on a neutral panel, scroll horizontally inside themselves, and never widen the page.

#### Scenario: Long code line on a phone
- **WHEN** a post with a long code line is viewed at 375px wide
- **THEN** the code block scrolls horizontally on its own and the page itself does not scroll horizontally

### Requirement: Author box
After the content, the page SHALL show an author box with the author's name, a one-line description consistent with the owner's other sites ("Senior Full-Stack Software Engineer"), and links to the portfolio and the main site.

#### Scenario: Author box links
- **WHEN** a visitor reaches the end of a post
- **THEN** they see the author box with working links to the portfolio and the main site

### Requirement: Related posts as a list
Up to three related posts SHALL be shown as a text list, each with its date, title and word count. No images or cards SHALL be used.

#### Scenario: Related list
- **WHEN** a post has related posts
- **THEN** up to three appear as a list of dates and titles with word counts

### Requirement: Readable at phone width
The post page SHALL have no horizontal page scrolling at 375px in either theme.

#### Scenario: Phone width
- **WHEN** a post is viewed at 375px wide
- **THEN** no horizontal page scrolling occurs
