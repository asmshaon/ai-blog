import { useTheme } from '@/Providers/ThemeProvider';
import { Sun, Moon } from 'lucide-react';

export function ThemeToggle() {
    const { theme, setTheme, mounted } = useTheme();

    if (!mounted) {
        return (
            <button
                className="text-muted hover:text-foreground transition-colors p-2 rounded-lg hover:bg-accent/10"
                aria-label="Toggle theme"
            >
                <div className="w-5 h-5" />
            </button>
        );
    }

    return (
        <button
            onClick={() => setTheme(theme === 'dark' ? 'light' : 'dark')}
            className="text-muted hover:text-foreground transition-colors p-2 rounded-lg hover:bg-accent/10"
            aria-label="Toggle theme"
            title={theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'}
        >
            {theme === 'dark' ? (
                <Sun className="w-5 h-5" />
            ) : (
                <Moon className="w-5 h-5" />
            )}
        </button>
    );
}
