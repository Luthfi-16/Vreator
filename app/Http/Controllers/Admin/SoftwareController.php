<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Software;

class SoftwareController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $softwares = Software::latest()->get();
        return view('admin.software.index', compact('softwares'));
    }

    // Form tambah data
    public function create()
    {
        return view('admin.software.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Software::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.software.index')
            ->with('success', 'Software berhasil ditambahkan');
    }

    // Detail data (pakai slug)
    public function show(Software $software)
    {
        return view('admin.software.show', compact('software'));
    }

    // Form edit
    public function edit(Software $software)
    {
        return view('admin.software.edit', compact('software'));
    }

    // Update data
    public function update(Request $request, Software $software)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $software->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.software.index')
            ->with('success', 'Software berhasil diupdate');
    }

    // Hapus data
    public function destroy(Software $software)
    {
        $software->delete();

        return redirect()->route('admin.software.index')
            ->with('success', 'Software berhasil dihapus');
    }
}
