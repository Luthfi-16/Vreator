<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Template;
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

    public function index()
    {
        $templates = Template::with('user')
            ->where('status', 'active')
            ->latest()
            ->paginate(12);

        return view('user.listtemplate', compact('templates'));
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
