import AppLayout from '@/Layouts/AppLayout';
import { Head, useForm } from '@inertiajs/react';

export default function Register() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post('/register');
    };

    return (
        <AppLayout title="Register">
            <Head title="Register" />
            <div className="max-w-md mx-auto">
                <form onSubmit={submit} className="space-y-6 bg-card-bg p-8 rounded-2xl border border-border">
                    <div>
                        <label htmlFor="name" className="block text-sm font-medium text-foreground">
                            Name
                        </label>
                        <input
                            id="name"
                            type="text"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            className="mt-1 block w-full rounded-lg border-border shadow-sm focus:border-accent focus:ring-accent/20 sm:text-sm px-4 py-2.5 bg-background text-foreground border transition-colors"
                        />
                        {errors.name && <p className="mt-1 text-sm text-red-500">{errors.name}</p>}
                    </div>

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

                    <div>
                        <label htmlFor="password_confirmation" className="block text-sm font-medium text-foreground">
                            Confirm Password
                        </label>
                        <input
                            id="password_confirmation"
                            type="password"
                            value={data.password_confirmation}
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            className="mt-1 block w-full rounded-lg border-border shadow-sm focus:border-accent focus:ring-accent/20 sm:text-sm px-4 py-2.5 bg-background text-foreground border transition-colors"
                        />
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white btn-primary focus:outline-none disabled:opacity-50"
                    >
                        Register
                    </button>
                </form>
            </div>
        </AppLayout>
    );
}
