import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';
import { AlertCircle, CheckCircle, Menu, X as Close } from 'lucide-react';
import { ThemeToggle } from '@/Components/ThemeToggle';
import { GITHUB, LINKEDIN, MAIN_SITE, PORTFOLIO } from '@/site';

function Logo() {
    return (
        <Link href="/" className="flex items-center gap-2.5">
            <div className="w-8 h-8 rounded-md bg-accent flex items-center justify-center shrink-0">
                <span className="text-accent-contrast font-display font-semibold text-sm">AS</span>
            </div>
            <div className="leading-tight">
                <div className="font-display text-foreground font-semibold text-lg leading-tight">Abu Saleh</div>
                <div className="font-mono text-[0.625rem] uppercase tracking-wider text-muted">Engineering notes</div>
            </div>
        </Link>
    );
}

const externalLinks = [
    { label: 'Portfolio ↗', href: PORTFOLIO },
    { label: 'About ↗', href: MAIN_SITE },
];

function Flash({ type, message }) {
    if (!message) return null;
    const Icon = type === 'success' ? CheckCircle : AlertCircle;
    return (
        <div className="w-full max-w-3xl mx-auto px-4 sm:px-6 mt-6">
            <div
                role="status"
                className={`flex items-center gap-2.5 px-4 py-3 rounded-md text-sm text-foreground bg-card-bg border ${
                    type === 'success' ? 'border-accent' : 'border-dashed border-accent'
                }`}
            >
                <Icon className="w-4 h-4 shrink-0" aria-hidden="true" />
                {message}
            </div>
        </div>
    );
}

export default function AppLayout({ children, title }) {
    const { props, url } = usePage();
    const { auth, flash } = props;
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const onHome = url === '/' || url.startsWith('/?');

    return (
        <div className="min-h-screen flex flex-col bg-background text-foreground">
            <nav className="border-b border-border">
                <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex items-center gap-8 h-[4.75rem]">
                        <div className="mr-auto">
                            <Logo />
                        </div>

                        <div className="hidden md:flex items-center gap-7">
                            <Link href="/" className={`nav-link ${onHome ? 'active' : ''}`}>
                                Writing
                            </Link>
                            {externalLinks.map((link) => (
                                <a key={link.href} href={link.href} target="_blank" rel="noopener noreferrer" className="nav-link">
                                    {link.label}
                                </a>
                            ))}
                        </div>

                        <div className="flex items-center gap-3">
                            {auth.user && (
                                <div className="hidden md:flex items-center gap-3 text-sm text-muted">
                                    <span>{auth.user.name}</span>
                                    {auth.user.role === 'admin' && (
                                        <Link href="/admin" className="text-foreground border-b border-border hover:border-accent">
                                            Admin
                                        </Link>
                                    )}
                                    <Link
                                        href="/logout"
                                        method="post"
                                        as="button"
                                        className="text-foreground border-b border-border hover:border-accent"
                                    >
                                        Sign out
                                    </Link>
                                </div>
                            )}
                            <ThemeToggle />
                            <button
                                type="button"
                                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                                className="md:hidden w-9 h-9 rounded-full border border-slate-300 dark:border-dark-500 bg-card-bg flex items-center justify-center text-foreground"
                                aria-label="Menu"
                                aria-expanded={mobileMenuOpen}
                            >
                                {mobileMenuOpen ? <Close className="w-4 h-4" /> : <Menu className="w-4 h-4" />}
                            </button>
                        </div>
                    </div>
                </div>

                {mobileMenuOpen && (
                    <div className="md:hidden border-t border-border px-4 py-3 space-y-1">
                        <Link href="/" className="block font-mono text-xs uppercase tracking-wider py-2.5 text-foreground">
                            Writing
                        </Link>
                        {externalLinks.map((link) => (
                            <a
                                key={link.href}
                                href={link.href}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="block font-mono text-xs uppercase tracking-wider py-2.5 text-muted"
                            >
                                {link.label}
                            </a>
                        ))}
                        {auth.user && (
                            <div className="flex items-center gap-4 pt-2 mt-1 border-t border-border text-sm text-muted">
                                <span>{auth.user.name}</span>
                                {auth.user.role === 'admin' && (
                                    <Link href="/admin" className="py-2 text-foreground">
                                        Admin
                                    </Link>
                                )}
                                <Link href="/logout" method="post" as="button" className="py-2 text-foreground">
                                    Sign out
                                </Link>
                            </div>
                        )}
                    </div>
                )}
            </nav>

            <Flash type="success" message={flash?.success} />
            <Flash type="error" message={flash?.error} />

            <main className="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {title && <h1 className="font-display font-medium text-4xl text-foreground mb-8">{title}</h1>}
                {children}
            </main>

            <footer className="border-t border-border">
                <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row justify-between gap-3 font-mono text-xs text-muted">
                    <span>&copy; {new Date().getFullYear()} Abu Saleh · Engineering notes</span>
                    <nav aria-label="Elsewhere" className="flex flex-wrap gap-x-5 gap-y-1">
                        {[
                            ['Portfolio', PORTFOLIO],
                            ['About', MAIN_SITE],
                            ['GitHub', GITHUB],
                            ['LinkedIn', LINKEDIN],
                        ].map(([label, href]) => (
                            <a key={href} href={href} target="_blank" rel="noopener noreferrer" className="hover:text-foreground">
                                {label}
                            </a>
                        ))}
                    </nav>
                </div>
            </footer>
        </div>
    );
}
