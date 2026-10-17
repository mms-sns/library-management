<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeatMapController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $this->authorize('viewAny', Seat::class);

        $branches = $user->isSuperAdmin()
            ? Branch::all()
            : Branch::where('library_id', $user->library_id)->get();

        $selectedBranchId = $request->input('branch_id', $branches->first()?->id);

        $query = Seat::with(['student'])
            ->where('branch_id', $selectedBranchId);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->where('seat_number', 'like', "%{$search}%");
        }

        $seats = $query->orderBy('seat_number')->get();

        // Calculate Occupancy Metrics for selected branch
        $allBranchSeats = Seat::where('branch_id', $selectedBranchId)->get();
        $totalSeats = $allBranchSeats->count();
        $availableSeats = $allBranchSeats->where('status', 'available')->count();
        $occupiedSeats = $allBranchSeats->where('status', 'occupied')->count();
        $reservedSeats = $allBranchSeats->where('status', 'reserved')->count();
        $maintenanceSeats = $allBranchSeats->where('status', 'maintenance')->count();

        $occupancyRate = $totalSeats > 0 ? round(($occupiedSeats / $totalSeats) * 100, 1) : 0;

        return view('seats.map', compact(
            'branches',
            'selectedBranchId',
            'seats',
            'totalSeats',
            'availableSeats',
            'occupiedSeats',
            'reservedSeats',
            'maintenanceSeats',
            'occupancyRate'
        ));
    }
}
