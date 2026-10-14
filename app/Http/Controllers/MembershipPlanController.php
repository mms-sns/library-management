<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipPlanController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $this->authorize('viewAny', \App\Models\Membership::class);

        $plans = $user->isSuperAdmin()
            ? MembershipPlan::with('library')->latest()->paginate(10)
            : MembershipPlan::where('library_id', $user->library_id)->latest()->paginate(10);

        return view('memberships.plans.index', compact('plans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $this->authorize('create', \App\Models\Membership::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1|max:3650',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['library_id'] = $user->library_id;

        MembershipPlan::create($validated);

        return redirect()->route('membership-plans.index')
            ->with('status', 'Membership Plan created successfully.');
    }

    public function update(Request $request, MembershipPlan $membershipPlan): RedirectResponse
    {
        $this->authorize('create', \App\Models\Membership::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1|max:3650',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $membershipPlan->update($validated);

        return redirect()->route('membership-plans.index')
            ->with('status', 'Membership Plan updated successfully.');
    }
}
