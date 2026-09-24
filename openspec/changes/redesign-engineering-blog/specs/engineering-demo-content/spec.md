## Purpose

Ensures the blog's seed data presents a believable professional engineering blog grounded in the owner's real work, consistent with the owner's other sites.

## ADDED Requirements

### Requirement: Real author and engineering categories
Seeding a fresh database SHALL create the author as "Abu Saleh" (admin) and these categories: Backend, Payments, System Design, Laravel, Security and DevOps. Seed data SHALL NOT create AI, machine-learning, LLM or MLOps categories.

#### Scenario: Fresh seed
- **WHEN** the database is freshly migrated and seeded
- **THEN** the admin is named "Abu Saleh" and exactly those six categories exist

### Requirement: Posts from real work
Seeding SHALL create about eight published posts, each on a software-engineering problem the owner actually worked on, as recorded in the shareable career inventory. Each post SHALL be substantial (roughly 700–2,000 words), use headings, and include at least one code example. Clients SHALL be anonymous. No post SHALL present AI or machine-learning work as delivered experience.

#### Scenario: Seeded post quality
- **WHEN** the seeded posts are listed
- **THEN** there are about eight, each 700–2,000 words with at least one code block, none names a client, and none is about AI or machine learning

### Requirement: Seed data only
These changes SHALL apply only to seeders. No migration or deploy step SHALL delete, modify or insert posts in an existing database.

#### Scenario: Deploy does not touch content
- **WHEN** the change is deployed and its migrations run on a database with existing posts
- **THEN** existing posts keep their titles, content and status (only the new word-count column is filled in)
