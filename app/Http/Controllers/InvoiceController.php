<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\Student;
use App\Services\InvoiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $invoiceService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Invoice::class);
        $user = $request->user();

        $query = Invoice::with(['student', 'branch', 'membership.plan'])
            ->whereHas('branch', fn($q) => $user->isSuperAdmin() ? $q : $q->where('library_id', $user->library_id));

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('student', fn($sq) => $sq->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")->orWhere('student_number', 'like', "%{$search}%"));
            });
        }

        $invoices = $query->latest()->paginate(15)->withQueryString();

        // Calculate Totals
        $stats = [
            'total_issued' => Invoice::where('library_id', $user->library_id)->sum('total'),
            'total_paid' => Invoice::where('library_id', $user->library_id)->sum('paid_amount'),
            'total_pending' => Invoice::where('library_id', $user->library_id)->sum('balance_amount'),
        ];

        return view('fees.invoices.index', compact('invoices', 'stats'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Invoice::class);
        $user = $request->user();

        $branches = $user->isSuperAdmin()
            ? Branch::all()
            : Branch::where('library_id', $user->library_id)->get();

        $students = $user->isSuperAdmin()
            ? Student::where('status', 'active')->get()
            : Student::where('library_id', $user->library_id)->where('status', 'active')->get();

        $memberships = $user->isSuperAdmin()
            ? Membership::with(['student', 'plan'])->where('status', '!=', 'cancelled')->latest()->get()
            : Membership::where('library_id', $user->library_id)->with(['student', 'plan'])->where('status', '!=', 'cancelled')->latest()->get();

        $selectedStudentId = $request->input('student_id');
        $selectedMembershipId = $request->input('membership_id');

        if ($selectedMembershipId && $membership = $memberships->firstWhere('id', $selectedMembershipId)) {
            $selectedStudentId = $selectedStudentId ?: $membership->student_id;
        }

        return view('fees.invoices.create', compact('branches', 'students', 'memberships', 'selectedStudentId', 'selectedMembershipId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Invoice::class);
        $user = $request->user();

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'student_id' => 'required|exists:students,id',
            'membership_id' => 'nullable|exists:memberships,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|required_if:paid_amount,>0|in:cash,upi,bank_transfer,card,gateway,other',
            'transaction_reference' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $validated['library_id'] = $user->library_id;
        $validated['received_by'] = $user->id;

        $invoice = $this->invoiceService->createInvoice($validated, $validated['items']);

        return redirect()->route('invoices.show', $invoice)
            ->with('status', "Invoice #{$invoice->invoice_number} generated successfully.");
    }

    public function show(Invoice $invoice): View
    {
        $this->authorize('view', $invoice);
        $invoice->load(['student', 'branch', 'library.settings', 'items', 'payments.receiver']);

        return view('fees.invoices.show', compact('invoice'));
    }
}
