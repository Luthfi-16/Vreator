<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;

class TemplateController extends Controller
{
    /**
     * Display a listing of all templates.
     */
    public function index()
    {
        $templates = Template::with('user')
            ->latest()
            ->get();

        return view('admin.template.index', compact('templates'));
    }

    /**
     * Display the specified template.
     */
    public function show(Template $template)
    {
        return view('admin.template.show', compact('templates'));
    }

    /**
     * Remove the specified template.
     */
    public function destroy(Template $template)
    {
        $template->delete();

        return redirect()
            ->route('admin.template.index')
            ->with('success', 'Template berhasil dihapus.');
    }
}
