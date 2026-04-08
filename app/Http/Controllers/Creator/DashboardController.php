<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class DashboardController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        // Total template
        $totalTemplates = Template::where('user_id', $userId)->count();

        // Total download
        $totalDownloads = Template::where('user_id', $userId)->sum('download_count');

        // Total sales (hanya yang paid)
        $totalSales = Transaction::whereHas('template', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('status', 'paid')
            ->sum('total_price');

        // Average rating
        $averageRating = Template::where('user_id', $userId)
            ->avg('average_rating');

        // List template creator
        $templates = Template::where('user_id', $userId)->withCount(['transactions as soldCount' => function ($query) {
            $query->where('status', 'paid');
        }])
            ->latest()
            ->take(5)
            ->get();

        return view('creator.dashboard', compact(
            'totalTemplates',
            'totalDownloads',
            'totalSales',
            'averageRating',
            'templates'
        ));
    }
}
