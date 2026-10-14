<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Services\InvoiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(protected InvoiceService $invoiceService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Payment::class);
        $user = $request->user();

        $query = Payment::with(['student', 'invoice', 'receiver'])
            ->whereHas('branch', fn($q) => $user->isSuperAdmin() ? $q : $q->where('library_id', $user->library_id));

        if ($method = $request->input('payment_method')) {
            $query->where('payment_method', $method);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('fees.payments.index', compact('payments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Payment::class);
        $user = $request->user();

        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,upi,bank_transfer,card,gateway,other',
            'transaction_reference' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $invoice = Invoice::findOrFail($validated['invoice_id']);

        if ($user->library_id && $invoice->library_id !== $user->library_id) {
            abort(403, 'Unauthorized invoice tenant access.');
        }

        $validated['received_by'] = $user->id;

        $payment = $this->invoiceService->recordPayment($invoice, $validated);

        return redirect()->route('invoices.show', $invoice)
            ->with('status', "Payment #{$payment->payment_number} of ₹" . number_format($payment->amount, 2) . " recorded successfully.");
    }

    public function show(Payment $payment): View
    {
        $this->authorize('view', $payment);
        $payment->load(['student', 'invoice', 'library.settings', 'receiver', 'branch']);

        return view('fees.payments.show', compact('payment'));
    }
}
