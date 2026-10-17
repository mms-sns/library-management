<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Branch;
use App\Models\IDCard;
use App\Models\MembershipPlan;
use App\Models\Seat;
use App\Models\Student;
use App\Services\IDCardService;
use App\Services\StudentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function __construct(protected StudentService $studentService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Student::class);
        $user = $request->user();

        $query = Student::with([
            'guardian',
            'seat.seatType',
            'seat.branch',
            'invoices' => fn($q) => $q->where('status', '!=', 'cancelled')->latest(),
            'memberships' => fn($q) => $q->with('plan')->latest(),
        ])
            ->when(!$user->isSuperAdmin(), fn($q) => $q->where('library_id', $user->library_id));

        // Search Filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('student_number', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Fee / Overdue Status Filter
        if ($dueStatus = $request->input('due_status')) {
            if ($dueStatus === 'overdue') {
                $query->whereHas('invoices', function ($q) {
                    $q->where('balance_amount', '>', 0)
                      ->where('status', '!=', 'cancelled')
                      ->whereDate('due_date', '<', now()->toDateString());
                });
            } elseif ($dueStatus === 'pending') {
                $query->whereHas('invoices', function ($q) {
                    $q->where('balance_amount', '>', 0)
                      ->where('status', '!=', 'cancelled');
                });
            } elseif ($dueStatus === 'paid') {
                $query->whereDoesntHave('invoices', function ($q) {
                    $q->where('balance_amount', '>', 0)
                      ->where('status', '!=', 'cancelled');
                });
            }
        }

        $students = $query->latest()->paginate(12)->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Student::class);
        $user = $request->user();

        $branches = $user->isSuperAdmin()
            ? Branch::all()
            : Branch::where('library_id', $user->library_id)->get();

        $availableSeats = Seat::with(['branch', 'floor', 'room', 'seatType'])
            ->whereHas('branch', fn($q) => $user->isSuperAdmin() ? $q : $q->where('library_id', $user->library_id))
            ->where('status', 'available')
            ->orderBy('seat_number')
            ->get();

        $membershipPlans = $user->isSuperAdmin()
            ? MembershipPlan::where('status', 'active')->get()
            : MembershipPlan::where('library_id', $user->library_id)->where('status', 'active')->get();

        return view('students.create', compact('branches', 'availableSeats', 'membershipPlans'));
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        $validated['library_id'] = $user->library_id;
        $validated['received_by'] = $user->id;

        $student = $this->studentService->createStudent(
            $validated,
            $request->file('photo')
        );

        return redirect()->route('students.show', $student)
            ->with('status', "Student registered successfully with Number: {$student->student_number}");
    }

    public function show(Student $student): View
    {
        $this->authorize('view', $student);
        $student->load([
            'guardian',
            'seat.branch',
            'seat.floor',
            'seat.room',
            'seat.seatType',
            'memberships.plan',
            'invoices.payments',
            'activeIdCard.branch',
            'activeIdCard.library',
        ]);

        return view('students.show', compact('student'));
    }

    public function printIdCard(Request $request, Student $student, IDCardService $idCardService): RedirectResponse
    {
        $this->authorize('view', $student);

        $card = $student->activeIdCard;

        if (!$card) {
            $card = $idCardService->issueCard($student);
        }

        return redirect()->route('id-cards.show', [$card, 'print' => 1]);
    }

    public function edit(Request $request, Student $student): View
    {
        $this->authorize('update', $student);
        $user = $request->user();
        $student->load(['guardian', 'seat.branch', 'seat.floor', 'seat.room', 'seat.seatType']);

        $branches = $user->isSuperAdmin()
            ? Branch::all()
            : Branch::where('library_id', $user->library_id)->get();

        $availableSeats = Seat::with(['branch', 'floor', 'room', 'seatType'])
            ->whereHas('branch', fn($q) => $user->isSuperAdmin() ? $q : $q->where('library_id', $user->library_id))
            ->where(function ($q) use ($student) {
                $q->where('status', 'available');
                if ($student->seat_id) {
                    $q->orWhere('id', $student->seat_id);
                }
            })
            ->orderBy('seat_number')
            ->get();

        return view('students.edit', compact('student', 'branches', 'availableSeats'));
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $validated = $request->validated();

        $this->studentService->updateStudent(
            $student,
            $validated,
            $request->file('photo')
        );

        return redirect()->route('students.show', $student)
            ->with('status', 'Student profile updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $this->authorize('delete', $student);
        if ($student->seat_id) {
            Seat::where('id', $student->seat_id)->update(['status' => 'available']);
        }
        $student->delete();

        return redirect()->route('students.index')
            ->with('status', 'Student archived successfully.');
    }
}
