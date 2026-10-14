<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Student Memberships
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Manage active student subscriptions, expirations, and non-destructive renewals</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('membership-plans.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-4 py-2 font-semibold text-xs text-gray-700 dark:text-bodydark hover:bg-gray-200 dark:hover:bg-strokedark transition">
                    📋 Membership Plans
                </a>
                @can('memberships.create')
                    <a href="{{ route('memberships.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 font-semibold text-xs text-white shadow hover:bg-primary-hover transition">
                        + Assign Membership
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="space-y-6" x-data="{ showRenewModal: false, renewAction: '', currentPlanName: '', currentStudentName: '' }">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Status Filter Bar -->
        <div class="rounded-2xl border border-stroke bg-white p-4 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <form method="GET" action="{{ route('memberships.index') }}" class="flex flex-wrap items-center gap-4">
                <div class="w-full sm:w-56">
                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                @if(request()->has('status'))
                    <a href="{{ route('memberships.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-600 dark:text-bodydark text-xs font-semibold hover:bg-gray-200 dark:hover:bg-strokedark transition">
                        Clear Filter
                    </a>
                @endif
            </form>
        </div>

        <!-- Memberships Table -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            @if($memberships->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-bodydark text-sm">No memberships found.</p>
                </div>
            @else
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                        <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                            <tr>
                                <th class="p-4 px-6">Student</th>
                                <th class="p-4">Plan & Branch</th>
                                <th class="p-4">Validity Period</th>
                                <th class="p-4">Days Left</th>
                                <th class="p-4">Amount</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stroke dark:divide-strokedark">
                            @foreach($memberships as $ms)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                    <td class="p-4 px-6">
                                        <a href="{{ route('students.show', $ms->student) }}" class="font-bold text-black dark:text-white hover:text-primary transition">
                                            {{ $ms->student->full_name }}
                                        </a>
                                        <span class="block text-xs font-mono text-gray-400">{{ $ms->student->student_number }}</span>
                                    </td>
                                    <td class="p-4">
                                        <span class="font-semibold text-black dark:text-white">{{ $ms->plan->name }}</span>
                                        <span class="block text-xs text-gray-400">({{ $ms->branch->name }})</span>
                                    </td>
                                    <td class="p-4 text-xs font-mono">
                                        <span class="block font-semibold text-black dark:text-white">{{ $ms->start_date->format('d-m-Y') }} → {{ $ms->end_date->format('d-m-Y') }}</span>
                                        <span class="text-gray-400">{{ $ms->plan->duration_days }} Days Duration</span>
                                    </td>
                                    <td class="p-4 font-mono font-bold">
                                        @if($ms->isExpired())
                                            <span class="text-red-500 text-xs bg-red-50 dark:bg-red-950/50 px-2 py-0.5 rounded">Expired</span>
                                        @else
                                            <span class="text-emerald-600 dark:text-emerald-400 text-sm">{{ $ms->remainingDays() }} days</span>
                                        @endif
                                    </td>
                                    <td class="p-4 font-mono font-bold text-black dark:text-white">
                                        ₹{{ number_format($ms->final_amount, 2) }}
                                        @if($ms->discount > 0)
                                            <span class="block text-[10px] text-emerald-600 dark:text-emerald-400">(-₹{{ number_format($ms->discount, 0) }} Disc)</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $statusColors = [
                                                'active' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                                                'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                                                'expired' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300',
                                                'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-boxdark-2 dark:text-bodydark',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$ms->status] ?? '' }}">
                                            {{ ucfirst($ms->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 px-6 text-right space-x-2">
                                        @can('renew', $ms)
                                            <button
                                                type="button"
                                                @click="showRenewModal = true; renewAction = '{{ route('memberships.renew', $ms) }}'; currentStudentName = '{{ $ms->student->full_name }}'; currentPlanName = '{{ $ms->plan->name }}';"
                                                class="text-xs font-semibold text-primary hover:underline"
                                            >
                                                🔄 Renew
                                            </button>
                                        @endcan

                                        @can('cancel', $ms)
                                            @if($ms->status === 'active')
                                                <form method="POST" action="{{ route('memberships.cancel', $ms) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to cancel this active membership?')">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-semibold text-red-500 hover:underline">Cancel</button>
                                                </form>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-stroke dark:border-strokedark">
                    {{ $memberships->links() }}
                </div>
            @endif
        </div>

        <!-- Non-Destructive Renewal Modal -->
        <div x-show="showRenewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div class="w-full max-w-md rounded-2xl border border-stroke bg-white p-6 shadow-xl dark:border-strokedark dark:bg-boxdark space-y-4" @click.outside="showRenewModal = false">
                <div>
                    <h3 class="text-base font-bold text-black dark:text-white">Renew Membership</h3>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Student: <strong x-text="currentStudentName" class="text-black dark:text-white"></strong></p>
                </div>

                <form method="POST" :action="renewAction" class="space-y-4">
                    @csrf

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Select Renewal Plan *</label>
                        <select name="membership_plan_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                            @foreach(\App\Models\MembershipPlan::where('status', 'active')->get() as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->duration_days }} Days) — ₹{{ number_format($p->price, 0) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Discount (INR ₹)</label>
                        <input type="number" step="0.01" name="discount" value="0.00" min="0" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Renewal Notes</label>
                        <textarea name="notes" rows="2" placeholder="Optional notes for renewal..." class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-stroke dark:border-strokedark">
                        <button type="button" @click="showRenewModal = false" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-primary text-xs font-semibold text-white hover:bg-primary-hover">Confirm Renewal</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
