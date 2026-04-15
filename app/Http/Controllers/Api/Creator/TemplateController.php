<?php

namespace App\Http\Controllers\Api\Creator;

use App\Http\Controllers\Controller;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = Template::with(['user', 'software', 'category'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Daftar template creator berhasil diambil.',
            'data' => TemplateResource::collection($templates),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer|min:0',
            'file' => 'required|file',
            'preview' => 'required|image|max:2048',
            'preview_video' => 'nullable|required_if:type,video|mimetypes:video/mp4,video/webm,video/quicktime|max:20480',
            'software_id' => 'required|exists:software,id',
            'category_id' => 'required|exists:template_categories,id',
            'type' => 'required|in:video,photo',
        ]);

        $filePath = $this->storeTemplateFile($request);
        $previewPath = $request->file('preview')->store('templates/previews', 'public');
        $previewVideoPath = $request->hasFile('preview_video')
            ? $request->file('preview_video')->store('templates/previews/videos', 'public')
            : null;

        $template = Template::create([
            ...$validated,
            'user_id' => $request->user()->id,
            'file' => $filePath,
            'preview' => $previewPath,
            'preview_video' => $previewVideoPath,
        ]);

        return response()->json([
            'message' => 'Template berhasil ditambahkan.',
            'data' => new TemplateResource($template->load(['user', 'software', 'category'])),
        ], 201);
    }

    public function show(Request $request, Template $template)
    {
        abort_if($template->user_id !== $request->user()->id, 403);

        return response()->json([
            'message' => 'Detail template berhasil diambil.',
            'data' => new TemplateResource($template->load(['user', 'software', 'category'])),
        ]);
    }

    public function update(Request $request, Template $template)
    {
        abort_if($template->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer|min:0',
            'file' => 'nullable|file',
            'preview' => 'nullable|image|max:2048',
            'preview_video' => 'nullable|mimetypes:video/mp4,video/webm,video/quicktime|max:20480',
            'software_id' => 'required|exists:software,id',
            'category_id' => 'required|exists:template_categories,id',
            'type' => 'required|in:video,photo',
        ]);

        if ($request->type === 'video' && ! $template->preview_video && ! $request->hasFile('preview_video')) {
            throw ValidationException::withMessages([
                'preview_video' => 'Preview video wajib diisi untuk template type video.',
            ]);
        }

        if ($request->hasFile('file')) {
            $this->deleteIfExists($template->file);
            $template->file = $this->storeTemplateFile($request);
        }

        if ($request->hasFile('preview')) {
            $this->deleteIfExists($template->preview);
            $template->preview = $request->file('preview')->store('templates/previews', 'public');
        }

        if ($request->hasFile('preview_video')) {
            $this->deleteIfExists($template->preview_video);
            $template->preview_video = $request->file('preview_video')->store('templates/previews/videos', 'public');
        }

        if ($request->type !== 'video' && $template->preview_video) {
            $this->deleteIfExists($template->preview_video);
            $template->preview_video = null;
        }

        $template->update([
            ...$validated,
            'file' => $template->file,
            'preview' => $template->preview,
            'preview_video' => $template->preview_video,
        ]);

        return response()->json([
            'message' => 'Template berhasil diperbarui.',
            'data' => new TemplateResource($template->fresh()->load(['user', 'software', 'category'])),
        ]);
    }

    public function destroy(Request $request, Template $template)
    {
        abort_if($template->user_id !== $request->user()->id, 403);

        foreach ([$template->file, $template->preview, $template->preview_video] as $path) {
            $this->deleteIfExists($path);
        }

        $template->delete();

        return response()->json([
            'message' => 'Template berhasil dihapus.',
        ]);
    }

    private function storeTemplateFile(Request $request): string
    {
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        $folder = 'templates/files/creator-' . $request->user()->id;
        $finalName = $originalName;
        $counter = 1;

        while (Storage::disk('public')->exists($folder . '/' . $finalName)) {
            $finalName = $filename . '(' . $counter . ').' . $extension;
            $counter++;
        }

        return $file->storeAs($folder, $finalName, 'public');
    }

    private function deleteIfExists(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
