## Purpose

Lets readers and feed readers follow the blog, as any real engineering blog allows.

## ADDED Requirements

### Requirement: RSS feed
The site SHALL serve an RSS 2.0 feed at `/feed.xml` with the 20 most recent published posts. Each item SHALL include the title, absolute link, publication date, category and excerpt. Unpublished or future-dated posts SHALL NOT appear.

#### Scenario: Feed content
- **WHEN** a client requests `/feed.xml`
- **THEN** it receives valid RSS 2.0 XML with an XML content type, listing only published posts, newest first

### Requirement: Feed discovery
Every public page SHALL declare the feed in its head for autodiscovery. The visible page (navigation, listing and footer) SHALL NOT show an RSS link or button.

#### Scenario: Autodiscovery
- **WHEN** a page's head is inspected
- **THEN** it contains an alternate link of type RSS pointing to `/feed.xml`

#### Scenario: No visible RSS link
- **WHEN** the navigation, listing and footer are inspected
- **THEN** none of them shows an RSS link or button
