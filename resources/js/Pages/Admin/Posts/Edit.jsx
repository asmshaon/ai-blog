import AppLayout from '@/Layouts/AppLayout';
import { Head, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function PostEdit({ post, categories }) {
    const { data, setData, put, processing, errors } = useForm({
        title: post.title,
        slug: post.slug,
        excerpt: post.excerpt || '',
        content: post.content,
        category_id: post.category_id || '',
        featured_image: post.featured_image || '',
        seo_title: post.seo_title || '',
        seo_description: post.seo_description || '',
        seo_keywords: post.seo_keywords || '',
        canonical_url: post.canonical_url || '',
        og_image: post.og_image || '',
        featured: post.featured,
        status: post.status,
        published_at: post.published_at ? post.published_at.slice(0, 16) : '',
        tags: post.tags?.map((t) => t.name) || [],
    });

    const [tagInput, setTagInput] = useState('');

    const addTag = () => {
        if (tagInput.trim() && !data.tags.includes(tagInput.trim())) {
            setData('tags', [...data.tags, tagInput.trim()]);
            setTagInput('');
        }
    };

    const removeTag = (tag) => {
        setData('tags', data.tags.filter((t) => t !== tag));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('admin.posts.update', post.id));
    };

    const inputClass = "mt-1 block w-full rounded-lg border-border shadow-sm focus:border-accent focus:ring-accent/20 sm:text-sm px-4 py-2.5 bg-background text-foreground border transition-colors";
    const labelClass = "block text-sm font-medium text-foreground";
    const errorClass = "mt-1 text-sm text-red-500";
    const sectionTitle = "text-lg font-semibold text-foreground mb-4";

    return (
        <AppLayout title="Edit Post">
            <Head title="Edit Post" />
            <form onSubmit={handleSubmit} className="max-w-4xl mx-auto space-y-6 bg-card-bg p-8 rounded-2xl border border-border">
                <div>
                    <label className={labelClass}>Title</label>
                    <input type="text" value={data.title} onChange={(e) => setData('title', e.target.value)} className={inputClass} />
                    {errors.title && <p className={errorClass}>{errors.title}</p>}
                </div>

                <div>
                    <label className={labelClass}>Slug</label>
                    <input type="text" value={data.slug} onChange={(e) => setData('slug', e.target.value)} className={inputClass} />
                    {errors.slug && <p className={errorClass}>{errors.slug}</p>}
                </div>

                <div>
                    <label className={labelClass}>Excerpt</label>
                    <textarea value={data.excerpt} onChange={(e) => setData('excerpt', e.target.value)} rows={3} className={inputClass} />
                    {errors.excerpt && <p className={errorClass}>{errors.excerpt}</p>}
                </div>

                <div>
                    <label className={labelClass}>Content</label>
                    <textarea value={data.content} onChange={(e) => setData('content', e.target.value)} rows={12} className={`${inputClass} font-mono`} />
                    {errors.content && <p className={errorClass}>{errors.content}</p>}
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label className={labelClass}>Category</label>
                        <select value={data.category_id} onChange={(e) => setData('category_id', e.target.value)} className={inputClass}>
                            <option value="">Select category</option>
                            {categories.map((cat) => (
                                <option key={cat.id} value={cat.id}>{cat.name}</option>
                            ))}
                        </select>
                    </div>

                    <div>
                        <label className={labelClass}>Status</label>
                        <select value={data.status} onChange={(e) => setData('status', e.target.value)} className={inputClass}>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="scheduled">Scheduled</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label className={labelClass}>Published At</label>
                    <input type="datetime-local" value={data.published_at} onChange={(e) => setData('published_at', e.target.value)} className={inputClass} />
                </div>

                <div>
                    <label className={labelClass}>Featured Image URL</label>
                    <input type="text" value={data.featured_image} onChange={(e) => setData('featured_image', e.target.value)} className={inputClass} />
                </div>

                <div>
                    <label className={labelClass}>Tags</label>
                    <div className="flex gap-2 mt-1">
                        <input type="text" value={tagInput} onChange={(e) => setTagInput(e.target.value)} onKeyDown={(e) => e.key === 'Enter' && (e.preventDefault(), addTag())} placeholder="Add tag and press Enter" className={inputClass} />
                        <button type="button" onClick={addTag} className="bg-background text-muted px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-accent/10 hover:text-accent border border-border transition-colors">
                            Add
                        </button>
                    </div>
                    <div className="flex flex-wrap gap-2 mt-2">
                        {data.tags.map((tag) => (
                            <span key={tag} className="inline-flex items-center bg-background text-muted px-3 py-1 rounded-lg text-sm border border-border">
                                {tag}
                                <button type="button" onClick={() => removeTag(tag)} className="ml-1.5 text-muted hover:text-red-500 transition-colors">&times;</button>
                            </span>
                        ))}
                    </div>
                </div>

                <div className="border-t border-border pt-6">
                    <h3 className={sectionTitle}>SEO Settings</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label className={labelClass}>SEO Title</label>
                            <input type="text" value={data.seo_title} onChange={(e) => setData('seo_title', e.target.value)} className={inputClass} />
                        </div>
                        <div>
                            <label className={labelClass}>SEO Keywords</label>
                            <input type="text" value={data.seo_keywords} onChange={(e) => setData('seo_keywords', e.target.value)} className={inputClass} />
                        </div>
                        <div className="md:col-span-2">
                            <label className={labelClass}>SEO Description</label>
                            <textarea value={data.seo_description} onChange={(e) => setData('seo_description', e.target.value)} rows={2} className={inputClass} />
                        </div>
                        <div>
                            <label className={labelClass}>Canonical URL</label>
                            <input type="text" value={data.canonical_url} onChange={(e) => setData('canonical_url', e.target.value)} className={inputClass} />
                        </div>
                        <div>
                            <label className={labelClass}>OG Image URL</label>
                            <input type="text" value={data.og_image} onChange={(e) => setData('og_image', e.target.value)} className={inputClass} />
                        </div>
                    </div>
                </div>

                <div className="flex items-center">
                    <input id="featured" type="checkbox" checked={data.featured} onChange={(e) => setData('featured', e.target.checked)} className="h-4 w-4 text-accent focus:ring-accent/20 border-border rounded bg-background" />
                    <label htmlFor="featured" className="ml-2 block text-sm text-muted">
                        Featured post
                    </label>
                </div>

                <div className="flex justify-end">
                    <button type="submit" disabled={processing} className="btn-primary text-white px-6 py-2.5 rounded-lg text-sm font-semibold disabled:opacity-50">
                        Update Post
                    </button>
                </div>
            </form>
        </AppLayout>
    );
}
