import { AlertCircle } from 'lucide-react';

export default function AuthField({ id, label, type = 'text', value, onChange, error, autoComplete }) {
    return (
        <div>
            <label htmlFor={id} className="block text-sm font-medium text-foreground">
                {label}
            </label>
            <input
                id={id}
                type={type}
                value={value}
                autoComplete={autoComplete}
                onChange={(e) => onChange(e.target.value)}
                aria-invalid={error ? 'true' : undefined}
                aria-describedby={error ? `${id}-error` : undefined}
                className="mt-1.5 block w-full rounded-md border border-slate-300 dark:border-dark-500 bg-card-bg text-foreground text-[0.9375rem] px-3.5 py-2.5 focus:outline-none focus:border-accent transition-colors"
            />
            {error && (
                <p id={`${id}-error`} className="mt-1.5 flex items-center gap-1.5 text-sm text-foreground">
                    <AlertCircle className="w-4 h-4 shrink-0" aria-hidden="true" />
                    {error}
                </p>
            )}
        </div>
    );
}
