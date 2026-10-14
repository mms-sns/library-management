<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Floor;
use App\Models\Room;
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

        $floors = Floor::where('branch_id', $selectedBranchId)->get();
        $rooms = Room::where('branch_id', $selectedBranchId)->get();

        $query = Seat::with(['seatType', 'floor', 'room'])
            ->where('branch_id', $selectedBranchId);

        if ($floorId = $request->input('floor_id')) {
            $query->where('floor_id', $floorId);
        }

        if ($roomId = $request->input('room_id')) {
            $query->where('room_id', $roomId);
        }

        $seats = $query->orderBy('seat_number')->get();

        // Calculate Occupancy Metrics
        $totalSeats = $seats->count();
        $availableSeats = $seats->where('status', 'available')->count();
        $occupiedSeats = $seats->where('status', 'occupied')->count();
        $reservedSeats = $seats->where('status', 'reserved')->count();
        $maintenanceSeats = $seats->where('status', 'maintenance')->count();

        $occupancyRate = $totalSeats > 0 ? round(($occupiedSeats / $totalSeats) * 100, 1) : 0;

        return view('seats.map', compact(
            'branches',
            'selectedBranchId',
            'floors',
            'rooms',
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
