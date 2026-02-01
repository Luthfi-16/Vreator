<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

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
        return view('admin.template.show', compact('template'));
    }

    /**
     * Update template status (moderation).
     */
    public function update(Request $request, Template $template)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $template->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.template.index')
            ->with('success', 'Status template berhasil diperbarui.');
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
