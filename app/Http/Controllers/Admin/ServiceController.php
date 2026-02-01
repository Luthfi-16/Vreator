<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of all services (admin).
     */
    public function index()
    {
        $services = Service::with('user')
            ->latest()
            ->get();

        return view('admin.service.index', compact('services'));
    }

    /**
     * Show the specified service (optional).
     */
    public function show(Service $service)
    {
        return view('admin.service.show', compact('service'));
    }

    /**
     * Update service status (moderation).
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $service->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.service.index')
            ->with('success', 'Service status berhasil diperbarui.');
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.service.index')
            ->with('success', 'Service berhasil dihapus.');
    }
}
