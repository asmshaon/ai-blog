import AppLayout from '@/Layouts/AppLayout';
import SearchBar from '@/Components/SearchBar';
import { CategoryLabel, formatWords, PostDate } from '@/Components/Post';
import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';

function buildQuery(params) {
    return Object.fromEntries(Object.entries(params).filter(([, value]) => value));
}

export default function BlogIndex({ posts, filters, categories, showLatestBadge }) {
    const [search, setSearch] = useState(filters.search || '');
    const activeCategory = filters.category || '';
    const totalPublished = categories.reduce((sum, c) => sum + c.posts_count, 0);

    const visit = (params) => router.get('/', buildQuery(params), { preserveState: true, preserveScroll: true });

    const submitSearch = (e) => {
        e.preventDefault();
        visit({ search: search.trim(), category: activeCategory, tag: filters.tag });
    };

    const clearSearch = () => {
        setSearch('');
        visit({ category: activeCategory, tag: filters.tag });
    };

    const chipClass = (active) =>
        `inline-flex items-baseline gap-1.5 rounded-full border px-3 py-1 text-[0.8125rem] transition-colors ${
            active
                ? 'bg-accent text-accent-contrast border-accent'
                : 'text-foreground border-slate-300 dark:border-dark-500 hover:border-accent'
        }`;

    return (
        <AppLayout>
            <Head title="Writing" />

            <div className="max-w-3xl mx-auto">
                <div className="mt-6">
                    <SearchBar value={search} onChange={setSearch} onSubmit={submitSearch} />
                </div>

                {categories.length > 0 && (
                    <div role="group" aria-label="Filter by topic" className="flex flex-wrap gap-2 mt-4">
                        <button
                            type="button"
                            aria-pressed={!activeCategory}
                            onClick={() => visit({ search: filters.search, tag: filters.tag })}
                            className={chipClass(!activeCategory)}
                        >
                            All
                            <span className={`font-mono text-[0.6875rem] ${!activeCategory ? 'opacity-70' : 'text-muted'}`}>{totalPublished}</span>
                        </button>
                        {categories.map((cat) => {
                            const active = activeCategory === cat.slug;
                            return (
                                <button
                                    key={cat.id}
                                    type="button"
                                    aria-pressed={active}
                                    onClick={() => visit({ search: filters.search, category: cat.slug, tag: filters.tag })}
                                    className={chipClass(active)}
                                >
                                    {cat.name}
                                    <span className={`font-mono text-[0.6875rem] ${active ? 'opacity-70' : 'text-muted'}`}>{cat.posts_count}</span>
                                </button>
                            );
                        })}
                    </div>
                )}

                {(filters.search || filters.tag) && (
                    <p className="mt-5 text-sm text-muted" aria-live="polite">
                        {posts.total} {posts.total === 1 ? 'post' : 'posts'}
                        {filters.search && <> matching &ldquo;{filters.search}&rdquo;</>}
                        {filters.tag && <> tagged #{filters.tag}</>}
                        <button
                            type="button"
                            onClick={filters.search ? clearSearch : () => visit({ category: activeCategory })}
                            className="ml-2 text-foreground underline underline-offset-4"
                        >
                            {filters.search ? 'Clear search' : 'Clear tag'}
                        </button>
                    </p>
                )}

                {posts.data.length === 0 ? (
                    <div className="py-16 text-muted">
                        <p className="text-lg">No posts match that yet.</p>
                        <Link href="/" className="mt-2 inline-block text-foreground underline underline-offset-4">
                            Show all posts
                        </Link>
                    </div>
                ) : (
                    <div className="mt-4">
                        {posts.data.map((post, index) => (
                            <article key={post.id} className="py-10 border-t border-border first:border-t-0">
                                <PostDate value={post.published_at}>
                                    {showLatestBadge && index === 0 && (
                                        <span className="font-sans normal-case tracking-normal text-xs font-medium text-foreground border border-accent rounded px-1.5 leading-5">
                                            Latest post
                                        </span>
                                    )}
                                </PostDate>
                                <h2 className="font-display font-medium text-foreground text-3xl sm:text-[2.375rem] leading-[1.12] mt-3.5 mb-3.5">
                                    <Link
                                        href={route('blog.show', post.slug)}
                                        className="hover:underline decoration-1 underline-offset-[6px]"
                                    >
                                        {post.title}
                                    </Link>
                                </h2>
                                {post.excerpt && <p className="text-lg text-muted leading-relaxed mb-4 max-w-[68ch]">{post.excerpt}</p>}
                                <div className="flex flex-wrap items-center gap-2.5 font-mono text-xs text-muted">
                                    <span>{formatWords(post.word_count)}</span>
                                    {post.category && (
                                        <>
                                            <span aria-hidden="true">·</span>
                                            <CategoryLabel category={post.category} />
                                        </>
                                    )}
                                </div>
                            </article>
                        ))}
                    </div>
                )}

                {posts.last_page > 1 && (
                    <nav aria-label="Pages" className="flex items-center justify-between gap-3 border-t border-accent pt-5 pb-16 text-sm">
                        {posts.prev_page_url ? (
                            <Link href={posts.prev_page_url} className="text-foreground hover:underline underline-offset-4">
                                ← Newer posts
                            </Link>
                        ) : (
                            <span className="text-muted">← Newer posts</span>
                        )}
                        <span className="font-mono text-xs uppercase tracking-wider text-muted">
                            Page {posts.current_page} of {posts.last_page}
                        </span>
                        {posts.next_page_url ? (
                            <Link href={posts.next_page_url} className="text-foreground hover:underline underline-offset-4">
                                Older posts →
                            </Link>
                        ) : (
                            <span className="text-muted">Older posts →</span>
                        )}
                    </nav>
                )}
            </div>
        </AppLayout>
    );
}
