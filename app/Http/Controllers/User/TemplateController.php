<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\TemplateCategory;
use App\Models\TemplateDownload;
use App\Models\TemplateRating;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['download', 'rate']);
    }

    public function index(Request $request)
    {
        $query = Template::with(['user', 'category']);

        if ($request->filled('search')) {
            $search = trim($request->search);

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
                $categoryQuery->where('slug', $request->category);
            });
        }

        if ($request->filled('price')) {
            match ($request->price) {
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

        $templates = $query->paginate(8)->withQueryString();
        $categories = TemplateCategory::orderBy('name')->get();

        return view('user.listtemplate', compact('templates', 'categories'));
    }

    public function show(Template $template)
    {
        $relatedTemplates = Template::where('user_id', $template->user_id)
            ->where('id', '!=', $template->id)
            ->latest()
            ->take(4)
            ->get();

        $hasDownloaded = false;
        $pendingTransaction = null;

        if (Auth::check()) {
            $hasDownloaded = TemplateDownload::where('user_id', Auth::id())
                ->where('template_id', $template->id)
                ->exists();

            $pendingTransaction = Transaction::where('user_id', Auth::id())
                ->where('template_id', $template->id)
                ->where('status', 'pending')
                ->latest()
                ->first();
        }

        return view('user.template-detail', compact(
            'template',
            'relatedTemplates',
            'hasDownloaded',
            'pendingTransaction'
        ));
    }

    public function download(Template $template)
    {
        if (! Storage::disk('public')->exists($template->file)) {
            abort(404, 'File tidak ditemukan');
        }

        // Jika berbayar, cek transaksi
        if ($template->price > 0) {
            $transaction = Transaction::where('user_id', Auth::id())
                ->where('template_id', $template->id)
                ->where('status', 'paid')
                ->first();

            if (! $transaction) {
                abort(403, 'Template belum dibayar');
            }
        }

        // 🔥 Simpan riwayat & cek apakah baru
        $download = TemplateDownload::firstOrCreate([
            'user_id'     => Auth::id(),
            'template_id' => $template->id,
        ]);

        // 🔥 Increment hanya jika pertama kali download
        if ($download->wasRecentlyCreated) {
            $template->increment('download_count');
        }

        return Storage::disk('public')->download(
            $template->file,
            basename($template->file)
        );
    }

    public function rate(Request $request, Template $template)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $downloaded = TemplateDownload::where('user_id', Auth::id())
            ->where('template_id', $template->id)
            ->exists();

        if (! $downloaded) {
            abort(403, 'Download dulu sebelum memberi rating');
        }

        TemplateRating::updateOrCreate(
            [
                'user_id'     => Auth::id(),
                'template_id' => $template->id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        // 🔥 Update summary rating (kalau ada kolomnya)
        $template->update([
            'average_rating' => $template->ratings()->avg('rating'),
            'rating_count'   => $template->ratings()->count(),
        ]);

        return back()->with('success', 'Rating berhasil dikirim!');
    }
}
