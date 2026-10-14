<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Daily Attendance Logs
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark mt-0.5">
                    Track live student check-ins, study duration, and occupancy logs
                </p>
            </div>
            <div class="flex items-center gap-2" x-data="{ showManualModal: false }">
                <a href="{{ route('kiosk.index') }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-4 py-2 font-semibold text-xs text-white shadow hover:bg-emerald-700 transition">
                    📱 Open Attendance Kiosk ↗
                </a>
                <button @click="showManualModal = true" class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-4 py-2 font-semibold text-xs text-white shadow hover:bg-opacity-90 transition">
                    ➕ Manual Check-In
                </button>

                <!-- Manual Check-In Modal -->
                <div x-show="showManualModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
                    <div class="w-full max-w-md rounded-2xl border border-stroke bg-white p-6 shadow-xl dark:border-strokedark dark:bg-boxdark space-y-4" @click.outside="showManualModal = false">
                        <div>
                            <h3 class="text-base font-bold text-black dark:text-white">Manual Student Check-In</h3>
                            <p class="text-xs text-gray-500 dark:text-bodydark">Log a student entry manually into the current branch session.</p>
                        </div>

                        <form method="POST" action="{{ route('attendances.store') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Select Student *</label>
                                <select name="student_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                                    <option value="">-- Select Active Student --</option>
                                    @foreach($activeStudents as $st)
                                        <option value="{{ $st->id }}">{{ $st->full_name }} ({{ $st->student_number }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Branch (Optional)</label>
                                <select name="branch_id" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                                    <option value="">-- Default Branch --</option>
                                    @foreach($branches as $b)
                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Notes</label>
                                <input type="text" name="notes" placeholder="e.g. Card forgotten, staff entry" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                            </div>

                            <div class="flex justify-end gap-3 pt-3 border-t border-stroke dark:border-strokedark">
                                <button type="button" @click="showManualModal = false" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark">Cancel</button>
                                <button type="submit" class="px-5 py-2 rounded-xl bg-primary text-xs font-semibold text-white shadow hover:bg-opacity-90">Confirm Check-In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Attendance Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="rounded-2xl border border-stroke bg-white p-5 shadow-sm dark:border-strokedark dark:bg-boxdark flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Present Now</span>
                    <h3 class="text-3xl font-extrabold text-black dark:text-white mt-1">{{ $stats['present_now'] }}</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Currently inside study room</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 flex items-center justify-center font-bold text-xl">
                    🟢
                </div>
            </div>

            <div class="rounded-2xl border border-stroke bg-white p-5 shadow-sm dark:border-strokedark dark:bg-boxdark flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">Total Check-Ins</span>
                    <h3 class="text-3xl font-extrabold text-black dark:text-white mt-1">{{ $stats['total_checkins'] }}</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Visits logged for {{ date('d M Y', strtotime($selectedDate)) }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold text-xl">
                    📊
                </div>
            </div>

            <div class="rounded-2xl border border-stroke bg-white p-5 shadow-sm dark:border-strokedark dark:bg-boxdark flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Checked Out</span>
                    <h3 class="text-3xl font-extrabold text-black dark:text-white mt-1">{{ $stats['checked_out'] }}</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Completed study sessions</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-gray-100 dark:bg-boxdark-2 text-gray-500 flex items-center justify-center font-bold text-xl">
                    🏁
                </div>
            </div>
        </div>

        <!-- Filter & Search Controls -->
        <div class="rounded-2xl border border-stroke bg-white p-5 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <form method="GET" action="{{ route('attendances.index') }}" class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-bodydark uppercase tracking-wider mb-1">Date</label>
                    <input type="date" name="date" value="{{ $selectedDate }}" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-bodydark uppercase tracking-wider mb-1">Student</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or LIB-000..." class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-bodydark uppercase tracking-wider mb-1">Status</label>
                    <select name="status" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="">All Statuses</option>
                        <option value="present" {{ request('status') === 'present' ? 'selected' : '' }}>Present Now</option>
                        <option value="checked_out" {{ request('status') === 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-bodydark uppercase tracking-wider mb-1">Branch</label>
                    <select name="branch_id" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="">All Branches</option>
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full py-2 px-4 rounded-xl bg-black dark:bg-white text-white dark:text-black font-semibold text-xs hover:bg-opacity-80 transition">
                        Filter Logs
                    </button>
                    <a href="{{ route('attendances.index') }}" class="py-2 px-3 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-600 dark:text-bodydark font-semibold text-xs hover:bg-gray-200 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Attendance Table Card -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                    <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                        <tr>
                            <th class="py-3.5 px-4">Student</th>
                            <th class="py-3.5 px-4">Branch / Desk</th>
                            <th class="py-3.5 px-4">Check-In Time</th>
                            <th class="py-3.5 px-4">Check-Out Time</th>
                            <th class="py-3.5 px-4">Duration</th>
                            <th class="py-3.5 px-4">Method</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stroke dark:divide-strokedark">
                        @forelse($attendances as $att)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 flex-shrink-0 overflow-hidden rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                                            @if($att->student->photo)
                                                <img src="{{ Storage::url($att->student->photo) }}" class="h-full w-full object-cover" />
                                            @else
                                                {{ strtoupper(substr($att->student->first_name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('students.show', $att->student) }}" class="font-bold text-black dark:text-white hover:text-primary transition text-xs">
                                                {{ $att->student->full_name }}
                                            </a>
                                            <p class="text-[11px] font-mono text-gray-400">ID: {{ $att->student->student_number }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-xs font-medium">
                                    <div>{{ $att->branch->name }}</div>
                                    @if($att->seat)
                                        <span class="text-[10px] font-mono text-primary font-bold">Seat: {{ $att->seat->seat_number }}</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs">
                                    {{ $att->check_in_at->format('h:i A') }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs">
                                    {{ $att->check_out_at ? $att->check_out_at->format('h:i A') : '--' }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs font-semibold text-black dark:text-white">
                                    {{ $att->getFormattedDuration() }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-mono text-[10px] uppercase bg-gray-100 dark:bg-boxdark-2 px-2 py-0.5 rounded text-gray-600 dark:text-bodydark">
                                        {{ str_replace('_', ' ', $att->method) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($att->status === 'present')
                                        <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-full uppercase bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                            ● Present
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-full uppercase bg-gray-100 text-gray-700 dark:bg-boxdark-2 dark:text-bodydark">
                                            Checked Out
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    @if($att->status === 'present')
                                        <form method="POST" action="{{ route('attendances.check-out', $att) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 rounded-xl bg-amber-500 text-white font-semibold text-xs shadow hover:bg-amber-600 transition">
                                                Check-Out 🏁
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-xs text-gray-400">
                                    No attendance logs recorded for {{ date('d M Y', strtotime($selectedDate)) }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($attendances->hasPages())
                <div class="p-4 border-t border-stroke dark:border-strokedark">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
