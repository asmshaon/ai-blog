import { Link } from '@inertiajs/react';
import { Calendar } from 'lucide-react';

const dateFormat = new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

export function formatDate(value) {
    return value ? dateFormat.format(new Date(value)) : '';
}

// "~716 words" below 1,000; "~2.8K words" from 1,000 up.
export function formatWords(count) {
    const n = Number(count) || 0;
    if (n < 1000) return `~${n} words`;
    const thousands = (Math.round(n / 100) / 10).toFixed(1).replace(/\.0$/, '');
    return `~${thousands}K words`;
}

export function PostDate({ value, children, icon = true, className = '' }) {
    return (
        <div className={`flex flex-wrap items-center gap-2 font-mono text-xs uppercase tracking-wider text-muted ${className}`}>
            {icon && <Calendar className="w-3.5 h-3.5" aria-hidden="true" />}
            <time dateTime={value}>{formatDate(value)}</time>
            {children}
        </div>
    );
}

export function CategoryLabel({ category }) {
    if (!category) return null;
    return (
        <Link
            href={`/?category=${category.slug}`}
            className="font-sans text-xs text-foreground bg-card-bg border border-border hover:border-accent rounded px-2 py-0.5 transition-colors"
        >
            {category.name}
        </Link>
    );
}
