## Purpose

Gives the blog the same calm black, white and ash identity as the owner's landing and portfolio sites, light by default with a dark alternative, so all three sites read as one brand.

## ADDED Requirements

### Requirement: Monochrome palette
Every page (public, auth and admin) SHALL use only black, white and neutral ash greys for backgrounds, text, borders, buttons, links, icons, focus rings, badges, flash messages and form errors. The site SHALL NOT use chromatic accent colors, colored gradients or glow effects. Images inside post content are exempt.

#### Scenario: No chromatic UI color
- **WHEN** the computed text, background, border and fill colors of the listing, a post, the login page and the admin post list are inspected in either theme
- **THEN** every color is a neutral grey, black or white

#### Scenario: Monochrome feedback messages
- **WHEN** a success flash or a validation error is shown
- **THEN** it is distinguished by an icon, wording and border weight rather than by green or red color

### Requirement: Light theme by default, dark available
A first-time visitor with no stored theme preference SHALL see the light theme without a flash of the dark theme. The theme toggle SHALL switch between light and dark, and the choice SHALL persist across reloads.

#### Scenario: First visit
- **WHEN** a visitor with no stored preference opens any page
- **THEN** the page renders in the light theme from the first paint

#### Scenario: Toggle persists
- **WHEN** the visitor switches to dark and reloads
- **THEN** the page renders in the dark theme

### Requirement: Shared typography
Headings and post titles SHALL use the Newsreader serif. Body text SHALL use Inter. Dates, word counts and other metadata SHALL use a monospace face.

#### Scenario: Fonts in the listing
- **WHEN** a listing entry's title, excerpt and date are inspected
- **THEN** they resolve to Newsreader, Inter and the monospace face respectively

### Requirement: Legible contrast
Body and muted metadata text SHALL have a contrast ratio of at least 4.5:1 against their background in both themes. Large titles SHALL be at least 3:1.

#### Scenario: Muted metadata contrast
- **WHEN** dates, word counts and category labels are measured in either theme
- **THEN** each has a contrast ratio of at least 4.5:1
