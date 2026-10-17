<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Student Directory
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Manage member admissions, profiles, fee collections, and overdue tracking</p>
            </div>
            @can('students.create')
                <a href="{{ route('students.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 font-semibold text-xs text-white shadow-md hover:bg-primary-hover transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    New Student Registration
                </a>
            @endcan
        </div>
    </x-slot>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div
        class="space-y-6"
        x-data="{
            showCollectModal: false,
            activeInvoiceId: null,
            activeStudentName: '',
            activeInvoiceNumber: '',
            activeBalance: 0,
            activePaymentAmount: 0,
            openCollectModal(invId, studentName, invNumber, balance) {
                this.activeInvoiceId = invId;
                this.activeStudentName = studentName;
                this.activeInvoiceNumber = invNumber;
                this.activeBalance = Number(balance);
                this.activePaymentAmount = Number(balance).toFixed(2);
                this.showCollectModal = true;
            }
        }"
    >

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="rounded-2xl border border-stroke bg-white p-4 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <form method="GET" action="{{ route('students.index') }}" class="flex flex-col sm:flex-row items-center gap-4">
                <!-- Search Input -->
                <div class="relative flex-1 w-full">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name, student number (LIB-000001), mobile, or email..."
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 pl-10 pr-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    />
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Status Filter -->
                <div class="w-full sm:w-44">
                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="blacklisted" {{ request('status') === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                    </select>
                </div>

                <!-- Fee / Overdue Status Filter -->
                <div class="w-full sm:w-48">
                    <select
                        name="due_status"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        <option value="">All Fee Statuses</option>
                        <option value="overdue" {{ request('due_status') === 'overdue' ? 'selected' : '' }}>⚠️ Overdue Only</option>
                        <option value="pending" {{ request('due_status') === 'pending' ? 'selected' : '' }}>Pending Dues</option>
                        <option value="paid" {{ request('due_status') === 'paid' ? 'selected' : '' }}>No Dues (Paid)</option>
                    </select>
                </div>

                <!-- Submit / Clear -->
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary-hover transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'due_status']))
                        <a href="{{ route('students.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-600 dark:text-bodydark text-xs font-semibold hover:bg-gray-200 dark:hover:bg-strokedark transition">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Student Table -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            @if($students->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-bodydark text-sm">No students found matching your criteria.</p>
                </div>
            @else
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                        <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                            <tr>
                                <th class="p-4 px-6">Student</th>
                                <th class="p-4">Student ID</th>
                                <th class="p-4">Mobile &amp; Email</th>
                                <th class="p-4">Fees &amp; Overdues</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stroke dark:divide-strokedark">
                            @foreach($students as $student)
                                @php
                                    $pendingInv = $student->pending_invoice;
                                    $activeMem = $student->active_membership;
                                @endphp
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                    <td class="p-4 px-6">
                                        <div class="flex items-center gap-3">
                                            @if($student->photo)
                                                <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->full_name }}" class="h-10 w-10 rounded-full object-cover border border-stroke dark:border-strokedark">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                                    {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('students.show', $student) }}" class="font-bold text-black dark:text-white hover:text-primary transition">
                                                    {{ $student->full_name }}
                                                </a>
                                                <span class="block text-xs text-gray-400 capitalize">
                                                    {{ $student->gender }} · Joined {{ $student->joined_at ? $student->joined_at->format('d M Y') : 'N/A' }}
                                                </span>
                                                @if($activeMem)
                                                    <span class="inline-flex items-center gap-1 mt-0.5 text-[11px] font-semibold text-primary">
                                                        ✨ {{ $activeMem->plan->name ?? 'Membership' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="bg-primary/10 text-primary font-mono text-xs px-2.5 py-1 rounded-md font-bold block w-fit">
                                            {{ $student->student_number }}
                                        </span>
                                        @if($student->seat)
                                            <span class="inline-flex items-center gap-1 mt-1 text-[11px] font-bold font-mono text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 px-2 py-0.5 rounded-md">
                                                🪑 {{ $student->seat->seat_number }}
                                            </span>
                                        @else
                                            <span class="block mt-1 text-[10px] text-gray-400">
                                                No seat
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <span class="font-medium text-black dark:text-white font-mono text-xs">{{ $student->mobile }}</span>
                                        <span class="block text-xs text-gray-400 truncate max-w-[150px]">{{ $student->email ?? 'N/A' }}</span>
                                    </td>
                                    <!-- Fees & Overdues Column -->
                                    <td class="p-4">
                                        @if($pendingInv)
                                            @php
                                                $isOverdue = $pendingInv->isOverdue();
                                                $daysLeft = $pendingInv->daysUntilDue();
                                            @endphp
                                            <div class="space-y-1.5 min-w-[160px]">
                                                <!-- Overdue / Days Left Badge -->
                                                <div class="flex items-center gap-1.5">
                                                    @if($isOverdue)
                                                        @php $daysOverdue = abs($daysLeft); @endphp
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-950/60 dark:text-red-400 border border-red-200 dark:border-red-900">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                                            {{ $daysOverdue === 1 ? '1 day overdue' : "{$daysOverdue} days overdue" }}
                                                        </span>
                                                    @elseif($daysLeft === 0)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                                            ⚠️ Due Today
                                                        </span>
                                                    @elseif($daysLeft === 1)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200 dark:border-amber-900">
                                                            ⏳ 1 day left
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-900">
                                                            ⏳ {{ $daysLeft }} days left
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Balance & Due Date -->
                                                <div class="flex items-baseline gap-1.5 text-xs">
                                                    <span class="font-mono font-extrabold text-amber-600 dark:text-amber-400">
                                                        ₹{{ number_format($pendingInv->balance_amount, 2) }}
                                                    </span>
                                                    <span class="text-[10px] text-gray-400 font-mono">
                                                        (Due: {{ $pendingInv->due_date ? $pendingInv->due_date->format('d M') : 'N/A' }})
                                                    </span>
                                                </div>

                                                <!-- Collect Fee Button -->
                                                <div class="pt-0.5">
                                                    <button
                                                        type="button"
                                                        @click="openCollectModal({{ $pendingInv->id }}, '{{ addslashes($student->full_name) }}', '{{ $pendingInv->invoice_number }}', {{ $pendingInv->balance_amount }})"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-sm hover:shadow transition"
                                                    >
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                        Collect Fee
                                                    </button>
                                                </div>
                                            </div>
                                        @elseif($activeMem)
                                            @php
                                                $isMemExpired = $activeMem->isExpired();
                                                $memDaysLeft = $activeMem->remainingDays();
                                            @endphp
                                            <div class="space-y-1.5 min-w-[150px]">
                                                <div>
                                                    @if($isMemExpired)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                                            ⚠️ Plan Expired
                                                        </span>
                                                        <span class="block text-[10px] text-gray-400 mt-0.5">Renewal Due</span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                                            ✓ Fees Cleared
                                                        </span>
                                                        <span class="block text-[10px] text-gray-500 dark:text-bodydark font-medium mt-0.5">
                                                            Plan: <strong class="text-black dark:text-white font-mono">{{ $memDaysLeft }}d left</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div>
                                                    <a
                                                        href="{{ route('invoices.create', ['student_id' => $student->id, 'membership_id' => $activeMem->id]) }}"
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-boxdark-2 hover:bg-primary hover:text-white text-gray-700 dark:text-bodydark text-xs font-semibold transition"
                                                    >
                                                        + Collect Fee
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="space-y-1.5 min-w-[140px]">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-boxdark-2 dark:text-bodydark">
                                                    No Active Plan
                                                </span>
                                                <div>
                                                    <a
                                                        href="{{ route('invoices.create', ['student_id' => $student->id]) }}"
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-boxdark-2 hover:bg-primary hover:text-white text-gray-700 dark:text-bodydark text-xs font-semibold transition"
                                                    >
                                                        + Collect Fee
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        @php
                                            $statusColors = [
                                                'active' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                                                'inactive' => 'bg-gray-100 text-gray-800 dark:bg-boxdark-2 dark:text-bodydark',
                                                'suspended' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                                                'blacklisted' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$student->status] ?? '' }}">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 px-6 text-right space-x-2.5 whitespace-nowrap">
                                        @if($pendingInv)
                                            <button
                                                type="button"
                                                @click="openCollectModal({{ $pendingInv->id }}, '{{ addslashes($student->full_name) }}', '{{ $pendingInv->invoice_number }}', {{ $pendingInv->balance_amount }})"
                                                class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 font-semibold text-xs"
                                                title="Collect Pending Fee"
                                            >
                                                💳 Collect
                                            </button>
                                        @else
                                            <a
                                                href="{{ route('invoices.create', ['student_id' => $student->id]) }}"
                                                class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 font-semibold text-xs"
                                                title="Create Fee Invoice"
                                            >
                                                + Fee
                                            </a>
                                        @endif

                                        <a href="{{ route('students.show', $student) }}" class="text-primary hover:text-primary-hover font-semibold text-xs">View</a>

                                        @can('update', $student)
                                            <a href="{{ route('students.edit', $student) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold text-xs">Edit</a>
                                        @endcan

                                        @can('delete', $student)
                                            <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to archive this student record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs">Archive</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-stroke dark:border-strokedark">
                    {{ $students->links() }}
                </div>
            @endif
        </div>

        <!-- Collect Fee Payment Modal -->
        <div x-show="showCollectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm" x-cloak>
            <div class="w-full max-w-md rounded-2xl border border-stroke bg-white p-6 shadow-2xl dark:border-strokedark dark:bg-boxdark space-y-4" @click.outside="showCollectModal = false">
                <div class="flex items-start justify-between border-b border-stroke dark:border-strokedark pb-3">
                    <div>
                        <h3 class="text-base font-bold text-black dark:text-white flex items-center gap-2">
                            <span>💳</span> Record Fee Collection
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-bodydark mt-0.5">
                            Student: <strong class="text-black dark:text-white" x-text="activeStudentName"></strong>
                        </p>
                    </div>
                    <button type="button" @click="showCollectModal = false" class="text-gray-400 hover:text-black dark:hover:text-white text-lg font-bold">✕</button>
                </div>

                <div class="bg-gray-50 dark:bg-boxdark-2 p-3.5 rounded-xl border border-stroke dark:border-strokedark flex justify-between items-center text-xs">
                    <div>
                        <span class="text-gray-400 font-semibold block uppercase text-[10px]">Invoice Reference</span>
                        <span class="font-mono font-bold text-primary text-sm" x-text="activeInvoiceNumber"></span>
                    </div>
                    <div class="text-right">
                        <span class="text-gray-400 font-semibold block uppercase text-[10px]">Outstanding Balance</span>
                        <span class="font-mono font-extrabold text-amber-600 dark:text-amber-400 text-sm">₹<span x-text="Number(activeBalance).toFixed(2)"></span></span>
                    </div>
                </div>

                <form method="POST" action="{{ route('payments.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="invoice_id" :value="activeInvoiceId">
                    <input type="hidden" name="redirect_to" value="students">

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Amount to Collect (INR ₹) *</label>
                        <input
                            type="number"
                            step="0.01"
                            name="amount"
                            x-model="activePaymentAmount"
                            :max="activeBalance"
                            required
                            class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm font-bold text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        />
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Payment Method *</label>
                        <select name="payment_method" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                            <option value="cash">Cash</option>
                            <option value="upi">UPI / QR Scan</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Credit/Debit Card</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Transaction Reference / UTR</label>
                        <input type="text" name="transaction_reference" placeholder="e.g. UPI/202610141234 or cash receipt note" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Payment Date &amp; Time *</label>
                        <input type="datetime-local" name="payment_date" value="{{ date('Y-m-d\TH:i') }}" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-stroke dark:border-strokedark">
                        <a :href="'/fees/invoices/' + activeInvoiceId" class="text-xs text-primary hover:underline font-semibold flex items-center gap-1">
                            Full Invoice Page →
                        </a>
                        <div class="flex gap-2">
                            <button type="button" @click="showCollectModal = false" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark hover:bg-gray-200 transition">Cancel</button>
                            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-xs font-semibold text-white shadow-md transition flex items-center gap-1.5">
                                <span>✓</span> Confirm &amp; Collect
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
