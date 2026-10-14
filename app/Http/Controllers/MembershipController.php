<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Student;
use App\Services\MembershipService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function __construct(protected MembershipService $membershipService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Membership::class);
        $user = $request->user();

        $query = Membership::with(['student', 'branch', 'plan'])
            ->whereHas('branch', fn($q) => $user->isSuperAdmin() ? $q : $q->where('library_id', $user->library_id));

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($studentId = $request->input('student_id')) {
            $query->where('student_id', $studentId);
        }

        $memberships = $query->latest()->paginate(15)->withQueryString();

        return view('memberships.index', compact('memberships'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Membership::class);
        $user = $request->user();

        $branches = $user->isSuperAdmin()
            ? Branch::all()
            : Branch::where('library_id', $user->library_id)->get();

        $plans = $user->isSuperAdmin()
            ? MembershipPlan::where('status', 'active')->get()
            : MembershipPlan::where('library_id', $user->library_id)->where('status', 'active')->get();

        $students = $user->isSuperAdmin()
            ? Student::where('status', 'active')->get()
            : Student::where('library_id', $user->library_id)->where('status', 'active')->get();

        $preselectedStudentId = $request->input('student_id');

        return view('memberships.create', compact('branches', 'plans', 'students', 'preselectedStudentId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Membership::class);
        $user = $request->user();

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'student_id' => 'required|exists:students,id',
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'start_date' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,pending',
            'notes' => 'nullable|string',
        ]);

        $validated['library_id'] = $user->library_id;

        $membership = $this->membershipService->createMembership($validated);

        return redirect()->route('memberships.index')
            ->with('status', "Membership #{$membership->id} created successfully for student.");
    }

    public function renew(Request $request, Membership $membership): RedirectResponse
    {
        $this->authorize('renew', $membership);

        $validated = $request->validate([
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $newMembership = $this->membershipService->renewMembership(
            $membership,
            $validated['membership_plan_id'],
            $validated['discount'] ?? 0.00,
            $validated['notes'] ?? null
        );

        return redirect()->route('memberships.index')
            ->with('status', "Membership renewed successfully! New Period: {$newMembership->start_date->format('d-m-Y')} to {$newMembership->end_date->format('d-m-Y')}");
    }

    public function cancel(Request $request, Membership $membership): RedirectResponse
    {
        $this->authorize('cancel', $membership);

        $membership->update([
            'status' => 'cancelled',
            'notes' => trim($membership->notes . ' | Cancelled on ' . now()->format('Y-m-d H:i')),
        ]);

        return redirect()->route('memberships.index')
            ->with('status', "Membership #{$membership->id} has been cancelled.");
    }
}
