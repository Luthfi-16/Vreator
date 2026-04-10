<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\TemplateDownload;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $auth = Auth::user();

        $topTemplates = Template::query()
            ->where('average_rating', '>=', 4.5)
            ->orderBy('average_rating', 'desc')
            ->orderBy('download_count', 'desc')
            ->take(8)
            ->get();

        $completedOrders = Transaction::where('user_id', $auth->id)
            ->where('status', 'paid')
            ->count();

        $pendingOrders = Transaction::where('user_id', $auth->id)
            ->where('status', 'pending')
            ->count();

        $totalDownloads = TemplateDownload::where('user_id', $auth->id)->count();

        return view('user.home', compact(
            'topTemplates',
            'auth',
            'completedOrders',
            'pendingOrders',
            'totalDownloads'
        ));
    }
}
