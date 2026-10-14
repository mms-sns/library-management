<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Invoices & Fee Dashboard
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Manage fee invoices, outstanding balances, GST tax calculations, and payments</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('payments.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-4 py-2 font-semibold text-xs text-gray-700 dark:text-bodydark hover:bg-gray-200 dark:hover:bg-strokedark transition">
                    💳 Payment Log
                </a>
                @can('invoices.create')
                    <a href="{{ route('invoices.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 font-semibold text-xs text-white shadow hover:bg-primary-hover transition">
                        + Create Invoice
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Financial Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="rounded-2xl border border-stroke bg-white p-5 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Total Invoiced</span>
                <h3 class="text-2xl font-extrabold text-black dark:text-white mt-1 font-mono">₹{{ number_format($stats['total_issued'], 2) }}</h3>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 shadow-sm dark:border-emerald-900 dark:bg-emerald-950/40">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold uppercase tracking-wider">Total Collected</span>
                <h3 class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1 font-mono">₹{{ number_format($stats['total_paid'], 2) }}</h3>
            </div>
            <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-5 shadow-sm dark:border-amber-900 dark:bg-amber-950/40">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold uppercase tracking-wider">Outstanding Pending</span>
                <h3 class="text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-1 font-mono">₹{{ number_format($stats['total_pending'], 2) }}</h3>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="rounded-2xl border border-stroke bg-white p-4 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <form method="GET" action="{{ route('invoices.index') }}" class="flex flex-col sm:flex-row items-center gap-4">
                <div class="relative flex-1 w-full">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by invoice number (INV-000001) or student name..."
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 pl-10 pr-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    />
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <div class="w-full sm:w-48">
                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        <option value="">All Statuses</option>
                        <option value="issued" {{ request('status') === 'issued' ? 'selected' : '' }}>Issued</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partially_paid" {{ request('status') === 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                        <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary-hover transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('invoices.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-600 dark:text-bodydark text-xs font-semibold hover:bg-gray-200 dark:hover:bg-strokedark transition">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Invoices Table -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            @if($invoices->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-bodydark text-sm">No invoices found.</p>
                </div>
            @else
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                        <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                            <tr>
                                <th class="p-4 px-6">Invoice #</th>
                                <th class="p-4">Student</th>
                                <th class="p-4">Dates</th>
                                <th class="p-4">Total Amount</th>
                                <th class="p-4">Paid / Balance</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stroke dark:divide-strokedark">
                            @foreach($invoices as $inv)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                    <td class="p-4 px-6">
                                        <a href="{{ route('invoices.show', $inv) }}" class="font-mono text-sm font-bold text-primary hover:underline">
                                            {{ $inv->invoice_number }}
                                        </a>
                                    </td>
                                    <td class="p-4">
                                        <a href="{{ route('students.show', $inv->student) }}" class="font-bold text-black dark:text-white hover:text-primary transition">
                                            {{ $inv->student->full_name }}
                                        </a>
                                        <span class="block text-xs font-mono text-gray-400">{{ $inv->student->student_number }}</span>
                                    </td>
                                    <td class="p-4 text-xs font-mono">
                                        <span class="block text-black dark:text-white font-medium">Inv: {{ $inv->invoice_date->format('d-m-Y') }}</span>
                                        <span class="block text-gray-400">Due: {{ $inv->due_date->format('d-m-Y') }}</span>
                                    </td>
                                    <td class="p-4 font-mono font-bold text-black dark:text-white">
                                        ₹{{ number_format($inv->total, 2) }}
                                        @if($inv->tax > 0)
                                            <span class="block text-[10px] text-gray-400 font-sans">Inc. ₹{{ number_format($inv->tax, 0) }} GST</span>
                                        @endif
                                    </td>
                                    <td class="p-4 font-mono text-xs">
                                        <span class="block font-bold text-emerald-600 dark:text-emerald-400">Paid: ₹{{ number_format($inv->paid_amount, 2) }}</span>
                                        <span class="block font-bold text-amber-600 dark:text-amber-400">Bal: ₹{{ number_format($inv->balance_amount, 2) }}</span>
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $statusColors = [
                                                'paid' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                                                'partially_paid' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                                                'issued' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300',
                                                'overdue' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300',
                                                'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-boxdark-2 dark:text-bodydark',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$inv->status] ?? '' }}">
                                            {{ str_replace('_', ' ', ucfirst($inv->status)) }}
                                        </span>
                                    </td>
                                    <td class="p-4 px-6 text-right">
                                        <a href="{{ route('invoices.show', $inv) }}" class="inline-flex items-center gap-1 text-primary hover:text-primary-hover font-semibold text-xs bg-primary/10 px-3 py-1.5 rounded-lg">
                                            📄 View / Pay
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-stroke dark:border-strokedark">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
