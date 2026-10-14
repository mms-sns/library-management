<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Payment Transactions Log
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Permanent financial transaction logs & payment receipts</p>
            </div>
            <a href="{{ route('invoices.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-4 py-2 font-semibold text-xs text-gray-700 dark:text-bodydark hover:bg-gray-200 dark:hover:bg-strokedark transition">
                ← Back to Invoices
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Filter Bar -->
        <div class="rounded-2xl border border-stroke bg-white p-4 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <form method="GET" action="{{ route('payments.index') }}" class="flex flex-wrap items-center gap-4">
                <div class="w-full sm:w-56">
                    <select
                        name="payment_method"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        <option value="">All Payment Methods</option>
                        <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="upi" {{ request('payment_method') === 'upi' ? 'selected' : '' }}>UPI / QR Code</option>
                        <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="card" {{ request('payment_method') === 'card' ? 'selected' : '' }}>Card</option>
                    </select>
                </div>

                @if(request()->has('payment_method'))
                    <a href="{{ route('payments.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-600 dark:text-bodydark text-xs font-semibold hover:bg-gray-200 dark:hover:bg-strokedark transition">
                        Clear Filter
                    </a>
                @endif
            </form>
        </div>

        <!-- Payments Log Table -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            @if($payments->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-bodydark text-sm">No payment records found.</p>
                </div>
            @else
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                        <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                            <tr>
                                <th class="p-4 px-6">Payment #</th>
                                <th class="p-4">Student</th>
                                <th class="p-4">Invoice #</th>
                                <th class="p-4">Method & Ref</th>
                                <th class="p-4">Date & Time</th>
                                <th class="p-4">Amount</th>
                                <th class="p-4">Receiver</th>
                                <th class="p-4 px-6 text-right">Receipt</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stroke dark:divide-strokedark">
                            @foreach($payments as $pm)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                    <td class="p-4 px-6">
                                        <a href="{{ route('payments.show', $pm) }}" class="font-mono text-sm font-bold text-primary hover:underline">
                                            {{ $pm->payment_number }}
                                        </a>
                                    </td>
                                    <td class="p-4">
                                        <a href="{{ route('students.show', $pm->student) }}" class="font-bold text-black dark:text-white hover:text-primary transition">
                                            {{ $pm->student->full_name }}
                                        </a>
                                        <span class="block text-xs font-mono text-gray-400">{{ $pm->student->student_number }}</span>
                                    </td>
                                    <td class="p-4">
                                        <a href="{{ route('invoices.show', $pm->invoice) }}" class="font-mono text-xs font-semibold text-indigo-600 hover:underline">
                                            {{ $pm->invoice->invoice_number }}
                                        </a>
                                    </td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-md bg-gray-100 dark:bg-boxdark-2 uppercase">
                                            {{ $pm->payment_method }}
                                        </span>
                                        @if($pm->transaction_reference)
                                            <span class="block text-xs font-mono text-gray-400 mt-0.5">{{ $pm->transaction_reference }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-xs font-mono">
                                        {{ $pm->payment_date->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="p-4 font-mono font-bold text-emerald-600 dark:text-emerald-400 text-base">
                                        ₹{{ number_format($pm->amount, 2) }}
                                    </td>
                                    <td class="p-4 text-xs">
                                        {{ $pm->receiver->name ?? 'System' }}
                                    </td>
                                    <td class="p-4 px-6 text-right">
                                        <a href="{{ route('payments.show', $pm) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-primary hover:underline">
                                            📜 Receipt
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-stroke dark:border-strokedark">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
