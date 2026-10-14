<?php

namespace App\Http\Controllers;

use App\Models\SeatType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeatTypeController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $this->authorize('viewAny', \App\Models\Seat::class);

        $seatTypes = $user->isSuperAdmin()
            ? SeatType::with('library')->latest()->paginate(10)
            : SeatType::where('library_id', $user->library_id)->latest()->paginate(10);

        return view('seats.types.index', compact('seatTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $this->authorize('create', \App\Models\Seat::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'monthly_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['library_id'] = $user->library_id;

        SeatType::create($validated);

        return redirect()->route('seat-types.index')
            ->with('status', 'Seat Type created successfully.');
    }

    public function update(Request $request, SeatType $seatType): RedirectResponse
    {
        $this->authorize('create', \App\Models\Seat::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'monthly_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $seatType->update($validated);

        return redirect()->route('seat-types.index')
            ->with('status', 'Seat Type updated successfully.');
    }
}
