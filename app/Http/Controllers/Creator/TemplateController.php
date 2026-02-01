<?php
namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Template::where('user_id', Auth::id())->latest()->get();
        return view('creator.template.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('creator.template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'price'       => 'required|integer|min:0',
            'file'        => 'required|file',
            'preview'     => 'required|image|max:2048',
        ]);

        $filePath    = $request->file('file')->store('templates/files', 'public');
        $previewPath = $request->file('preview')->store('templates/previews', 'public');

        Template::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'file'        => $filePath,
            'preview'     => $previewPath,
        ]);

        return redirect()->route('creator.template.index')
            ->with('success', 'Template berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = Template::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('creator.template.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $template = Template::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'price'       => 'required|integer|min:0',
            'file'        => 'nullable|file',
            'preview'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($template->file);
            $template->file = $request->file('file')->store('templates/files', 'public');
        }

        if ($request->hasFile('preview')) {
            Storage::disk('public')->delete($template->preview);
            $template->preview = $request->file('preview')->store('templates/previews', 'public');
        }

        $template->update([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
        ]);

        return redirect()->route('creator.template.index')
            ->with('success', 'Template berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $template = Template::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        Storage::disk('public')->delete([
            $template->file,
            $template->preview,
        ]);

        $template->delete();

        return redirect()->route('creator.template.index')
            ->with('success', 'Template berhasil dihapus');
    }
}
