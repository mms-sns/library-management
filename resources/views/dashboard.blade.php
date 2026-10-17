<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="font-bold text-xl sm:text-2xl text-black dark:text-white tracking-tight">
                        Welcome back, {{ Auth::user()->name }} 👋
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Active Tenant
                    </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-bodydark mt-1">
                    {{ $library->name }} • {{ now()->format('l, d F Y') }}
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a
                    href="{{ route('kiosk.index') }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 px-4 py-2 text-xs font-bold text-white shadow-lg shadow-emerald-600/20 transition"
                >
                    <span class="text-sm">📱</span>
                    <span>Launch Attendance Kiosk ↗</span>
                </a>

                @can('students.create')
                <a
                    href="{{ route('students.create') }}"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-primary hover:bg-opacity-90 px-3.5 py-2 text-xs font-semibold text-white shadow transition"
                >
                    <span>➕</span>
                    <span>New Student</span>
                </a>
                @endcan

                <a
                    href="{{ route('seats.map') }}"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 hover:bg-gray-200 dark:hover:bg-strokedark px-3.5 py-2 text-xs font-semibold text-black dark:text-white transition"
                >
                    <span>🗺️</span>
                    <span>Seat Map</span>
                </a>

                @can('invoices.view')
                <a
                    href="{{ route('invoices.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 hover:bg-gray-200 dark:hover:bg-strokedark px-3.5 py-2 text-xs font-semibold text-black dark:text-white transition"
                >
                    <span>💵</span>
                    <span>Fees & Dues</span>
                </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Flash Status Message -->
        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- TOP EXECUTIVE KPI CARDS (Row 1) -->
        <div class="grid grid-cols-1 sm:grid-cols-4 lg:grid-cols-4 gap-4 sm:gap-6">

            <!-- Card 1: Active Students -->
            <a href="{{ route('students.index') }}" class="group rounded-2xl border border-stroke bg-white p-5 sm:p-6 shadow-sm dark:border-strokedark dark:bg-boxdark hover:border-primary transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-bodydark">Active Students</span>
                    <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 flex items-center justify-center text-lg font-bold">
                        👥
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-black dark:text-white">{{ $stats['active_students'] }}</span>
                        <span class="text-xs text-gray-400">/ {{ $stats['total_students'] }} total</span>
                    </div>
                    <div class="mt-2 flex items-center gap-1 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
                        <span>↑ +{{ $stats['new_students_month'] }}</span>
                        <span class="text-gray-400 font-normal">registered this month</span>
                    </div>
                </div>
            </a>

            <!-- Card 2: Live Seat Occupancy -->
            <a href="{{ route('seats.map') }}" class="group rounded-2xl border border-stroke bg-white p-5 sm:p-6 shadow-sm dark:border-strokedark dark:bg-boxdark hover:border-emerald-500 transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-bodydark">Seat Occupancy</span>
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 flex items-center justify-center text-lg font-bold">
                        🪑
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline justify-between">
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-3xl font-extrabold text-black dark:text-white">{{ $stats['occupied_seats'] }}</span>
                            <span class="text-xs text-gray-400">/ {{ $stats['total_seats'] }} seats</span>
                        </div>
                        <span class="text-xs font-mono font-bold text-emerald-600 dark:text-emerald-400">
                            {{ $stats['occupancy_rate'] }}%
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-100 dark:bg-boxdark-2 h-2 rounded-full overflow-hidden mt-2.5">
                        <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ min(100, $stats['occupancy_rate']) }}%"></div>
                    </div>

                    <div class="mt-2 text-[11px] text-gray-500 dark:text-bodydark">
                        <strong class="text-emerald-600 dark:text-emerald-400">{{ $stats['available_seats'] }}</strong> seats vacant right now
                    </div>
                </div>
            </a>

            <!-- Card 3: Live Reading Room Attendance -->
            <a href="{{ route('attendances.index') }}" class="group rounded-2xl border border-stroke bg-white p-5 sm:p-6 shadow-sm dark:border-strokedark dark:bg-boxdark hover:border-cyan-500 transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-bodydark">Present in Library</span>
                    <div class="h-10 w-10 rounded-xl bg-cyan-50 dark:bg-cyan-950/50 text-cyan-600 flex items-center justify-center text-lg font-bold">
                        📱
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-black dark:text-white">{{ $stats['currently_present'] }}</span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-300">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                            INSIDE NOW
                        </span>
                    </div>
                    <div class="mt-2 text-[11px] text-gray-500 dark:text-bodydark">
                        <strong class="text-black dark:text-white">{{ $stats['today_checkins'] }}</strong> total check-ins recorded today
                    </div>
                </div>
            </a>

            <!-- Card 4: Monthly Revenue & Overdues -->
            <a href="{{ route('invoices.index') }}" class="group rounded-2xl border border-stroke bg-white p-5 sm:p-6 shadow-sm dark:border-strokedark dark:bg-boxdark hover:border-amber-500 transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-bodydark">Monthly Revenue</span>
                    <div class="h-10 w-10 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 flex items-center justify-center text-lg font-bold">
                        💰
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline gap-1">
                        <span class="text-xs text-gray-400 font-mono">₹</span>
                        <span class="text-3xl font-extrabold text-black dark:text-white">{{ number_format($stats['monthly_revenue'], 0) }}</span>
                    </div>
                    <div class="mt-2 flex items-center gap-1.5 text-[11px]">
                        <span class="text-rose-500 font-semibold font-mono">₹{{ number_format($stats['pending_dues'], 0) }}</span>
                        <span class="text-gray-400">pending ({{ $stats['overdue_count'] }} overdue)</span>
                    </div>
                </div>
            </a>

        </div>

        <!-- MIDDLE SECTION (2 Columns: Live Stream + Action Watchlist) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Column 1: Live Reading Room Attendance Stream (7 cols) -->
            <div class="lg:col-span-7 rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-stroke dark:border-strokedark pb-4 mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <h3 class="font-bold text-base text-black dark:text-white">Live Reading Room Stream</h3>
                        </div>
                        <a href="{{ route('attendances.index') }}" class="text-xs font-semibold text-primary hover:underline">
                            View All Logs →
                        </a>
                    </div>

                    @if($recentAttendances->isEmpty())
                        <div class="text-center py-12">
                            <div class="h-12 w-12 rounded-full bg-gray-100 dark:bg-boxdark-2 flex items-center justify-center text-xl mx-auto mb-2 text-gray-400">
                                📷
                            </div>
                            <p class="text-xs text-gray-500 dark:text-bodydark">No student check-ins recorded yet today.</p>
                            <a href="{{ route('kiosk.index') }}" target="_blank" class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-500 transition">
                                📱 Open Kiosk Scanner
                            </a>
                        </div>
                    @else
                        <div class="divide-y divide-stroke dark:divide-strokedark">
                            @foreach($recentAttendances as $att)
                                <div class="py-3 flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        @if($att->student && $att->student->photo)
                                            <img src="{{ asset('storage/' . $att->student->photo) }}" alt="{{ $att->student->full_name }}" class="h-9 w-9 rounded-full object-cover border border-stroke dark:border-strokedark flex-shrink-0">
                                        @else
                                            <div class="h-9 w-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs flex-shrink-0">
                                                {{ $att->student ? strtoupper(substr($att->student->first_name, 0, 1)) : '?' }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <a href="{{ $att->student ? route('students.show', $att->student) : '#' }}" class="font-bold text-xs sm:text-sm text-black dark:text-white hover:text-primary transition truncate block">
                                                {{ $att->student->full_name ?? 'Student' }}
                                            </a>
                                            <span class="text-[11px] font-mono text-gray-400">
                                                {{ $att->student->student_number ?? 'N/A' }} • {{ $att->branch->name ?? 'Main' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-right flex-shrink-0">
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $att->status === 'present' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-gray-100 text-gray-600 dark:bg-boxdark-2 dark:text-bodydark' }}">
                                            {{ $att->status === 'present' ? 'Inside' : 'Checked Out' }}
                                        </span>
                                        <div class="text-[10px] font-mono text-gray-400 mt-0.5">
                                            {{ $att->check_in_at->format('h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="pt-4 border-t border-stroke dark:border-strokedark mt-4 flex items-center justify-between text-xs text-gray-400">
                    <span>Camera & Kiosk Attendance Engine</span>
                    <span class="text-emerald-500 font-semibold font-mono">STATUS: ONLINE</span>
                </div>
            </div>

            <!-- Column 2: Action Watchlist (Expiring Memberships & Dues) (5 cols) -->
            <div class="lg:col-span-5 rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark" x-data="{ tab: 'expiring' }">
                <!-- Header with Tabs -->
                <div class="flex items-center justify-between border-b border-stroke dark:border-strokedark pb-3 mb-4">
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            @click="tab = 'expiring'"
                            class="text-xs font-bold pb-2 relative transition"
                            :class="tab === 'expiring' ? 'text-primary' : 'text-gray-400 hover:text-black dark:hover:text-white'"
                        >
                            <span>Expiring Soon</span>
                            <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                                {{ $expiringMemberships->count() }}
                            </span>
                            <span x-show="tab === 'expiring'" class="absolute bottom-0 inset-x-0 h-0.5 bg-primary rounded-full"></span>
                        </button>

                        <button
                            type="button"
                            @click="tab = 'dues'"
                            class="text-xs font-bold pb-2 relative transition ml-3"
                            :class="tab === 'dues' ? 'text-primary' : 'text-gray-400 hover:text-black dark:hover:text-white'"
                        >
                            <span>Overdue Dues</span>
                            <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">
                                {{ $stats['overdue_count'] }}
                            </span>
                            <span x-show="tab === 'dues'" class="absolute bottom-0 inset-x-0 h-0.5 bg-primary rounded-full"></span>
                        </button>
                    </div>
                </div>

                <!-- Tab 1: Expiring Memberships -->
                <div x-show="tab === 'expiring'" class="space-y-3">
                    @if($expiringMemberships->isEmpty())
                        <div class="text-center py-10">
                            <div class="text-2xl mb-1">🎉</div>
                            <p class="text-xs text-gray-500 dark:text-bodydark">No student memberships expiring in the next 7 days.</p>
                        </div>
                    @else
                        @foreach($expiringMemberships as $m)
                            <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-boxdark-2 border border-stroke dark:border-strokedark flex items-center justify-between gap-3 text-xs">
                                <div>
                                    <a href="{{ route('students.show', $m->student) }}" class="font-bold text-black dark:text-white hover:text-primary transition block">
                                        {{ $m->student->full_name }}
                                    </a>
                                    <span class="text-[11px] text-gray-400 font-medium">
                                        {{ $m->plan->name ?? 'Plan' }} • Exp: {{ $m->end_date->format('d M') }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                                        {{ $m->remainingDays() }}d left
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Tab 2: Overdue Invoices -->
                <div x-show="tab === 'dues'" style="display: none;" class="space-y-3">
                    @if($overdueInvoices->isEmpty())
                        <div class="text-center py-10">
                            <div class="text-2xl mb-1">✅</div>
                            <p class="text-xs text-gray-500 dark:text-bodydark">Zero overdue invoices pending across all branches.</p>
                        </div>
                    @else
                        @foreach($overdueInvoices as $inv)
                            <div class="p-3 rounded-xl bg-rose-50/40 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-900/60 flex items-center justify-between gap-3 text-xs">
                                <div>
                                    <a href="{{ route('students.show', $inv->student) }}" class="font-bold text-black dark:text-white hover:text-primary transition block">
                                        {{ $inv->student->full_name }}
                                    </a>
                                    <span class="text-[11px] text-gray-400 font-mono">
                                        {{ $inv->invoice_number }} • Due: {{ $inv->due_date->format('d M') }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="font-mono font-bold text-rose-600 dark:text-rose-400">
                                        ₹{{ number_format($inv->balance_amount, 0) }}
                                    </div>
                                    <a href="{{ route('invoices.show', $inv) }}" class="text-[10px] font-semibold text-primary hover:underline">
                                        Collect →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>

        <!-- BOTTOM SECTION (Branches Overview & Recent Payments) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Physical Branches & Utilization (7 cols) -->
            <div class="lg:col-span-7 rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex items-center justify-between border-b border-stroke dark:border-strokedark pb-4 mb-4">
                    <div>
                        <h3 class="font-bold text-base text-black dark:text-white">Physical Locations & Branch Utilization</h3>
                        <p class="text-xs text-gray-400">Seat counts and capacity across branches</p>
                    </div>
                    @can('branches.create')
                        <a href="{{ route('branches.create') }}" class="text-xs font-semibold text-primary hover:underline">
                            + Add Branch
                        </a>
                    @endcan
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($branches as $b)
                        <div class="p-4 rounded-xl border border-stroke dark:border-strokedark bg-gray-50/50 dark:bg-boxdark-2 space-y-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-sm text-black dark:text-white">{{ $b->name }}</h4>
                                    <span class="text-[11px] font-mono text-primary font-bold">{{ $b->code }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $b->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300' }}">
                                    {{ $b->status }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-xs pt-1 border-t border-stroke dark:border-strokedark">
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Total Seats</span>
                                    <strong class="text-sm font-mono text-black dark:text-white">{{ $b->seats_count }}</strong>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Active Members</span>
                                    <strong class="text-sm font-mono text-black dark:text-white">{{ $b->memberships_count }}</strong>
                                </div>
                            </div>

                            <div class="pt-2 flex justify-between items-center text-xs">
                                <a href="{{ route('seats.map', ['branch_id' => $b->id]) }}" class="text-primary hover:underline font-semibold flex items-center gap-1">
                                    <span>Seat Map</span> <span>→</span>
                                </a>
                                <span class="text-[11px] text-gray-400">📞 {{ $b->phone ?? 'N/A' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Fee Collections (5 cols) -->
            <div class="lg:col-span-5 rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex items-center justify-between border-b border-stroke dark:border-strokedark pb-4 mb-4">
                    <div>
                        <h3 class="font-bold text-base text-black dark:text-white">Recent Fee Collections</h3>
                        <p class="text-xs text-gray-400">Latest recorded student payments</p>
                    </div>
                    <a href="{{ route('invoices.index') }}" class="text-xs font-semibold text-primary hover:underline">
                        All Payments →
                    </a>
                </div>

                @if($recentPayments->isEmpty())
                    <div class="text-center py-10">
                        <div class="text-2xl mb-1">💳</div>
                        <p class="text-xs text-gray-500 dark:text-bodydark">No payments recorded yet.</p>
                    </div>
                @else
                    <div class="divide-y divide-stroke dark:divide-strokedark">
                        @foreach($recentPayments as $pay)
                            <div class="py-2.5 flex items-center justify-between gap-3 text-xs">
                                <div>
                                    <div class="font-bold text-black dark:text-white">
                                        {{ $pay->student->full_name ?? 'Student' }}
                                    </div>
                                    <div class="text-[10px] font-mono text-gray-400">
                                        {{ $pay->payment_number }} • {{ ucfirst($pay->payment_method) }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold font-mono text-emerald-600 dark:text-emerald-400 text-sm">
                                        +₹{{ number_format($pay->amount, 0) }}
                                    </span>
                                    <div class="text-[10px] font-mono text-gray-400">
                                        {{ $pay->payment_date ? $pay->payment_date->format('d M') : '' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    </div>
</x-app-layout>
