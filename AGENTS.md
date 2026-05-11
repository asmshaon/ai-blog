# AGENTS.md

## Quick Start

One-command setup (creates `.env`, generates key, runs migrations, installs and builds frontend assets):

```bash
composer setup
```

## Development

Run the full local stack (PHP dev server, queue worker, log tail, Vite HMR) concurrently:

```bash
composer dev
```

Do **not** run `php artisan serve` alone — Vite dev server and the queue worker are expected to be running too.

## Testing

Tests always run against an in-memory SQLite database regardless of `.env`:

```bash
php artisan test
# or
composer test
```

No MySQL test database or direct `phpunit` invocation is required.

## Environment & Database

- `.env.example` defaults to `DB_CONNECTION=sqlite`, but the committed `.env` uses **MySQL**.
- `phpunit.xml` hard-codes `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`.
- If you recreate `.env` from the example, the app will switch to SQLite.

## Code Style

Laravel Pint is installed with default rules:

```bash
./vendor/bin/pint
```

There is no `pint.json` — do not create one unless explicitly asked.

## Build & Deploy

- Frontend build: `npm run build` (Vite + Tailwind CSS v4).
- Push to `main` triggers automatic deployment via `.github/workflows/deploy.yml` to `/var/www/blog` over SSH.
- Deployment runs migrations with `--force`, clears and recaches config/routes/views, and reloads `php8.5-fpm`.

## Stack Notes

- Laravel 13.x (requires PHP ^8.3).
- Tailwind CSS v4 via `@tailwindcss/vite` plugin.
- Queue, session, and cache drivers are all set to `database` in `.env`.
