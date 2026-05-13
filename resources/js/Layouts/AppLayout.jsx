import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';
import { MapPin } from 'lucide-react';
import { ThemeToggle } from '@/Components/ThemeToggle';

function Logo() {
    return (
        <Link href="/" className="flex items-center gap-2">
            <div className="w-8 h-8 rounded-lg bg-gradient-to-br from-accent to-accent-light flex items-center justify-center flex-shrink-0">
                <span className="text-white font-bold text-sm">AS</span>
            </div>
            <div className="hidden sm:block">
                <div className="text-foreground font-semibold text-sm leading-tight">Abu Saleh</div>
                <div className="text-muted text-xs leading-tight">Senior Software Engineer</div>
            </div>
        </Link>
    );
}

function SocialLinks({ className = '', hideOnMobile = true }) {
    const linkClass = hideOnMobile
        ? 'hidden sm:flex text-muted hover:text-accent transition-colors p-2 rounded-lg hover:bg-accent/10'
        : 'flex text-muted hover:text-accent transition-colors p-2 rounded-lg hover:bg-accent/10';

    return (
        <div className={`flex items-center gap-1 ${className}`}>
            <a
                href="https://x.com/asmshaon"
                target="_blank"
                rel="noopener noreferrer"
                className={linkClass}
                aria-label="X (Twitter)"
            >
                <svg viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                </svg>
            </a>
            <a
                href="https://github.com/asmshaon"
                target="_blank"
                rel="noopener noreferrer"
                className={linkClass}
                aria-label="GitHub"
            >
                <svg viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5">
                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                </svg>
            </a>
            <a
                href="https://www.linkedin.com/in/asmshaon"
                target="_blank"
                rel="noopener noreferrer"
                className={linkClass}
                aria-label="LinkedIn"
            >
                <svg viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                </svg>
            </a>
        </div>
    );
}

export default function AppLayout({ children, title }) {
    const { auth, flash } = usePage().props;
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    return (
        <div className="min-h-screen bg-background text-foreground">
            <nav className="fixed top-0 left-0 right-0 z-50 bg-background/80 dark:bg-dark-900/80 backdrop-blur-xl border-b border-border">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between h-16 lg:h-20">
                        {/* Logo + Desktop Links */}
                        <div className="flex items-center gap-8">
                            <Logo />
                            <div className="hidden lg:flex items-center gap-8">
                                {auth?.user?.role === 'admin' && (
                                    <Link href="/admin" className="nav-link">
                                        Admin
                                    </Link>
                                )}
                            </div>
                        </div>

                        {/* Right Side */}
                        <div className="flex items-center gap-3">
                            <SocialLinks />
                            <ThemeToggle />
                            <div className="hidden sm:flex items-center gap-3">
                                {auth.user ? (
                                    <>
                                        <span className="text-sm text-muted">{auth.user.name}</span>
                                        <Link
                                            href="/logout"
                                            method="post"
                                            as="button"
                                            className="text-sm text-muted hover:text-foreground font-medium transition-colors"
                                        >
                                            Logout
                                        </Link>
                                    </>
                                ) : (
                                    <>
                                        <Link href="/login" className="nav-link">
                                            Log in
                                        </Link>
                                        <Link href="/register" className="btn-primary text-white px-5 py-2 rounded-lg text-sm font-medium">
                                            Register
                                        </Link>
                                    </>
                                )}
                            </div>
                            <button
                                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                                className="lg:hidden text-muted hover:text-foreground p-2 transition-colors"
                                aria-label="Menu"
                            >
                                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {mobileMenuOpen ? (
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                    ) : (
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                                    )}
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {/* Mobile Dropdown */}
                {mobileMenuOpen && (
                    <div className="lg:hidden fixed top-16 left-0 right-0 bg-card-bg border-t border-border px-4 py-4 space-y-1 z-40">
                        <Link href="/" className="block text-sm font-medium py-2 text-muted hover:text-foreground">
                            Home
                        </Link>
                        {auth?.user?.role === 'admin' && (
                            <Link href="/admin" className="block text-sm font-medium py-2 text-muted hover:text-foreground">
                                Admin
                            </Link>
                        )}
                        {auth.user ? (
                            <Link href="/logout" method="post" as="button" className="block w-full text-left text-sm font-medium py-2 text-muted hover:text-foreground">
                                Logout
                            </Link>
                        ) : (
                            <>
                                <Link href="/login" className="block text-sm font-medium py-2 text-muted hover:text-foreground">
                                    Login
                                </Link>
                                <Link href="/register" className="block text-sm font-medium py-2 text-muted hover:text-foreground">
                                    Register
                                </Link>
                            </>
                        )}
                    </div>
                )}
            </nav>

            <div className="pt-16 lg:pt-20">
                {flash?.success && (
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <div className="bg-green-500/10 border border-green-500/30 text-green-500 px-4 py-3 rounded-lg">
                            {flash.success}
                        </div>
                    </div>
                )}
                {flash?.error && (
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <div className="bg-red-500/10 border border-red-500/30 text-red-500 px-4 py-3 rounded-lg">
                            {flash.error}
                        </div>
                    </div>
                )}

                <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {title && (
                        <h1 className="text-3xl font-bold text-foreground mb-8">{title}</h1>
                    )}
                    {children}
                </main>
            </div>

            <footer className="border-t border-border bg-background">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div className="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div className="text-muted text-sm">
                            &copy; {new Date().getFullYear()} <strong>asmshaon</strong>. All rights reserved.
                        </div>
                        <div className="flex items-center gap-2 text-muted text-sm">
                            <MapPin className="w-4 h-4" />
                            Bangladesh, GMT+6
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
}
