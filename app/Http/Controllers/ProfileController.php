<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'          => 'required|string|max:255',
            'whatsapp'      => 'nullable|string|max:20',
            'bio'           => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->profile_photo = $request
                ->file('profile_photo')
                ->store('profiles', 'public');
        }

        $user->update([
            'name'     => $request->name,
            'whatsapp' => $request->whatsapp,
            'bio'      => $request->bio,
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Profile berhasil diperbarui');
    }
}
