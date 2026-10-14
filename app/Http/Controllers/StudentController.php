<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
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

        $query = Student::with('guardian')
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

        $students = $query->latest()->paginate(12)->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Student::class);

        return view('students.create');
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        $validated['library_id'] = $user->library_id;

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
        $student->load('guardian');

        return view('students.show', compact('student'));
    }

    public function edit(Student $student): View
    {
        $this->authorize('update', $student);
        $student->load('guardian');

        return view('students.edit', compact('student'));
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
        $student->delete();

        return redirect()->route('students.index')
            ->with('status', 'Student archived successfully.');
    }
}
