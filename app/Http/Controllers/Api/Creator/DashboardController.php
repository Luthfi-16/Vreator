<?php

namespace App\Http\Controllers\Api\Creator;

use App\Http\Controllers\Controller;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = $request->user()->id;

        $templates = Template::with(['user', 'category', 'software'])
            ->where('user_id', $userId)
            ->withCount(['transactions as sold_count' => function ($query) {
                $query->where('status', 'paid');
            }])
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'message' => 'Dashboard creator berhasil diambil.',
            'data' => [
                'stats' => [
                    'total_templates' => Template::where('user_id', $userId)->count(),
                    'total_downloads' => Template::where('user_id', $userId)->sum('download_count'),
                    'total_sales' => Transaction::whereHas('template', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })->where('status', 'paid')->sum('total_price'),
                    'average_rating' => round(
                        (float) Template::where('user_id', $userId)->avg('average_rating'),
                        2
                    ),
                ],
                'latest_templates' => TemplateResource::collection($templates),
            ],
        ]);
    }
}
