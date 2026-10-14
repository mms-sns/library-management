<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('payments.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                    ← Payments
                </a>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Payment Receipt #{{ $payment->payment_number }}
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="inline-flex items-center gap-1.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-4 py-2 font-semibold text-xs text-gray-700 dark:text-bodydark hover:bg-gray-200 dark:hover:bg-strokedark transition">
                    🖨️ Print Receipt
                </button>
                <a href="{{ route('invoices.show', $payment->invoice) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-4 py-2 font-semibold text-xs text-white hover:bg-opacity-90 transition">
                    📄 View Invoice
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Printable Receipt Card -->
        <div class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-8 print:border-none print:shadow-none print:p-0">

            <!-- Header Block -->
            <div class="flex flex-col sm:flex-row justify-between items-start border-b border-stroke dark:border-strokedark pb-6 gap-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-black dark:text-white tracking-wide">{{ $payment->library->name }}</h1>
                    <p class="text-xs text-gray-500 dark:text-bodydark mt-1">{{ $payment->branch->address }}, {{ $payment->branch->city }}</p>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Phone: {{ $payment->branch->phone ?? $payment->library->mobile }} | Email: {{ $payment->library->email }}</p>
                </div>

                <div class="text-left sm:text-right">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">OFFICIAL PAYMENT RECEIPT</span>
                    <h3 class="text-2xl font-mono font-bold text-black dark:text-white mt-1">{{ $payment->payment_number }}</h3>
                    <p class="text-xs font-mono text-gray-500 dark:text-bodydark mt-1">Date: <strong class="text-black dark:text-white">{{ $payment->payment_date->format('d M Y, h:i A') }}</strong></p>
                </div>
            </div>

            <!-- Receipt Metadata Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-boxdark-2 p-5 rounded-2xl border border-stroke dark:border-strokedark">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Received From (Student)</span>
                    <h4 class="text-base font-bold text-black dark:text-white mt-1">{{ $payment->student->full_name }}</h4>
                    <p class="text-xs font-mono text-primary font-bold">Student ID: {{ $payment->student->student_number }}</p>
                    <p class="text-xs text-gray-500 dark:text-bodydark mt-1">Mobile: {{ $payment->student->mobile }}</p>
                </div>

                <div class="space-y-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Payment Summary</span>
                    <p class="text-xs text-gray-600 dark:text-bodydark">Invoice Ref: <a href="{{ route('invoices.show', $payment->invoice) }}" class="font-mono font-bold text-primary hover:underline">{{ $payment->invoice->invoice_number }}</a></p>
                    <p class="text-xs text-gray-600 dark:text-bodydark">Payment Method: <span class="uppercase font-bold text-black dark:text-white">{{ $payment->payment_method }}</span></p>
                    @if($payment->transaction_reference)
                        <p class="text-xs font-mono text-gray-600 dark:text-bodydark">Txn UTR/Ref: <strong class="text-black dark:text-white">{{ $payment->transaction_reference }}</strong></p>
                    @endif
                    <p class="text-xs text-gray-600 dark:text-bodydark">Collected By: <strong>{{ $payment->receiver->name ?? 'System' }}</strong></p>
                </div>
            </div>

            <!-- Amount Highlight Box -->
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 p-6 rounded-2xl flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-300">Amount Received</span>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400">Payment successfully recorded into account</p>
                </div>
                <div class="text-3xl font-extrabold font-mono text-emerald-700 dark:text-emerald-300">
                    ₹{{ number_format($payment->amount, 2) }}
                </div>
            </div>

            <!-- Invoice Balance Status -->
            <div class="border-t border-stroke dark:border-strokedark pt-4 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-600 dark:text-bodydark gap-2">
                <div>
                    Invoice Total: <strong class="font-mono text-black dark:text-white">₹{{ number_format($payment->invoice->total, 2) }}</strong> | Total Paid: <strong class="font-mono text-emerald-600">₹{{ number_format($payment->invoice->paid_amount, 2) }}</strong>
                </div>
                <div>
                    Remaining Balance: <strong class="font-mono text-amber-600 text-sm">₹{{ number_format($payment->invoice->balance_amount, 2) }}</strong>
                </div>
            </div>

            <!-- Signature & Stamp Block -->
            <div class="pt-12 flex justify-between items-end text-center">
                <div class="text-xs text-gray-400">
                    <p class="italic">This is a computer-generated receipt.</p>
                    <p>No physical signature required.</p>
                </div>
                <div class="w-48 border-t border-stroke dark:border-strokedark pt-2">
                    <p class="text-xs font-bold text-black dark:text-white">Authorized Signatory</p>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-0.5">{{ $payment->library->name }}</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
