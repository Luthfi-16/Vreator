<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\TemplateCategoryResource;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use App\Models\TemplateCategory;
use App\Models\TemplateDownload;
use App\Models\TemplateRating;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $query = Template::with(['user', 'category', 'software']);

        if ($request->filled('search')) {
            $search = trim($request->string('search')->value());

            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($categoryQuery) use ($request) {
                $categoryQuery->where('slug', $request->string('category')->value());
            });
        }

        if ($request->filled('price')) {
            match ($request->string('price')->value()) {
                'free' => $query->where('price', 0),
                'paid' => $query->where('price', '>', 0),
                default => null,
            };
        }

        match ($request->get('sort', 'latest')) {
            'price_asc' => $query->orderBy('price')->orderByDesc('created_at'),
            'price_desc' => $query->orderByDesc('price')->orderByDesc('created_at'),
            'name_asc' => $query->orderBy('title'),
            default => $query->latest(),
        };

        $perPage = max(1, min((int) $request->get('per_page', 8), 50));
        $templates = $query->paginate($perPage)->withQueryString();

        return response()->json([
            'message' => 'Daftar template berhasil diambil.',
            'data' => TemplateResource::collection($templates->items()),
            'meta' => [
                'current_page' => $templates->currentPage(),
                'last_page' => $templates->lastPage(),
                'per_page' => $templates->perPage(),
                'total' => $templates->total(),
            ],
            'filters' => [
                'categories' => TemplateCategoryResource::collection(
                    TemplateCategory::orderBy('name')->get()
                ),
            ],
        ]);
    }

    public function show(Request $request, Template $template)
    {
        $template->load(['user', 'category', 'software']);

        $relatedTemplates = Template::with(['user', 'category', 'software'])
            ->where('user_id', $template->user_id)
            ->where('id', '!=', $template->id)
            ->latest()
            ->take(4)
            ->get();

        $hasDownloaded = false;
        $pendingTransaction = null;

        if ($request->user()?->role === 'user') {
            $hasDownloaded = TemplateDownload::where('user_id', $request->user()->id)
                ->where('template_id', $template->id)
                ->exists();

            $pendingTransaction = Transaction::where('user_id', $request->user()->id)
                ->where('template_id', $template->id)
                ->where('status', 'pending')
                ->latest()
                ->first();
        }

        return response()->json([
            'message' => 'Detail template berhasil diambil.',
            'data' => [
                'template' => new TemplateResource($template),
                'related_templates' => TemplateResource::collection($relatedTemplates),
                'has_downloaded' => $hasDownloaded,
                'pending_transaction' => $pendingTransaction ? [
                    'id' => $pendingTransaction->id,
                    'order_id' => $pendingTransaction->order_id,
                    'status' => $pendingTransaction->status,
                    'snap_token' => $pendingTransaction->snap_token,
                ] : null,
            ],
        ]);
    }

    public function rate(Request $request, Template $template)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $downloaded = TemplateDownload::where('user_id', $request->user()->id)
            ->where('template_id', $template->id)
            ->exists();

        abort_unless($downloaded, 403, 'Download dulu sebelum memberi rating');

        TemplateRating::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'template_id' => $template->id,
            ],
            $validated
        );

        $template->update([
            'average_rating' => $template->ratings()->avg('rating'),
            'rating_count' => $template->ratings()->count(),
        ]);

        return response()->json([
            'message' => 'Rating berhasil dikirim.',
            'data' => new TemplateResource($template->fresh(['user', 'category', 'software'])),
        ]);
    }

    public function download(Request $request, Template $template)
    {
        if (! Storage::disk('public')->exists($template->file)) {
            abort(404, 'File tidak ditemukan');
        }

        if ($template->price > 0) {
            $transaction = Transaction::where('user_id', $request->user()->id)
                ->where('template_id', $template->id)
                ->where('status', 'paid')
                ->first();

            abort_unless($transaction, 403, 'Template belum dibayar');
        }

        $download = TemplateDownload::firstOrCreate([
            'user_id' => $request->user()->id,
            'template_id' => $template->id,
        ]);

        if ($download->wasRecentlyCreated) {
            $template->increment('download_count');
        }

        return response()->json([
            'message' => 'Link download template berhasil dibuat.',
            'data' => [
                'file_name' => basename($template->file),
                'download_url' => Storage::disk('public')->url($template->file),
            ],
        ]);
    }
}
