<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\IDCard;
use App\Models\Student;
use App\Services\IDCardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IDCardController extends Controller
{
    public function __construct(protected IDCardService $idCardService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', IDCard::class);
        $user = $request->user();

        $query = IDCard::with(['student', 'branch', 'library'])
            ->whereHas('branch', fn($q) => $user->isSuperAdmin() ? $q : $q->where('library_id', $user->library_id));

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('card_number', 'like', "%{$search}%")
                  ->orWhereHas('student', fn($sq) => $sq->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('student_number', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($branchId = $request->input('branch_id')) {
            $query->where('branch_id', $branchId);
        }

        $idCards = $query->latest()->paginate(15)->withQueryString();

        $branches = $user->isSuperAdmin()
            ? Branch::all()
            : Branch::where('library_id', $user->library_id)->get();

        return view('id_cards.index', compact('idCards', 'branches'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', IDCard::class);
        $user = $request->user();

        $students = $user->isSuperAdmin()
            ? Student::where('status', 'active')->get()
            : Student::where('library_id', $user->library_id)->where('status', 'active')->get();

        $selectedStudentId = $request->input('student_id');

        return view('id_cards.create', compact('students', 'selectedStudentId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', IDCard::class);
        $user = $request->user();

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:issue_date',
            'notes' => 'nullable|string|max:255',
        ]);

        $student = Student::findOrFail($validated['student_id']);

        if ($user->library_id && $student->library_id !== $user->library_id) {
            abort(403, 'Unauthorized student tenant access.');
        }

        $card = $this->idCardService->issueCard($student, $validated);

        return redirect()->route('id-cards.show', $card)
            ->with('status', "ID Card #{$card->card_number} issued successfully for {$student->full_name}.");
    }

    public function show(IDCard $idCard): View
    {
        $this->authorize('view', $idCard);
        $idCard->load(['student', 'branch', 'library.settings']);

        $qrSvg = $this->idCardService->getQrSvg($idCard, 140);

        return view('id_cards.show', compact('idCard', 'qrSvg'));
    }

    public function batchPrint(Request $request): View
    {
        $this->authorize('viewAny', IDCard::class);
        $user = $request->user();

        $cardIds = $request->input('card_ids');
        $query = IDCard::with(['student', 'branch', 'library.settings'])
            ->where('status', 'active')
            ->whereHas('branch', fn($q) => $user->isSuperAdmin() ? $q : $q->where('library_id', $user->library_id));

        if (!empty($cardIds) && is_array($cardIds)) {
            $query->whereIn('id', $cardIds);
        }

        $idCards = $query->latest()->take(20)->get();

        $qrSvgs = [];
        foreach ($idCards as $card) {
            $qrSvgs[$card->id] = $this->idCardService->getQrSvg($card, 110);
        }

        return view('id_cards.batch_print', compact('idCards', 'qrSvgs'));
    }

    public function revoke(Request $request, IDCard $idCard): RedirectResponse
    {
        $this->authorize('revoke', $idCard);

        $reason = $request->input('reason', 'Revoked by administrator');
        $this->idCardService->revokeCard($idCard, $reason);

        return redirect()->route('id-cards.index')
            ->with('status', "ID Card #{$idCard->card_number} has been revoked.");
    }
}
