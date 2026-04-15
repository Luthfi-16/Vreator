<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Software;
use App\Models\Template;
use App\Models\TemplateCategory;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'templates' => Template::count(),
            'services' => Service::count(),
            'activeServices' => Service::where('status', 'active')->count(),
            'softwares' => Software::count(),
            'categories' => TemplateCategory::count(),
            'creators' => User::where('role', 'creator')->count(),
            'users' => User::where('role', 'user')->count(),
            'paidTransactions' => Transaction::where('status', 'paid')->count(),
            'revenue' => Transaction::where('status', 'paid')->sum('total_price'),
            'downloads' => Template::sum('download_count'),
        ];

        $recentTemplates = Template::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recentServices = Service::with('user')
            ->latest()
            ->take(5)
            ->get();

        $topTemplates = Template::with('user')
            ->orderByDesc('download_count')
            ->orderByDesc('average_rating')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentTemplates',
            'recentServices',
            'topTemplates',
        ));
    }
}
