<?php
namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\Software;
use App\Models\TemplateCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Template::with(['software', 'category', 'user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('creator.template.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $softwares  = Software::all();
        $categories = TemplateCategory::all();

        return view('creator.template.create', compact('softwares', 'categories'));

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
            'preview_video' => 'nullable|required_if:type,video|mimetypes:video/mp4,video/webm,video/quicktime|max:100000',
            'software_id' => 'required|exists:software,id',
            'category_id' => 'required|exists:template_categories,id',
            'type'        => 'required|in:video,photo',
        ]);

        $file = $request->file('file');

        $originalName = $file->getClientOriginalName(); // preset.xml
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($originalName, PATHINFO_FILENAME);

        $folder = 'templates/files/creator-' . Auth::id();
        $finalName = $originalName;
        $counter = 1;

        // anti ketiban
        while (Storage::disk('public')->exists($folder.'/'.$finalName)) {
            $finalName = $filename . '(' . $counter . ').' . $extension;
            $counter++;
        }

        // simpan file dengan nama aman
        $filePath = $file->storeAs($folder, $finalName, 'public');

        $previewPath = $request->file('preview')->store('templates/previews', 'public');
        $previewVideoPath = $request->hasFile('preview_video')
            ? $request->file('preview_video')->store('templates/previews/videos', 'public')
            : null;

        Template::create([
            'user_id'     => Auth::id(),
            'software_id' => $request->software_id,
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'type'        => $request->type,
            'price'       => $request->price,
            'file'        => $filePath,
            'preview'     => $previewPath,
            'preview_video' => $previewVideoPath,
        ]);

        return redirect()->route('creator.template.index')
            ->with('success', 'Template berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        abort_if($template->user_id !== Auth::id(), 403);


        $softwares  = Software::all();
        $categories = TemplateCategory::all();

        return view('creator.template.edit', compact('template', 'softwares', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        abort_if($template->user_id !== Auth::id(), 403);


        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',    
            'price'       => 'required|integer|min:0',
            'file'        => 'nullable|file',
            'preview'     => 'nullable|image|max:2048',
            'preview_video' => 'nullable|mimetypes:video/mp4,video/webm,video/quicktime|max:100000',
            'software_id' => 'required|exists:software,id',
            'category_id' => 'required|exists:template_categories,id',
            'type'        => 'required|in:video,photo',
        ]);

        if ($request->type === 'video' && ! $template->preview_video && ! $request->hasFile('preview_video')) {
            throw ValidationException::withMessages([
                'preview_video' => 'Preview video wajib diisi untuk template type video.',
            ]);
        }

        if ($request->hasFile('file')) {
            if ($template->file) {
                Storage::disk('public')->delete($template->file);
            }

            $file = $request->file('file');

            $originalName = $file->getClientOriginalName();
            $extension    = $file->getClientOriginalExtension();
            $filename     = pathinfo($originalName, PATHINFO_FILENAME);

            $folder    = 'templates/files/creator-' . Auth::id();
            $finalName = $originalName;
            $counter   = 1;

            while (Storage::disk('public')->exists($folder . '/' . $finalName)) {
                $finalName = $filename . '(' . $counter . ').' . $extension;
                $counter++;
            }

            $template->file = $file->storeAs($folder, $finalName, 'public');

        }

        if ($request->hasFile('preview')) {
            if ($template->preview) {
                Storage::disk('public')->delete($template->preview);
            }

            $template->preview = $request->file('preview')->store('templates/previews', 'public');
        }

        if ($request->hasFile('preview_video')) {
            if ($template->preview_video) {
                Storage::disk('public')->delete($template->preview_video);
            }

            $template->preview_video = $request->file('preview_video')->store('templates/previews/videos', 'public');
        }

        if ($request->type !== 'video' && $template->preview_video) {
            Storage::disk('public')->delete($template->preview_video);
            $template->preview_video = null;
        }

        $template->update([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'software_id' => $request->software_id,
            'category_id' => $request->category_id,
            'type'        => $request->type,
            'preview'     => $template->preview,
            'preview_video' => $template->preview_video,
        ]);

        return redirect()->route('creator.template.index')
            ->with('success', 'Template berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        abort_if($template->user_id !== Auth::id(), 403);


        Storage::disk('public')->delete([
            $template->file,
            $template->preview,
            $template->preview_video,
        ]);

        $template->delete();

        return redirect()->route('creator.template.index')
            ->with('success', 'Template berhasil dihapus');
    }
}
