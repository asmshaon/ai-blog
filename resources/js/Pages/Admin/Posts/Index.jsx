import AppLayout from '@/Layouts/AppLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function PostsIndex({ posts, filters }) {
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this post?')) {
            destroy(route('admin.posts.destroy', id));
        }
    };

    return (
        <AppLayout title="Blog Posts">
            <Head title="Blog Posts" />
            <div className="mb-6 flex justify-between items-center">
                <Link
                    href="/admin/posts/create"
                    className="btn-primary text-white px-6 py-2 rounded-lg text-sm font-semibold"
                >
                    New Post
                </Link>
            </div>

            <div className="bg-card-bg rounded-2xl border border-border overflow-hidden">
                <table className="min-w-full divide-y divide-border">
                    <thead className="bg-background">
                        <tr>
                            <th className="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">Title</th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">Status</th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">Category</th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">Views</th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">Date</th>
                            <th className="px-6 py-3 text-right text-xs font-medium text-muted uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody className="bg-card-bg divide-y divide-border">
                        {posts.data.map((post) => (
                            <tr key={post.id} className="hover:bg-accent/5 transition-colors">
                                <td className="px-6 py-4 whitespace-nowrap">
                                    <div className="text-sm font-medium text-foreground">{post.title}</div>
                                    <div className="text-sm text-muted">{post.slug}</div>
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    <span className={`inline-flex px-2.5 py-1 text-xs font-semibold rounded-full ${
                                        post.status === 'published' ? 'bg-green-500/10 text-green-500 border border-green-500/30' :
                                        post.status === 'draft' ? 'bg-muted/10 text-muted border border-border' :
                                        'bg-orange-500/10 text-orange-500 border border-orange-500/30'
                                    }`}>
                                        {post.status}
                                    </span>
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap text-sm text-muted">
                                    {post.category?.name || '-'}
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap text-sm text-muted">
                                    {post.view_count}
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap text-sm text-muted">
                                    {post.published_at ? new Date(post.published_at).toLocaleDateString() : '-'}
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                    <Link
                                        href={route('admin.posts.edit', post.id)}
                                        className="text-muted hover:text-accent transition-colors"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        onClick={() => handleDelete(post.id)}
                                        className="text-red-500 hover:text-red-400 transition-colors"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            {posts.links.length > 3 && (
                <div className="mt-4 flex justify-center gap-2">
                    {posts.links.map((link, index) => (
                        <Link
                            key={index}
                            href={link.url || ''}
                            preserveScroll
                            className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                                link.active
                                    ? 'btn-primary text-white'
                                    : 'bg-card-bg text-muted border border-border hover:border-accent hover:text-foreground'
                            } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                            dangerouslySetInnerHTML={{ __html: link.label }}
                        />
                    ))}
                </div>
            )}
        </AppLayout>
    );
}
