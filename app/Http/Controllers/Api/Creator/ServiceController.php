<?php

namespace App\Http\Controllers\Api\Creator;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::with('user')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Daftar service creator berhasil diambil.',
            'data' => ServiceResource::collection($services),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $service = Service::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Service berhasil ditambahkan.',
            'data' => new ServiceResource($service->load('user')),
        ], 201);
    }

    public function show(Request $request, Service $service)
    {
        abort_if($service->user_id !== $request->user()->id, 403);

        return response()->json([
            'message' => 'Detail service berhasil diambil.',
            'data' => new ServiceResource($service->load('user')),
        ]);
    }

    public function update(Request $request, Service $service)
    {
        abort_if($service->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $service->update($validated);

        return response()->json([
            'message' => 'Service berhasil diperbarui.',
            'data' => new ServiceResource($service->fresh()->load('user')),
        ]);
    }

    public function destroy(Request $request, Service $service)
    {
        abort_if($service->user_id !== $request->user()->id, 403);

        $service->delete();

        return response()->json([
            'message' => 'Service berhasil dihapus.',
        ]);
    }
}
