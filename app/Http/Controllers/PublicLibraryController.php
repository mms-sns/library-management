<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\MembershipPlan;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicLibraryController extends Controller
{
    public function show(Request $request, string $slug): View
    {
        $library = Library::where('slug', $slug)
            ->with(['settings', 'branches', 'landingPage'])
            ->firstOrFail();

        if ($library->status !== 'active') {
            abort(404, 'Study center not available.');
        }

        $landingPage = $library->landingPage;
        $isEnabled = $landingPage && $landingPage->is_enabled;

        // Allow preview mode for the library owner or super admin even if disabled
        $user = $request->user();
        $canPreview = $user && ($user->isSuperAdmin() || $user->library_id === $library->id);

        if (!$isEnabled && !$canPreview) {
            return view('public.library-disabled', compact('library'));
        }

        $isPreview = !$isEnabled && $canPreview;

        // Fetch active membership plans
        $membershipPlans = collect();
        if (!$landingPage || $landingPage->show_pricing) {
            $membershipPlans = MembershipPlan::where('library_id', $library->id)
                ->where('status', 'active')
                ->orderBy('price', 'asc')
                ->get();
        }

        // Live Seat Stats
        $seatStats = [
            'total' => 0,
            'available' => 0,
            'occupied' => 0,
        ];

        if (!$landingPage || $landingPage->show_seats_status) {
            $branchIds = $library->branches->pluck('id');
            $totalSeats = Seat::whereIn('branch_id', $branchIds)->where('status', '!=', 'maintenance')->count();
            $availableSeats = Seat::whereIn('branch_id', $branchIds)->where('status', 'available')->count();
            $occupiedSeats = Seat::whereIn('branch_id', $branchIds)->where('status', 'occupied')->count();

            $seatStats = [
                'total' => $totalSeats,
                'available' => $availableSeats,
                'occupied' => $occupiedSeats,
            ];
        }

        return view('public.library-landing', compact(
            'library',
            'landingPage',
            'membershipPlans',
            'seatStats',
            'isPreview'
        ));
    }
}
