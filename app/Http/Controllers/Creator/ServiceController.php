<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::where('user_id', auth()->id())->get();
        return view('creator.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('creator.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|integer|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        Service::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'status'      => $request->status,
        ]);

        return redirect()
            ->route('creator.service.index')
            ->with('success', 'Service berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $this->authorizeService($service);

        return view('creator.service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $this->authorizeService($service);

        return view('creator.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $this->authorizeService($service);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|integer|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        $service->update($request->only([
            'title',
            'description',
            'price',
            'status',
        ]));

        return redirect()
            ->route('creator.service.index')
            ->with('success', 'Service berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->authorizeService($service);

        $service->delete();

        return redirect()
            ->route('creator.service.index')
            ->with('success', 'Service berhasil dihapus');
    }

    private function authorizeService(Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
