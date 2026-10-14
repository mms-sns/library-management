<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            $stats = [
                'total_libraries' => Library::count(),
                'active_libraries' => Library::where('status', 'active')->count(),
                'total_branches' => Branch::count(),
                'total_users' => User::count(),
            ];
            $libraries = Library::withCount('branches')->latest()->take(5)->get();

            return view('dashboard.superadmin', compact('stats', 'libraries'));
        }

        $library = $user->library;

        if (!$library) {
            abort(403, 'User is not assigned to any library tenant.');
        }

        $stats = [
            'total_branches' => $library->branches()->count(),
            'active_branches' => $library->branches()->where('status', 'active')->count(),
            'total_staff' => User::where('library_id', $library->id)->count(),
        ];

        $branches = $library->branches()->latest()->get();

        return view('dashboard', compact('library', 'stats', 'branches'));
    }
}
