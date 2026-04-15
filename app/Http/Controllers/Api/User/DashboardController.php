<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\TemplateResource;
use App\Http\Resources\UserResource;
use App\Models\Template;
use App\Models\TemplateDownload;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $topTemplates = Template::with(['user', 'category', 'software'])
            ->where('average_rating', '>=', 4.5)
            ->orderByDesc('average_rating')
            ->orderByDesc('download_count')
            ->take(8)
            ->get();

        return response()->json([
            'message' => 'Dashboard user berhasil diambil.',
            'data' => [
                'user' => new UserResource($user),
                'stats' => [
                    'completed_orders' => Transaction::where('user_id', $user->id)
                        ->where('status', 'paid')
                        ->count(),
                    'pending_orders' => Transaction::where('user_id', $user->id)
                        ->where('status', 'pending')
                        ->count(),
                    'total_downloads' => TemplateDownload::where('user_id', $user->id)->count(),
                ],
                'top_templates' => TemplateResource::collection($topTemplates),
            ],
        ]);
    }
}
