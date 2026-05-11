import AppLayout from '@/Layouts/AppLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { useState } from 'react';

export default function BlogShow({ post, related }) {
    const { auth } = usePage().props;
    const [replyingTo, setReplyingTo] = useState(null);

    const { data, setData, post: submitComment, processing, errors, reset } = useForm({
        body: '',
        parent_id: null,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        submitComment(route('comments.store', post.id), {
            onSuccess: () => {
                reset();
                setReplyingTo(null);
            },
        });
    };

    const handleReply = (commentId) => {
        setReplyingTo(commentId);
        setData('parent_id', commentId);
    };

    return (
        <AppLayout>
            <Head title={post.seo_title || post.title} />

            <article className="max-w-3xl mx-auto">
                {post.featured_image && (
                    <img
                        src={post.featured_image}
                        alt={post.title}
                        className="w-full h-64 md:h-96 object-cover rounded-2xl mb-8"
                    />
                )}

                <div className="mb-6">
                    {post.category && (
                        <Link
                            href={`/?category=${post.category.slug}`}
                            className="inline-block tech-tag mb-3"
                        >
                            {post.category.name}
                        </Link>
                    )}
                    <h1 className="text-3xl md:text-4xl font-bold text-foreground mb-4">{post.title}</h1>
                    <div className="flex items-center gap-4 text-sm text-muted">
                        <span>By {post.user.name}</span>
                        <span>{new Date(post.published_at).toLocaleDateString()}</span>
                        <span>{post.reading_time} min read</span>
                        <span>{post.view_count} views</span>
                    </div>
                </div>

                {post.tags.length > 0 && (
                    <div className="flex flex-wrap gap-2 mb-8">
                        {post.tags.map((tag) => (
                            <Link
                                key={tag.id}
                                href={`/?tag=${tag.slug}`}
                                className="text-sm text-muted bg-card-bg px-3 py-1 rounded-lg hover:bg-accent/10 hover:text-accent border border-border transition-colors"
                            >
                                #{tag.name}
                            </Link>
                        ))}
                    </div>
                )}

                <div
                    className="prose prose-lg max-w-none text-foreground mb-12 prose-headings:text-foreground prose-a:text-accent hover:prose-a:text-accent-hover prose-strong:text-foreground prose-code:text-accent prose-pre:bg-card-bg prose-pre:border prose-pre:border-border"
                    dangerouslySetInnerHTML={{ __html: post.content }}
                />

                <section className="border-t border-border pt-8 mb-12">
                    <h2 className="text-2xl font-bold text-foreground mb-6">Comments</h2>

                    {auth.user ? (
                        <form onSubmit={handleSubmit} className="mb-8">
                            <textarea
                                value={data.body}
                                onChange={(e) => setData('body', e.target.value)}
                                placeholder="Write a comment..."
                                rows={3}
                                className="w-full rounded-lg border-border shadow-sm focus:border-accent focus:ring-accent/20 sm:text-sm px-4 py-3 bg-card-bg text-foreground border transition-colors"
                            />
                            {errors.body && <p className="mt-1 text-sm text-red-500">{errors.body}</p>}
                            <div className="mt-2 flex justify-end">
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="btn-primary text-white px-6 py-2 rounded-lg text-sm font-semibold disabled:opacity-50"
                                >
                                    Post Comment
                                </button>
                            </div>
                        </form>
                    ) : (
                        <p className="text-muted mb-8">
                            <Link href="/login" className="text-accent hover:text-accent-hover underline underline-offset-4">Login</Link> to leave a comment.
                        </p>
                    )}

                    <div className="space-y-6">
                        {post.comments.filter(c => !c.parent_id).map((comment) => (
                            <div key={comment.id} className="bg-card-bg rounded-2xl p-5 border border-border">
                                <div className="flex items-center justify-between mb-2">
                                    <span className="font-semibold text-foreground">{comment.user.name}</span>
                                    <span className="text-sm text-muted">
                                        {new Date(comment.created_at).toLocaleDateString()}
                                    </span>
                                </div>
                                <p className="text-muted mb-3">{comment.body}</p>
                                {auth.user && (
                                    <button
                                        onClick={() => handleReply(comment.id)}
                                        className="text-sm text-muted hover:text-accent transition-colors"
                                    >
                                        Reply
                                    </button>
                                )}

                                {replyingTo === comment.id && (
                                    <form onSubmit={handleSubmit} className="mt-3">
                                        <textarea
                                            value={data.body}
                                            onChange={(e) => setData('body', e.target.value)}
                                            placeholder="Write a reply..."
                                            rows={2}
                                            className="w-full rounded-lg border-border shadow-sm focus:border-accent focus:ring-accent/20 sm:text-sm px-4 py-3 bg-card-bg text-foreground border transition-colors"
                                        />
                                        <div className="mt-2 flex gap-2 justify-end">
                                            <button
                                                type="button"
                                                onClick={() => { setReplyingTo(null); setData('parent_id', null); }}
                                                className="text-sm text-muted hover:text-foreground transition-colors"
                                            >
                                                Cancel
                                            </button>
                                            <button
                                                type="submit"
                                                disabled={processing}
                                                className="btn-primary text-white px-4 py-1.5 rounded-lg text-sm font-semibold disabled:opacity-50"
                                            >
                                                Reply
                                            </button>
                                        </div>
                                    </form>
                                )}

                                {comment.replies?.length > 0 && (
                                    <div className="mt-4 ml-6 space-y-3">
                                        {comment.replies.map((reply) => (
                                            <div key={reply.id} className="bg-background rounded-xl p-4 border border-border">
                                                <div className="flex items-center justify-between mb-1">
                                                    <span className="font-semibold text-foreground text-sm">{reply.user.name}</span>
                                                    <span className="text-xs text-muted">
                                                        {new Date(reply.created_at).toLocaleDateString()}
                                                    </span>
                                                </div>
                                                <p className="text-muted text-sm">{reply.body}</p>
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>
                        ))}
                    </div>
                </section>

                {related.length > 0 && (
                    <section className="border-t border-border pt-8">
                        <h2 className="text-2xl font-bold text-foreground mb-6">Related Posts</h2>
                        <div className="grid gap-6 md:grid-cols-3">
                            {related.map((r) => (
                                <article key={r.id} className="bg-card-bg rounded-2xl border border-border overflow-hidden card-hover">
                                    {r.featured_image && (
                                        <img src={r.featured_image} alt={r.title} className="w-full h-32 object-cover" />
                                    )}
                                    <div className="p-4">
                                        <h3 className="font-semibold text-foreground mb-1">
                                            <Link href={route('blog.show', r.slug)} className="hover:text-accent transition-colors">
                                                {r.title}
                                            </Link>
                                        </h3>
                                        <p className="text-sm text-muted">{r.reading_time} min read</p>
                                    </div>
                                </article>
                            ))}
                        </div>
                    </section>
                )}
            </article>
        </AppLayout>
    );
}
