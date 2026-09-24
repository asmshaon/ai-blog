import AppLayout from '@/Layouts/AppLayout';
import AuthField from '@/Components/AuthField';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Register({ redirect }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });
    const query = redirect ? `?redirect=${encodeURIComponent(redirect)}` : '';

    const submit = (e) => {
        e.preventDefault();
        post('/register');
    };

    return (
        <AppLayout>
            <Head title="Create an account" />
            <div className="max-w-md mx-auto py-10 sm:py-16">
                <Link
                    href={redirect ? `${redirect}#comments` : '/'}
                    className="inline-block mb-7 font-mono text-xs uppercase tracking-wider text-muted hover:text-foreground"
                >
                    ← {redirect ? 'Back to the post' : 'Back to writing'}
                </Link>
                <h1 className="font-display font-medium text-foreground text-[2.5rem] leading-tight">Create an account</h1>
                <p className="mt-2 mb-8 text-muted">
                    Accounts are only used for commenting. Your name is shown next to your comments; your email is not.
                </p>

                <form onSubmit={submit} className="space-y-5">
                    <AuthField
                        id="name"
                        label="Name"
                        autoComplete="name"
                        value={data.name}
                        onChange={(v) => setData('name', v)}
                        error={errors.name}
                    />
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
                        autoComplete="new-password"
                        value={data.password}
                        onChange={(v) => setData('password', v)}
                        error={errors.password}
                    />
                    <AuthField
                        id="password_confirmation"
                        label="Confirm password"
                        type="password"
                        autoComplete="new-password"
                        value={data.password_confirmation}
                        onChange={(v) => setData('password_confirmation', v)}
                        error={errors.password_confirmation}
                    />

                    <button
                        type="submit"
                        disabled={processing}
                        className="btn-primary w-full py-2.5 rounded-md text-sm font-semibold disabled:opacity-50"
                    >
                        Create account
                    </button>
                </form>

                <p className="mt-6 text-sm text-muted">
                    Already have an account?{' '}
                    <Link href={`/login${query}`} className="text-foreground underline underline-offset-4">
                        Sign in
                    </Link>
                </p>
            </div>
        </AppLayout>
    );
}
