<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TemplateResource;
use App\Http\Resources\UserResource;
use App\Models\User;

class CreatorController extends Controller
{
    public function show(User $creator)
    {
        abort_unless($creator->role === 'creator', 404);

        $creator->load([
            'templates' => fn ($query) => $query->with(['user', 'category', 'software'])->latest(),
            'services' => fn ($query) => $query->where('status', 'active')->latest(),
        ]);

        return response()->json([
            'message' => 'Profil creator berhasil diambil.',
            'data' => [
                'creator' => new UserResource($creator),
                'templates' => TemplateResource::collection($creator->templates),
                'services' => ServiceResource::collection($creator->services),
            ],
        ]);
    }
}
