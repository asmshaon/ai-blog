import AppLayout from '@/Layouts/AppLayout';
import { CategoryLabel, formatWords, PostDate } from '@/Components/Post';
import { MAIN_SITE, PORTFOLIO } from '@/site';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { useState } from 'react';

const textareaClass =
    'w-full rounded-md border border-slate-300 dark:border-dark-500 bg-card-bg text-foreground text-[0.9375rem] px-3.5 py-3 focus:outline-none focus:border-accent transition-colors';

function CommentItem({ comment, canDelete, children, compact = false }) {
    return (
        <div className={compact ? 'py-3' : ''}>
            <header className="flex flex-wrap items-baseline gap-x-2.5 gap-y-0.5 text-sm">
                <span className="font-semibold text-foreground">{comment.user.name}</span>
                <PostDate value={comment.created_at} icon={false} className="!text-[0.6875rem]" />
                {canDelete && (
                    <Link
                        href={route('comments.destroy', comment.id)}
                        method="delete"
                        as="button"
                        preserveScroll
                        className="ml-auto text-xs text-muted hover:text-foreground underline underline-offset-4"
                    >
                        Delete
                    </Link>
                )}
            </header>
            <p className={`mt-1.5 text-foreground whitespace-pre-line ${compact ? 'text-sm' : 'text-[0.96875rem]'}`}>{comment.body}</p>
            {children}
        </div>
    );
}

