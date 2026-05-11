import AppLayout from '@/Layouts/AppLayout';
import { Head, useForm } from '@inertiajs/react';

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post('/login');
    };

    return (
        <AppLayout title="Login">
            <Head title="Login" />
            <div className="max-w-md mx-auto">
                <form onSubmit={submit} className="space-y-6 bg-card-bg p-8 rounded-2xl border border-border">
                    <div>
                        <label htmlFor="email" className="block text-sm font-medium text-foreground">
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            className="mt-1 block w-full rounded-lg border-border shadow-sm focus:border-accent focus:ring-accent/20 sm:text-sm px-4 py-2.5 bg-background text-foreground border transition-colors"
                        />
                        {errors.email && <p className="mt-1 text-sm text-red-500">{errors.email}</p>}
                    </div>

                    <div>
                        <label htmlFor="password" className="block text-sm font-medium text-foreground">
                            Password
                        </label>
                        <input
                            id="password"
                            type="password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            className="mt-1 block w-full rounded-lg border-border shadow-sm focus:border-accent focus:ring-accent/20 sm:text-sm px-4 py-2.5 bg-background text-foreground border transition-colors"
                        />
                        {errors.password && <p className="mt-1 text-sm text-red-500">{errors.password}</p>}
                    </div>

                    <div className="flex items-center">
                        <input
                            id="remember"
                            type="checkbox"
                            checked={data.remember}
                            onChange={(e) => setData('remember', e.target.checked)}
                            className="h-4 w-4 text-accent focus:ring-accent/20 border-border rounded bg-background"
                        />
                        <label htmlFor="remember" className="ml-2 block text-sm text-muted">
                            Remember me
                        </label>
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white btn-primary focus:outline-none disabled:opacity-50"
                    >
                        Log in
                    </button>
                </form>
            </div>
        </AppLayout>
    );
}
