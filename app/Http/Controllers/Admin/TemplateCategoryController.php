<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemplateCategory;
use Illuminate\Http\Request;

class TemplateCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = TemplateCategory::latest()->get();
        return view('admin.template-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.template-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:template_categories,name',
        ]);

        TemplateCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.template-category.index')
            ->with('success', 'Category berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TemplateCategory $templateCategory)
    {
        return view('admin.template-category.edit', compact('templateCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TemplateCategory $templateCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:template_categories,name,' . $templateCategory->id,
        ]);

        $templateCategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.template-category.index')
            ->with('success', 'Category berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TemplateCategory $templateCategory)
    {
        // optional: cek apakah masih dipakai template
        if ($templateCategory->template()->count() > 0) {
            return back()->with('error', 'Kategori masih digunakan template');
        }

        $templateCategory->delete();

        return redirect()->route('admin.template-category.index')
            ->with('success', 'Category berhasil dihapus');
    }
}
