<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Student;
use App\Services\AttendanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Attendance::class);
        $user = $request->user();

        $selectedDate = $request->input('date', now()->toDateString());

        $query = Attendance::with(['student', 'branch', 'seat', 'idCard'])
            ->whereHas('branch', fn($q) => $user->isSuperAdmin() ? $q : $q->where('library_id', $user->library_id))
            ->whereDate('check_in_at', $selectedDate);

        if ($search = $request->input('search')) {
            $query->whereHas('student', fn($sq) => $sq->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('student_number', 'like', "%{$search}%"));
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($branchId = $request->input('branch_id')) {
            $query->where('branch_id', $branchId);
        }

        $attendances = $query->latest('check_in_at')->paginate(20)->withQueryString();

        $statsQuery = Attendance::whereHas('branch', fn($q) => $user->isSuperAdmin() ? $q : $q->where('library_id', $user->library_id))
            ->whereDate('check_in_at', $selectedDate);

        $stats = [
            'present_now' => (clone $statsQuery)->where('status', 'present')->count(),
            'total_checkins' => (clone $statsQuery)->count(),
            'checked_out' => (clone $statsQuery)->where('status', 'checked_out')->count(),
        ];

        $branches = $user->isSuperAdmin()
            ? Branch::all()
            : Branch::where('library_id', $user->library_id)->get();

        $activeStudents = $user->isSuperAdmin()
            ? Student::where('status', 'active')->get()
            : Student::where('library_id', $user->library_id)->where('status', 'active')->get();

        return view('attendances.index', compact('attendances', 'stats', 'branches', 'activeStudents', 'selectedDate'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Attendance::class);
        $user = $request->user();

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'branch_id' => 'nullable|exists:branches,id',
            'notes' => 'nullable|string|max:255',
        ]);

        $student = Student::findOrFail($validated['student_id']);

        if ($user->library_id && $student->library_id !== $user->library_id) {
            abort(403, 'Unauthorized student tenant access.');
        }

        $attendance = $this->attendanceService->checkIn($student, [
            'branch_id' => $validated['branch_id'] ?? null,
            'method' => 'manual',
            'notes' => $validated['notes'] ?? 'Manual Check-in by Staff',
        ]);

        return redirect()->route('attendances.index')
            ->with('status', "{$student->full_name} checked in successfully at {$attendance->check_in_at->format('h:i A')}.");
    }

    public function checkOut(Request $request, Attendance $attendance): RedirectResponse
    {
        $this->authorize('update', $attendance);

        $this->attendanceService->checkOut($attendance, [
            'notes' => $request->input('notes'),
        ]);

        return redirect()->route('attendances.index')
            ->with('status', "{$attendance->student->full_name} checked out at " . now()->format('h:i A') . ".");
    }
}
