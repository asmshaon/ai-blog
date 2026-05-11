import AppLayout from '@/Layouts/AppLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function BlogIndex({ posts, filters, categories }) {
    const { data, setData, get } = useForm({
        search: filters.search || '',
        category: filters.category || '',
        tag: filters.tag || '',
    });

    const submitSearch = (e) => {
        e.preventDefault();
        get('/', { preserveState: true });
    };

    return (
        <AppLayout>
            <Head title="Blog" />

            <div className="mb-8">
                <h1 className="text-3xl font-bold text-foreground mb-4">Latest Posts</h1>
                <form onSubmit={submitSearch} className="flex flex-col sm:flex-row gap-3">
                    <input
                        type="text"
                        placeholder="Search posts..."
                        value={data.search}
                        onChange={(e) => setData('search', e.target.value)}
                        className="flex-1 rounded-lg border-border shadow-sm focus:border-accent focus:ring-accent/20 sm:text-sm px-4 py-2.5 bg-card-bg text-foreground border transition-colors"
                    />
                    <select
                        value={data.category}
                        onChange={(e) => {
                            setData('category', e.target.value);
                            get('/', { preserveState: true });
                        }}
                        className="rounded-lg border-border shadow-sm focus:border-accent focus:ring-accent/20 sm:text-sm px-4 py-2.5 bg-card-bg text-foreground border transition-colors"
                    >
                        <option value="">All Categories</option>
                        {categories.map((cat) => (
                            <option key={cat.id} value={cat.slug}>{cat.name}</option>
                        ))}
                    </select>
                    <button
                        type="submit"
                        className="btn-primary text-white px-6 py-2.5 rounded-lg text-sm font-semibold"
                    >
                        Search
                    </button>
                </form>
            </div>

            {posts.data.length === 0 ? (
                <p className="text-muted text-center py-12">No posts found.</p>
            ) : (
                <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    {posts.data.map((post) => (
                        <article key={post.id} className="bg-card-bg rounded-2xl border border-border overflow-hidden flex flex-col card-hover">
                            {post.featured_image && (
                                <img
                                    src={post.featured_image}
                                    alt={post.title}
                                    className="w-full h-48 object-cover"
                                />
                            )}
                            <div className="p-6 flex-1 flex flex-col">
                                <div className="flex items-center gap-2 text-sm text-muted mb-3">
                                    {post.category && (
                                        <span className="tech-tag">
                                            {post.category.name}
                                        </span>
                                    )}
                                    <span>{post.reading_time} min read</span>
                                </div>
                                <h2 className="text-xl font-semibold text-foreground mb-3">
                                    <Link href={route('blog.show', post.slug)} className="hover:text-accent transition-colors">
                                        {post.title}
                                    </Link>
                                </h2>
                                <p className="text-muted text-sm mb-4 flex-1 leading-relaxed">{post.excerpt}</p>
                                <div className="flex items-center justify-between text-sm text-muted mt-auto pt-4 border-t border-border">
                                    <span className="font-medium">{post.user.name}</span>
                                    <span>{new Date(post.published_at).toLocaleDateString()}</span>
                                </div>
                            </div>
                        </article>
                    ))}
                </div>
            )}

            {posts.links.length > 3 && (
                <div className="mt-8 flex justify-center gap-2">
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