export default function BlogShow({ post, related }) {
    const { auth } = usePage().props;
    const [replyingTo, setReplyingTo] = useState(null);
    const returnQuery = `?redirect=${encodeURIComponent(`/blog/${post.slug}`)}`;
    const canDelete = (comment) => auth.user && (auth.user.id === comment.user_id || auth.user.role === 'admin');

    const { data, setData, post: submitComment, processing, errors, reset } = useForm({
        body: '',
        parent_id: null,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        submitComment(route('comments.store', post.id), {
            preserveScroll: true,
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

    const topLevel = post.comments.filter((c) => !c.parent_id);

    return (
        <AppLayout>
            <Head title={post.seo_title || post.title}>
                {post.seo_description && <meta name="description" content={post.seo_description} />}
            </Head>

            <article className="max-w-3xl mx-auto">
                <header className="pt-8">
                    <PostDate value={post.published_at} />
                    <h1 className="font-display font-medium text-foreground text-4xl sm:text-5xl lg:text-[3.5rem] leading-[1.06] mt-4 mb-5">
                        {post.title}
                    </h1>
                    <div className="flex flex-wrap items-center gap-2.5 font-mono text-xs text-muted">
                        <span>{formatWords(post.word_count)}</span>
                        <span aria-hidden="true">·</span>
                        <span>{post.reading_time} min read</span>
                        {post.category && (
                            <>
                                <span aria-hidden="true">·</span>
                                <CategoryLabel category={post.category} />
                            </>
                        )}
                    </div>
                    {post.tags.length > 0 && (
                        <div className="flex flex-wrap gap-x-4 gap-y-1 mt-4 text-sm">
                            {post.tags.map((tag) => (
                                <Link key={tag.id} href={`/?tag=${tag.slug}`} className="text-muted hover:text-foreground">
                                    #{tag.name}
                                </Link>
                            ))}
                        </div>
                    )}
                </header>

                {post.featured_image && (
                    <img src={post.featured_image} alt="" className="w-full rounded-lg border border-border mt-8" />
                )}

                <div
                    className="prose prose-neutral dark:prose-invert max-w-[68ch] mt-10 text-[1.0625rem] leading-[1.75]
                        prose-headings:font-display prose-headings:font-medium prose-headings:text-foreground
                        prose-h2:text-[1.875rem] prose-h2:mt-11 prose-h3:text-2xl
                        prose-p:text-foreground/90 prose-li:text-foreground/90 prose-strong:text-foreground
                        prose-a:text-foreground prose-a:underline-offset-4
                        prose-blockquote:border-l-2 prose-blockquote:border-accent prose-blockquote:font-display prose-blockquote:text-xl prose-blockquote:not-italic prose-blockquote:text-foreground
                        prose-code:font-mono prose-code:text-[0.84em] prose-code:text-foreground prose-code:bg-slate-100 dark:prose-code:bg-dark-700 prose-code:border prose-code:border-border prose-code:rounded prose-code:px-1 prose-code:py-px prose-code:font-normal prose-code:before:content-none prose-code:after:content-none
                        prose-pre:font-mono prose-pre:text-sm prose-pre:leading-relaxed prose-pre:bg-card-bg prose-pre:text-foreground prose-pre:border prose-pre:border-border prose-pre:rounded-lg prose-pre:overflow-x-auto
                        [&_pre_code]:bg-transparent [&_pre_code]:border-0 [&_pre_code]:p-0"
                    dangerouslySetInnerHTML={{ __html: post.content }}
                />

                <aside aria-label="About the author" className="max-w-[68ch] mt-12 flex gap-4 items-start rounded-lg border border-border bg-card-bg p-6">
                    <div className="w-11 h-11 rounded-full bg-accent text-accent-contrast font-display font-semibold flex items-center justify-center shrink-0">
                        AS
                    </div>
                    <div>
                        <p className="font-display text-foreground text-xl leading-tight">Abu Saleh</p>
                        <p className="mt-1 text-[0.9375rem] text-muted">
                            Senior Full-Stack Software Engineer. I build payment, booking, point-of-sale and marketplace
                            systems, and write about the problems I run into.
                        </p>
                        <div className="flex gap-5 mt-3 text-sm">
                            <a href={PORTFOLIO} target="_blank" rel="noopener noreferrer" className="text-foreground border-b border-border hover:border-accent">
                                Portfolio →
                            </a>
                            <a href={MAIN_SITE} target="_blank" rel="noopener noreferrer" className="text-foreground border-b border-border hover:border-accent">
                                About me →
                            </a>
                        </div>
                    </div>
                </aside>

                <section id="comments" aria-labelledby="comments-heading" className="max-w-[68ch] scroll-mt-8">
                    <h2 id="comments-heading" className="font-display font-medium text-foreground text-[1.625rem] mt-16 mb-2">
                        Discussion
                    </h2>

                    {auth.user ? (
                        <form onSubmit={handleSubmit} className="mt-4">
                            <label htmlFor="comment-body" className="sr-only">
                                Your comment
                            </label>
                            <textarea
                                id="comment-body"
                                value={replyingTo ? '' : data.body}
                                onChange={(e) => setData('body', e.target.value)}
                                disabled={replyingTo !== null}
                                placeholder="Share a thought or a question…"
                                rows={4}
                                className={textareaClass}
                            />
                            {errors.body && !replyingTo && <p className="mt-1 text-sm text-foreground">{errors.body}</p>}
                            <div className="mt-2 flex items-center justify-between gap-3 text-sm text-muted">
                                <span>Commenting as {auth.user.name}</span>
                                <button
                                    type="submit"
                                    disabled={processing || replyingTo !== null}
                                    className="btn-primary px-5 py-2 rounded-md text-sm font-semibold disabled:opacity-50"
                                >
                                    Post comment
                                </button>
                            </div>
                        </form>
                    ) : (
                        <div className="mt-4 flex flex-wrap items-center justify-between gap-4 rounded-lg border border-slate-300 dark:border-dark-500 bg-card-bg px-5 py-4">
                            <p className="text-foreground">
                                Sign in to join the discussion.
                                <span className="block text-sm text-muted">You only need an account to comment.</span>
                            </p>
                            <div className="flex flex-wrap gap-2">
                                <Link href={`/login${returnQuery}`} className="btn-primary px-4 py-2 rounded-md text-sm font-semibold">
                                    Sign in
                                </Link>
                                <Link
                                    href={`/register${returnQuery}`}
                                    className="px-4 py-2 rounded-md text-sm font-semibold text-foreground border border-slate-300 dark:border-dark-500 hover:border-accent transition-colors"
                                >
                                    Create an account
                                </Link>
                            </div>
                        </div>
                    )}

                    {topLevel.length === 0 ? (
                        <p className="mt-6 text-sm text-muted">No comments yet.</p>
                    ) : (
                        <div className="mt-6 border-t border-border">
                            {topLevel.map((comment) => (
                                <div key={comment.id} className="py-5 border-b border-border">
                                    <CommentItem comment={comment} canDelete={canDelete(comment)}>
                                        {auth.user && replyingTo !== comment.id && (
                                            <button
                                                type="button"
                                                onClick={() => handleReply(comment.id)}
                                                className="mt-2 text-sm text-muted hover:text-foreground"
                                            >
                                                Reply
                                            </button>
                                        )}

                                        {replyingTo === comment.id && (
                                            <form onSubmit={handleSubmit} className="mt-3">
                                                <label htmlFor={`reply-${comment.id}`} className="sr-only">
                                                    Your reply
                                                </label>
                                                <textarea
                                                    id={`reply-${comment.id}`}
                                                    value={data.body}
                                                    onChange={(e) => setData('body', e.target.value)}
                                                    placeholder="Write a reply…"
                                                    rows={2}
                                                    autoFocus
                                                    className={textareaClass}
                                                />
                                                {errors.body && <p className="mt-1 text-sm text-foreground">{errors.body}</p>}
                                                <div className="mt-2 flex gap-3 justify-end items-center">
                                                    <button
                                                        type="button"
                                                        onClick={() => {
                                                            setReplyingTo(null);
                                                            reset();
                                                        }}
                                                        className="text-sm text-muted hover:text-foreground"
                                                    >
                                                        Cancel
                                                    </button>
                                                    <button
                                                        type="submit"
                                                        disabled={processing}
                                                        className="btn-primary px-4 py-1.5 rounded-md text-sm font-semibold disabled:opacity-50"
                                                    >
                                                        Reply
                                                    </button>
                                                </div>
                                            </form>
                                        )}

                                        {comment.replies?.length > 0 && (
                                            <div className="mt-3 ml-5 pl-4 border-l border-slate-300 dark:border-dark-500">
                                                {comment.replies.map((reply) => (
                                                    <CommentItem key={reply.id} comment={reply} canDelete={canDelete(reply)} compact />
                                                ))}
                                            </div>
                                        )}
                                    </CommentItem>
                                </div>
                            ))}
                        </div>
                    )}
                </section>

                {related.length > 0 && (
                    <section aria-labelledby="related-heading" className="max-w-[68ch] pb-16">
                        <h2 id="related-heading" className="font-display font-medium text-foreground text-[1.625rem] mt-16 mb-3">
                            Related
                        </h2>
                        <ul className="border-t border-border">
                            {related.map((r) => (
                                <li key={r.id} className="grid sm:grid-cols-[9rem_1fr_auto] gap-x-5 gap-y-1 items-baseline py-4 border-b border-border">
                                    <PostDate value={r.published_at} icon={false} />
                                    <Link
                                        href={route('blog.show', r.slug)}
                                        className="font-display text-foreground text-xl leading-snug hover:underline decoration-1 underline-offset-4"
                                    >
                                        {r.title}
                                    </Link>
                                    <span className="font-mono text-xs text-muted">{formatWords(r.word_count)}</span>
                                </li>
                            ))}
                        </ul>
                    </section>
                )}
            </article>
        </AppLayout>
    );
}
