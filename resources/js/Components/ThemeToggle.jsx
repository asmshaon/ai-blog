import { useTheme } from '@/Providers/ThemeProvider';
import { Sun, Moon } from 'lucide-react';

export function ThemeToggle() {
    const { theme, setTheme, mounted } = useTheme();

    if (!mounted) {
        return (
            <button
                type="button"
                className="w-9 h-9 rounded-full border border-slate-300 dark:border-dark-500 bg-card-bg flex items-center justify-center text-foreground hover:border-accent transition-colors"
                aria-label="Toggle theme"
            >
                <div className="w-4 h-4" />
            </button>
        );
    }

    return (
        <button
            onClick={() => setTheme(theme === 'dark' ? 'light' : 'dark')}
            className="w-9 h-9 rounded-full border border-slate-300 dark:border-dark-500 bg-card-bg flex items-center justify-center text-foreground hover:border-accent transition-colors"
            aria-label="Toggle theme"
            title={theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'}
        >
            {theme === 'dark' ? (
                <Sun className="w-4 h-4" />
            ) : (
                <Moon className="w-4 h-4" />
            )}
        </button>
    );
}
