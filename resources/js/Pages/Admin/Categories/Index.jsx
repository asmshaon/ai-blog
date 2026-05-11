import AppLayout from '@/Layouts/AppLayout';
import { Head, router, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function CategoriesIndex({ categories }) {
    const { data: createData, setData: setCreateData, post: createPost, processing: createProcessing, errors: createErrors, reset: resetCreate } = useForm({
        name: '',
        description: '',
    });

    const { data: editData, setData: setEditData, put: updatePut, processing: editProcessing } = useForm({
        name: '',
        description: '',
    });

    const [editingId, setEditingId] = useState(null);

    const handleCreate = (e) => {
        e.preventDefault();
        createPost(route('admin.categories.store'), {
            onSuccess: () => resetCreate(),
        });
    };

    const startEdit = (category) => {
        setEditingId(category.id);
        setEditData({
            name: category.name,
            description: category.description || '',
        });
    };

    const handleUpdate = (e, id) => {
        e.preventDefault();
        updatePut(route('admin.categories.update', id), {
            onSuccess: () => setEditingId(null),
        });
    };

    const handleDelete = (id) => {
        if (confirm('Are you sure?')) {
            router.delete(route('admin.categories.destroy', id));
        }
    };

    const inputClass = "block w-full rounded-lg border-border shadow-sm focus:border-accent focus:ring-accent/20 sm:text-sm px-4 py-2.5 bg-background text-foreground border transition-colors";

    return (
        <AppLayout title="Categories">
            <Head title="Categories" />

            <form onSubmit={handleCreate} className="mb-8 bg-card-bg p-6 rounded-2xl border border-border">
                <h2 className="text-lg font-semibold text-foreground mb-4">New Category</h2>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="text" placeholder="Name" value={createData.name} onChange={(e) => setCreateData('name', e.target.value)} className={inputClass} />
                        {createErrors.name && <p className="mt-1 text-sm text-red-500">{createErrors.name}</p>}
                    </div>
                    <div>
                        <input type="text" placeholder="Description" value={createData.description} onChange={(e) => setCreateData('description', e.target.value)} className={inputClass} />
                    </div>
                    <button type="submit" disabled={createProcessing} className="btn-primary text-white px-6 py-2.5 rounded-lg text-sm font-semibold disabled:opacity-50">
                        Create
                    </button>
                </div>
            </form>

            <div className="bg-card-bg rounded-2xl border border-border overflow-hidden">
                <table className="min-w-full divide-y divide-border">
                    <thead className="bg-background">
                        <tr>
                            <th className="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">Name</th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">Slug</th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">Description</th>
                            <th className="px-6 py-3 text-right text-xs font-medium text-muted uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody className="bg-card-bg divide-y divide-border">
                        {categories.map((category) => (
                            <tr key={category.id} className="hover:bg-accent/5 transition-colors">
                                {editingId === category.id ? (
                                    <>
                                        <td className="px-6 py-4">
                                            <input type="text" value={editData.name} onChange={(e) => setEditData('name', e.target.value)} className={inputClass} />
                                        </td>
                                        <td className="px-6 py-4 text-sm text-muted">{category.slug}</td>
                                        <td className="px-6 py-4">
                                            <input type="text" value={editData.description} onChange={(e) => setEditData('description', e.target.value)} className={inputClass} />
                                        </td>
                                        <td className="px-6 py-4 text-right space-x-3">
                                            <button onClick={(e) => handleUpdate(e, category.id)} disabled={editProcessing} className="text-accent hover:text-accent-hover text-sm font-medium transition-colors">
                                                Save
                                            </button>
                                            <button onClick={() => setEditingId(null)} className="text-muted hover:text-foreground text-sm font-medium transition-colors">
                                                Cancel
                                            </button>
                                        </td>
                                    </>
                                ) : (
                                    <>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-foreground">{category.name}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-muted">{category.slug}</td>
                                        <td className="px-6 py-4 text-sm text-muted">{category.description}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                            <button onClick={() => startEdit(category)} className="text-muted hover:text-accent transition-colors">
                                                Edit
                                            </button>
                                            <button onClick={() => handleDelete(category.id)} className="text-red-500 hover:text-red-400 transition-colors">
                                                Delete
                                            </button>
                                        </td>
                                    </>
                                )}
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </AppLayout>
    );
}
