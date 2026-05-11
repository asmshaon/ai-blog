import AppLayout from '@/Layouts/AppLayout';
import { Head, Link } from '@inertiajs/react';

export default function AdminDashboard() {
    return (
        <AppLayout title="Admin Dashboard">
            <Head title="Admin Dashboard" />
            <div className="grid gap-6 md:grid-cols-3">
                <Link
                    href="/admin/posts"
                    className="bg-card-bg p-6 rounded-2xl border border-border card-hover"
                >
                    <div className="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center mb-4">
                        <svg className="w-6 h-6 text-accent-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h2 className="text-lg font-semibold text-foreground mb-1">Blog Posts</h2>
                    <p className="text-muted text-sm">Manage blog posts</p>
                </Link>
                <Link
                    href="/admin/categories"
                    className="bg-card-bg p-6 rounded-2xl border border-border card-hover"
                >
                    <div className="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center mb-4">
                        <svg className="w-6 h-6 text-accent-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h2 className="text-lg font-semibold text-foreground mb-1">Categories</h2>
                    <p className="text-muted text-sm">Manage categories</p>
                </Link>
            </div>
        </AppLayout>
    );
}
