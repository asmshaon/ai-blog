import AppLayout from '@/Layouts/AppLayout';
import AuthField from '@/Components/AuthField';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ redirect }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    });
    const query = redirect ? `?redirect=${encodeURIComponent(redirect)}` : '';

    const submit = (e) => {
        e.preventDefault();
        post('/login');
    };

    return (
        <AppLayout>
            <Head title="Sign in" />
            <div className="max-w-md mx-auto py-10 sm:py-16">
                <Link
                    href={redirect ? `${redirect}#comments` : '/'}
                    className="inline-block mb-7 font-mono text-xs uppercase tracking-wider text-muted hover:text-foreground"
                >
                    ← {redirect ? 'Back to the post' : 'Back to writing'}
                </Link>
                <h1 className="font-display font-medium text-foreground text-[2.5rem] leading-tight">Sign in</h1>
                <p className="mt-2 mb-8 text-muted">
                    You only need an account to comment.
                    {redirect && " After signing in you'll return to the discussion."}
                </p>

                <form onSubmit={submit} className="space-y-5">
                    <AuthField
                        id="email"
                        label="Email"
                        type="email"
                        autoComplete="email"
                        value={data.email}
                        onChange={(v) => setData('email', v)}
                        error={errors.email}
                    />
                    <AuthField
                        id="password"
                        label="Password"
                        type="password"
                        autoComplete="current-password"
                        value={data.password}
                        onChange={(v) => setData('password', v)}
                        error={errors.password}
                    />

                    <label htmlFor="remember" className="flex items-center gap-2 text-sm text-muted">
                        <input
                            id="remember"
                            type="checkbox"
                            checked={data.remember}
                            onChange={(e) => setData('remember', e.target.checked)}
                            className="h-4 w-4 rounded border-slate-300 accent-current text-foreground"
                        />
                        Remember me
                    </label>

                    <button
                        type="submit"
                        disabled={processing}
                        className="btn-primary w-full py-2.5 rounded-md text-sm font-semibold disabled:opacity-50"
                    >
                        Sign in
                    </button>
                </form>

                <p className="mt-6 text-sm text-muted">
                    New here?{' '}
                    <Link href={`/register${query}`} className="text-foreground underline underline-offset-4">
                        Create an account
                    </Link>
                </p>
            </div>
        </AppLayout>
    );
}
