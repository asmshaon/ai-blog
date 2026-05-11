<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Blog') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

        <script>
            (function() {
                const stored = localStorage.getItem('blog-theme');
                const theme = stored || 'dark';
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();

            function toggleTheme() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('blog-theme', isDark ? 'dark' : 'light');
                updateThemeIcon();
            }

            function updateThemeIcon() {
                const isDark = document.documentElement.classList.contains('dark');
                document.getElementById('theme-icon-sun').classList.toggle('hidden', !isDark);
                document.getElementById('theme-icon-moon').classList.toggle('hidden', isDark);
                const sunMobile = document.getElementById('theme-icon-sun-mobile');
                const moonMobile = document.getElementById('theme-icon-moon-mobile');
                if (sunMobile) sunMobile.classList.toggle('hidden', !isDark);
                if (moonMobile) moonMobile.classList.toggle('hidden', isDark);
            }

            document.addEventListener('DOMContentLoaded', updateThemeIcon);
        </script>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; background: #050507; color: #f8fafc; margin: 0; }
                a { text-decoration: none; }
            </style>
        @endif
    </head>
    <body class="bg-dark-900 text-foreground min-h-screen">
        <nav class="fixed top-0 left-0 right-0 z-50 bg-background/80 dark:bg-dark-900/80 backdrop-blur-xl border-b border-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-accent to-accent-light flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">AS</span>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-foreground font-semibold text-sm leading-tight">Abu Saleh</div>
                            <div class="text-muted text-xs leading-tight">Senior Software Engineer</div>
                        </div>
                    </a>

                    <!-- Right Side -->
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1">
                            <a href="https://x.com/asmshaon" target="_blank" rel="noopener noreferrer" class="hidden sm:flex text-muted hover:text-accent transition-colors p-2 rounded-lg hover:bg-accent/10" aria-label="X (Twitter)">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <a href="https://github.com/asmshaon" target="_blank" rel="noopener noreferrer" class="hidden sm:flex text-muted hover:text-accent transition-colors p-2 rounded-lg hover:bg-accent/10" aria-label="GitHub">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </a>
                            <a href="https://www.linkedin.com/in/asmshaon" target="_blank" rel="noopener noreferrer" class="hidden sm:flex text-muted hover:text-accent transition-colors p-2 rounded-lg hover:bg-accent/10" aria-label="LinkedIn">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        </div>
                        <button onclick="toggleTheme()" class="text-muted hover:text-foreground transition-colors p-2 rounded-lg hover:bg-accent/10" aria-label="Toggle theme">
                            <svg id="theme-icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <svg id="theme-icon-moon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="nav-link hidden sm:flex">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="nav-link hidden sm:flex">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="hidden sm:inline-flex btn-primary text-white px-5 py-2 rounded-lg text-sm font-medium">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <main class="pt-16 lg:pt-20">
            <section class="hero-gradient relative min-h-[80vh] flex items-center justify-center overflow-hidden">
                <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-accent/20 rounded-full blur-[128px] pointer-events-none"></div>
                <div class="absolute bottom-0 left-1/4 w-64 h-64 bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10 text-center">
                    <div class="inline-flex items-center gap-2 badge-glow rounded-full px-4 py-1.5 mb-8">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        <span class="text-green-400 text-xs font-semibold uppercase tracking-wider">Now Live</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-[1.1] tracking-tight mb-6">
                        Welcome to <span class="text-gradient">Blog</span>
                    </h1>

                    <p class="text-slate-400 text-base lg:text-lg leading-relaxed max-w-2xl mx-auto mb-10">
                        A modern, fast, and beautifully designed blog platform built with Laravel and React.
                        Share your stories, ideas, and insights with the world.
                    </p>

                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('login') }}" class="btn-primary inline-flex items-center gap-2 text-white px-6 py-3 rounded-xl text-sm font-semibold">
                            Get Started
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="/" class="btn-outline inline-flex items-center gap-2 text-white px-6 py-3 rounded-xl text-sm font-semibold">
                            Read Articles
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-background">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="value-card p-8 rounded-2xl">
                            <div class="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-accent-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-foreground mb-2">Lightning Fast</h3>
                            <p class="text-muted leading-relaxed">Built with Laravel and modern frontend tooling for blazing fast performance.</p>
                        </div>
                        <div class="value-card p-8 rounded-2xl">
                            <div class="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-accent-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-foreground mb-2">Fully Customizable</h3>
                            <p class="text-muted leading-relaxed">Easily manage posts, categories, tags, and SEO settings from the admin panel.</p>
                        </div>
                        <div class="value-card p-8 rounded-2xl">
                            <div class="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-accent-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-foreground mb-2">Secure & Reliable</h3>
                            <p class="text-muted leading-relaxed">Built on Laravel's robust foundation with authentication and authorization.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-border bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-accent to-accent-light flex items-center justify-center">
                            <span class="text-white font-bold text-sm">AS</span>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-foreground font-semibold text-sm leading-tight">Abu Saleh</div>
                            <div class="text-muted text-xs leading-tight">Senior Software Engineer</div>
                        </div>
                    </div>
                    <p class="text-center text-sm text-muted">
                        &copy; {{ date('Y') }} All rights reserved.
                    </p>
                    <div class="flex items-center gap-1">
                        <a href="https://x.com/asmshaon" target="_blank" rel="noopener noreferrer" class="text-muted hover:text-accent transition-colors p-2 rounded-lg hover:bg-accent/10" aria-label="X (Twitter)">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://github.com/asmshaon" target="_blank" rel="noopener noreferrer" class="text-muted hover:text-accent transition-colors p-2 rounded-lg hover:bg-accent/10" aria-label="GitHub">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        </a>
                        <a href="https://www.linkedin.com/in/asmshaon" target="_blank" rel="noopener noreferrer" class="text-muted hover:text-accent transition-colors p-2 rounded-lg hover:bg-accent/10" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
