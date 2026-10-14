<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('invoices.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                    ← Invoices
                </a>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Invoice #{{ $invoice->invoice_number }}
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="inline-flex items-center gap-1.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-4 py-2 font-semibold text-xs text-gray-700 dark:text-bodydark hover:bg-gray-200 dark:hover:bg-strokedark transition">
                    🖨️ Print Invoice
                </button>
                @if($invoice->balance_amount > 0)
                    <button @click="showPaymentModal = true" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-4 py-2 font-semibold text-xs text-white shadow hover:bg-emerald-700 transition">
                        💳 Record Payment
                    </button>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6" x-data="{ showPaymentModal: false }">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Printable Tax Invoice Document Card -->
        <div class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-8 print:border-none print:shadow-none print:p-0">

            <!-- Header Header Block -->
            <div class="flex flex-col sm:flex-row justify-between items-start border-b border-stroke dark:border-strokedark pb-6 gap-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-black dark:text-white tracking-wide">{{ $invoice->library->name }}</h1>
                    <p class="text-xs text-gray-500 dark:text-bodydark mt-1">{{ $invoice->branch->address }}, {{ $invoice->branch->city }}</p>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Phone: {{ $invoice->branch->phone ?? $invoice->library->mobile }} | Email: {{ $invoice->library->email }}</p>
                    @if($invoice->library->settings && $invoice->library->settings->gst_enabled && $invoice->library->settings->gst_number)
                        <p class="text-xs font-mono font-semibold text-indigo-600 dark:text-indigo-400 mt-1">GSTIN: {{ $invoice->library->settings->gst_number }}</p>
                    @endif
                </div>

                <div class="text-left sm:text-right">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">TAX INVOICE</span>
                    <h3 class="text-2xl font-mono font-bold text-primary">{{ $invoice->invoice_number }}</h3>
                    <div class="mt-2 text-xs font-mono text-gray-500 dark:text-bodydark space-y-0.5">
                        <p>Date: <strong class="text-black dark:text-white">{{ $invoice->invoice_date->format('d M Y') }}</strong></p>
                        <p>Due Date: <strong class="text-black dark:text-white">{{ $invoice->due_date->format('d M Y') }}</strong></p>
                    </div>
                </div>
            </div>

            <!-- Bill To & Status Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-boxdark-2 p-5 rounded-2xl border border-stroke dark:border-strokedark">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Billed To (Student)</span>
                    <h4 class="text-base font-bold text-black dark:text-white mt-1">{{ $invoice->student->full_name }}</h4>
                    <p class="text-xs font-mono text-primary font-bold">Student ID: {{ $invoice->student->student_number }}</p>
                    <p class="text-xs text-gray-500 dark:text-bodydark mt-1">Mobile: {{ $invoice->student->mobile }}</p>
                    @if($invoice->student->email)
                        <p class="text-xs text-gray-500 dark:text-bodydark">Email: {{ $invoice->student->email }}</p>
                    @endif
                </div>

                <div class="md:text-right flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Invoice Status</span>
                        <div class="mt-1">
                            @php
                                $statusColors = [
                                    'paid' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                                    'partially_paid' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                                    'issued' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300',
                                    'overdue' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300',
                                ];
                            @endphp
                            <span class="px-3.5 py-1 text-xs font-semibold rounded-full uppercase {{ $statusColors[$invoice->status] ?? '' }}">
                                {{ str_replace('_', ' ', $invoice->status) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400">Branch: <strong>{{ $invoice->branch->name }}</strong></span>
                    </div>
                </div>
            </div>

            <!-- Line Items Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                    <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                        <tr>
                            <th class="p-3">#</th>
                            <th class="p-3">Item Description</th>
                            <th class="p-3 text-center">Qty</th>
                            <th class="p-3 text-right">Unit Price</th>
                            <th class="p-3 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stroke dark:divide-strokedark">
                        @foreach($invoice->items as $index => $item)
                            <tr>
                                <td class="p-3 font-mono text-xs">{{ $index + 1 }}</td>
                                <td class="p-3 font-semibold text-black dark:text-white">{{ $item->description }}</td>
                                <td class="p-3 text-center font-mono font-bold">{{ $item->quantity }}</td>
                                <td class="p-3 text-right font-mono">₹{{ number_format($item->unit_price, 2) }}</td>
                                <td class="p-3 text-right font-mono font-bold text-black dark:text-white">₹{{ number_format($item->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total Calculation Summary Block -->
            <div class="flex justify-end pt-4 border-t border-stroke dark:border-strokedark">
                <div class="w-full sm:w-72 space-y-2 text-xs">
                    <div class="flex justify-between text-gray-600 dark:text-bodydark">
                        <span>Subtotal:</span>
                        <span class="font-mono font-bold text-black dark:text-white">₹{{ number_format($invoice->subtotal, 2) }}</span>
                    </div>

                    @if($invoice->discount > 0)
                        <div class="flex justify-between text-emerald-600 dark:text-emerald-400">
                            <span>Discount:</span>
                            <span class="font-mono font-bold">-₹{{ number_format($invoice->discount, 2) }}</span>
                        </div>
                    @endif

                    @if($invoice->tax > 0)
                        <div class="flex justify-between text-gray-600 dark:text-bodydark">
                            <span>GST Tax:</span>
                            <span class="font-mono font-bold text-black dark:text-white">₹{{ number_format($invoice->tax, 2) }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between border-t border-stroke dark:border-strokedark pt-2 text-base font-bold text-black dark:text-white">
                        <span>Total Amount:</span>
                        <span class="font-mono text-primary">₹{{ number_format($invoice->total, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-emerald-600 dark:text-emerald-400 font-semibold pt-1">
                        <span>Paid Amount:</span>
                        <span class="font-mono font-bold">₹{{ number_format($invoice->paid_amount, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-amber-600 dark:text-amber-400 font-bold border-t border-dashed border-stroke dark:border-strokedark pt-1">
                        <span>Balance Due:</span>
                        <span class="font-mono text-lg">₹{{ number_format($invoice->balance_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Transaction History -->
            @if($invoice->payments->isNotEmpty())
                <div class="border-t border-stroke dark:border-strokedark pt-6 space-y-3">
                    <h4 class="text-sm font-bold text-black dark:text-white">Payment Transaction History</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-600 dark:text-bodydark1">
                            <thead class="bg-gray-50 dark:bg-boxdark-2 uppercase font-semibold text-gray-500 dark:text-bodydark">
                                <tr>
                                    <th class="p-2.5">Payment #</th>
                                    <th class="p-2.5">Date & Time</th>
                                    <th class="p-2.5">Method</th>
                                    <th class="p-2.5">Txn Reference</th>
                                    <th class="p-2.5">Amount</th>
                                    <th class="p-2.5">Received By</th>
                                    <th class="p-2.5 text-right">Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stroke dark:divide-strokedark">
                                @foreach($invoice->payments as $pm)
                                    <tr>
                                        <td class="p-2.5 font-mono font-bold text-primary">{{ $pm->payment_number }}</td>
                                        <td class="p-2.5 font-mono">{{ $pm->payment_date->format('d-m-Y H:i') }}</td>
                                        <td class="p-2.5 uppercase font-semibold">{{ $pm->payment_method }}</td>
                                        <td class="p-2.5 font-mono">{{ $pm->transaction_reference ?? 'N/A' }}</td>
                                        <td class="p-2.5 font-mono font-bold text-emerald-600 dark:text-emerald-400">₹{{ number_format($pm->amount, 2) }}</td>
                                        <td class="p-2.5">{{ $pm->receiver->name ?? 'System' }}</td>
                                        <td class="p-2.5 text-right">
                                            <a href="{{ route('payments.show', $pm) }}" class="text-primary hover:underline font-semibold">Print Receipt</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>

        <!-- Record Payment Modal -->
        <div x-show="showPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div class="w-full max-w-md rounded-2xl border border-stroke bg-white p-6 shadow-xl dark:border-strokedark dark:bg-boxdark space-y-4" @click.outside="showPaymentModal = false">
                <div>
                    <h3 class="text-base font-bold text-black dark:text-white">Record Payment Transaction</h3>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Invoice: <strong class="text-primary font-mono">{{ $invoice->invoice_number }}</strong> | Outstanding: <strong class="text-amber-600 font-mono">₹{{ number_format($invoice->balance_amount, 2) }}</strong></p>
                </div>

                <form method="POST" action="{{ route('payments.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Payment Amount (INR ₹) *</label>
                        <input type="number" step="0.01" name="amount" value="{{ $invoice->balance_amount }}" max="{{ $invoice->balance_amount }}" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Payment Method *</label>
                        <select name="payment_method" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                            <option value="cash">Cash</option>
                            <option value="upi">UPI / QR Scan</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Credit/Debit Card</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Transaction Reference / UTR</label>
                        <input type="text" name="transaction_reference" placeholder="e.g. UPI/1234567890" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Payment Date & Time *</label>
                        <input type="datetime-local" name="payment_date" value="{{ date('Y-m-d\TH:i') }}" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-stroke dark:border-strokedark">
                        <button type="button" @click="showPaymentModal = false" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-xs font-semibold text-white hover:bg-emerald-700">Confirm Payment</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
