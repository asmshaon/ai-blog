## Purpose

Keeps reader accounts to a single purpose, joining the discussion on a post, so the blog reads as a publication rather than an app that asks visitors to sign up.

## ADDED Requirements

### Requirement: No sign-up prompts in site chrome
The navigation and footer SHALL NOT show Register or Log in links to guests. A signed-in reader SHALL see their name and a "Sign out" control. A signed-in admin SHALL also see an "Admin" link.

#### Scenario: Guest navigation
- **WHEN** a guest views any public page
- **THEN** the navigation shows no Register or Log in links

#### Scenario: Admin navigation
- **WHEN** an admin is signed in
- **THEN** the navigation shows their name, "Admin" and "Sign out"

### Requirement: Sign-in prompt in comments
For guests, each post's comment section SHALL show a short prompt, "Sign in to join the discussion", with links to sign in and to create an account. The comment form SHALL be shown only to signed-in readers. Existing comments SHALL be readable by everyone.

#### Scenario: Guest sees prompt
- **WHEN** a guest scrolls to a post's comments
- **THEN** existing comments are visible, no comment form is shown, and sign-in and create-account links are offered

### Requirement: Return to the discussion
Signing in or registering from a post's comment prompt SHALL bring the reader back to that post's comments section. The return address SHALL be accepted only if it is a path on the same site. Any other value SHALL fall back to the home page.

#### Scenario: Sign in from a post
- **WHEN** a guest follows "Sign in" from the post "retry-mechanisms" and signs in successfully
- **THEN** they land on that post at its comments section

#### Scenario: Register from a post
- **WHEN** a guest follows "Create an account" from a post and registers successfully
- **THEN** they land on that post at its comments section

#### Scenario: Unsafe return address
- **WHEN** the sign-in page is opened with a return address pointing to another site
- **THEN** a successful sign-in lands on the home page instead

### Requirement: Commenting rules unchanged
Signed-in readers SHALL be able to post comments and replies, and delete their own. Admins SHALL be able to delete any comment. Guests SHALL NOT be able to post.

#### Scenario: Guest cannot post
- **WHEN** a guest submits a comment request directly
- **THEN** the comment is rejected and not stored

### Requirement: Bookmarks removed
The site SHALL NOT offer bookmarking. The bookmark route SHALL no longer exist.

#### Scenario: Bookmark route gone
- **WHEN** a signed-in reader sends a request to the former bookmark route
- **THEN** the site responds with not found
