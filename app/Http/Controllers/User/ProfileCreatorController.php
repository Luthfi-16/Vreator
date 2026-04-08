<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;


class ProfileCreatorController extends Controller
{
    public function index(User $creator)
    {
        $templates = $creator->templates()
            ->with(['user', 'category'])
            ->where('status', 'active')
            ->latest()
            ->get();

        $services = $creator->services()
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('user.profile-creator', compact('creator', 'templates', 'services'));
    }
}
