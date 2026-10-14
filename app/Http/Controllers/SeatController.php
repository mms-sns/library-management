<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Seat;
use App\Models\SeatType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SeatController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Seat::class);
        $user = $request->user();

        $query = Seat::with(['branch', 'floor', 'room', 'seatType'])
            ->whereHas('branch', fn($q) => $user->isSuperAdmin() ? $q : $q->where('library_id', $user->library_id));

        if ($branchId = $request->input('branch_id')) {
            $query->where('branch_id', $branchId);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $seats = $query->orderBy('seat_number')->paginate(20)->withQueryString();

        $branches = $user->isSuperAdmin()
            ? Branch::all()
            : Branch::where('library_id', $user->library_id)->get();

        return view('seats.index', compact('seats', 'branches'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Seat::class);
        $user = $request->user();

        $branches = $user->isSuperAdmin()
            ? Branch::all()
            : Branch::where('library_id', $user->library_id)->get();

        $seatTypes = $user->isSuperAdmin()
            ? SeatType::all()
            : SeatType::where('library_id', $user->library_id)->get();

        $floors = Floor::whereIn('branch_id', $branches->pluck('id'))->get();
        $rooms = Room::whereIn('branch_id', $branches->pluck('id'))->get();

        return view('seats.create', compact('branches', 'seatTypes', 'floors', 'rooms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Seat::class);

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'floor_id' => 'nullable|exists:floors,id',
            'room_id' => 'nullable|exists:rooms,id',
            'seat_type_id' => 'required|exists:seat_types,id',
            'seat_number' => 'required|string|max:50',
            'status' => 'required|in:available,occupied,reserved,maintenance,inactive',
        ]);

        Seat::create($validated);

        return redirect()->route('seats.index')
            ->with('status', "Seat {$validated['seat_number']} created successfully.");
    }

    public function generateBulk(Request $request): RedirectResponse
    {
        $this->authorize('create', Seat::class);

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'floor_id' => 'nullable|exists:floors,id',
            'room_id' => 'nullable|exists:rooms,id',
            'seat_type_id' => 'required|exists:seat_types,id',
            'prefix' => 'required|string|max:10', // e.g. A- or CAB-
            'start_num' => 'required|integer|min:1',
            'end_num' => 'required|integer|gte:start_num|max:500',
        ]);

        $createdCount = DB::transaction(function () use ($validated) {
            $count = 0;
            for ($i = $validated['start_num']; $i <= $validated['end_num']; $i++) {
                $seatNumber = sprintf('%s%02d', $validated['prefix'], $i);

                Seat::firstOrCreate(
                    [
                        'branch_id' => $validated['branch_id'],
                        'seat_number' => $seatNumber,
                    ],
                    [
                        'floor_id' => $validated['floor_id'] ?? null,
                        'room_id' => $validated['room_id'] ?? null,
                        'seat_type_id' => $validated['seat_type_id'],
                        'status' => 'available',
                    ]
                );
                $count++;
            }
            return $count;
        });

        return redirect()->route('seats.index')
            ->with('status', "Generated {$createdCount} seats successfully.");
    }

    public function updateStatus(Request $request, Seat $seat): RedirectResponse
    {
        $this->authorize('update', $seat);

        $validated = $request->validate([
            'status' => 'required|in:available,occupied,reserved,maintenance,inactive',
        ]);

        $seat->update(['status' => $validated['status']]);

        return back()->with('status', "Seat {$seat->seat_number} status updated to {$seat->status}.");
    }

    public function destroy(Seat $seat): RedirectResponse
    {
        $this->authorize('delete', $seat);
        $seat->delete();

        return redirect()->route('seats.index')
            ->with('status', 'Seat archived successfully.');
    }
}
