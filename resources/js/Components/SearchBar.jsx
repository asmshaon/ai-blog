import { Search } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';

function isTypingTarget(el) {
    if (!el) return false;
    const tag = el.tagName;
    return tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT' || el.isContentEditable;
}

// Search field focused by ⌘K / Ctrl+K, or "/" when the reader isn't typing elsewhere.
export default function SearchBar({ value, onChange, onSubmit }) {
    const inputRef = useRef(null);
    const [isMac] = useState(() => typeof navigator !== 'undefined' && /Mac|iPhone|iPad/.test(navigator.platform));

    useEffect(() => {
        const onKeyDown = (e) => {
            const commandK = (e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k';
            const slash = e.key === '/' && !isTypingTarget(document.activeElement);
            if (commandK || slash) {
                e.preventDefault();
                inputRef.current?.focus();
            }
        };
        document.addEventListener('keydown', onKeyDown);
        return () => document.removeEventListener('keydown', onKeyDown);
    }, []);

    return (
        <form onSubmit={onSubmit} role="search" className="flex-1 min-w-0">
            <label className="flex items-center gap-2.5 rounded-full border border-slate-300 dark:border-dark-500 bg-card-bg px-4 py-2.5 focus-within:border-accent transition-colors">
                <Search className="w-4 h-4 text-muted shrink-0" aria-hidden="true" />
                <span className="sr-only">Search posts</span>
                <input
                    ref={inputRef}
                    type="search"
                    value={value}
                    onChange={(e) => onChange(e.target.value)}
                    placeholder="Search posts…"
                    className="flex-1 min-w-0 bg-transparent border-0 p-0 text-[0.9375rem] text-foreground placeholder:text-slate-500 focus:outline-none focus:ring-0"
                />
                <kbd className="hidden sm:inline font-mono text-[0.6875rem] text-muted border border-border rounded px-1.5 py-px whitespace-nowrap">
                    {isMac ? '⌘ K' : 'Ctrl K'}
                </kbd>
            </label>
        </form>
    );
}
