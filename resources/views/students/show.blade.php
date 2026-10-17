<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('students.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                    ← Students
                </a>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Student Profile — {{ $student->full_name }}
                </h2>
            </div>
            <div class="flex items-center gap-2.5">
                <a
                    href="{{ route('students.print-id-card', $student) }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 px-4 py-2.5 font-bold text-xs text-white shadow-md shadow-emerald-600/20 transition"
                >
                    <span>🖨️</span>
                    <span>Print ID Card</span>
                </a>

                @can('update', $student)
                    <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center gap-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 hover:bg-gray-200 dark:hover:bg-strokedark px-4 py-2.5 font-semibold text-xs text-black dark:text-white transition border border-stroke dark:border-strokedark">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Profile
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

        <!-- Profile Header Card -->
        <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark flex flex-col md:flex-row items-center md:items-start gap-6">
            @if($student->photo)
                <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->full_name }}" class="h-28 w-28 rounded-2xl object-cover border-2 border-primary/20 shadow-md">
            @else
                <div class="h-28 w-28 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-extrabold text-3xl shadow-inner">
                    {{ strtoupper(substr($student->first_name, 0, 1)) }}
                </div>
            @endif

            <div class="flex-1 text-center md:text-left space-y-2">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                    <h3 class="text-2xl font-bold text-black dark:text-white">{{ $student->full_name }}</h3>
                    <span class="bg-primary/10 text-primary font-mono text-sm px-3 py-1 rounded-lg font-bold">
                        {{ $student->student_number }}
                    </span>
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
                    @if($student->seat)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-primary/10 text-primary dark:bg-primary/20 dark:text-white border border-primary/20 font-mono">
                            🪑 Seat {{ $student->seat->seat_number }} • {{ $student->seat->room->name ?? 'Hall' }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500 dark:bg-boxdark-2 dark:text-bodydark">
                            🪑 Walk-in / Flexible
                        </span>
                    @endif
                    @if($student->active_membership)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            ✨ {{ $student->active_membership->plan->name ?? 'Active Plan' }}
                        </span>
                    @endif
                </div>

                <p class="text-xs text-gray-500 dark:text-bodydark">
                    Joined on <strong class="font-mono text-black dark:text-white">{{ $student->joined_at ? $student->joined_at->format('d M Y') : 'N/A' }}</strong>
                </p>

                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 pt-2 text-xs font-medium">
                    <span class="flex items-center gap-1.5 text-gray-700 dark:text-gray-300">
                        📞 <span class="font-mono font-bold">{{ $student->mobile }}</span>
                    </span>
                    @if($student->email)
                        <span class="flex items-center gap-1.5 text-gray-700 dark:text-gray-300">
                            ✉️ {{ $student->email }}
                        </span>
                    @endif
                    <span class="flex items-center gap-1.5 text-gray-700 dark:text-gray-300 capitalize">
                        👤 {{ $student->gender }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Personal Information -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-4">
                <h4 class="text-base font-bold text-black dark:text-white border-b border-stroke dark:border-strokedark pb-3">Personal & Address Details</h4>
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400 uppercase tracking-wider font-semibold">Date of Birth</span>
                        <p class="font-semibold text-black dark:text-white mt-1">{{ $student->date_of_birth ? $student->date_of_birth->format('d-m-Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 uppercase tracking-wider font-semibold">City</span>
                        <p class="font-semibold text-black dark:text-white mt-1">{{ $student->city ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 uppercase tracking-wider font-semibold">State</span>
                        <p class="font-semibold text-black dark:text-white mt-1">{{ $student->state ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 uppercase tracking-wider font-semibold">Pincode</span>
                        <p class="font-semibold text-black dark:text-white mt-1">{{ $student->pincode ?? 'N/A' }}</p>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-400 uppercase tracking-wider font-semibold">Residential Address</span>
                        <p class="font-medium text-black dark:text-white mt-1">{{ $student->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Guardian Information -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-4">
                <h4 class="text-base font-bold text-black dark:text-white border-b border-stroke dark:border-strokedark pb-3">Guardian & Emergency Contact</h4>
                @if($student->guardian)
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Guardian Name</span>
                            <p class="font-bold text-black dark:text-white mt-1">{{ $student->guardian->name }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Relationship</span>
                            <p class="font-semibold text-black dark:text-white mt-1">{{ $student->guardian->relationship }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Mobile Phone</span>
                            <p class="font-mono font-bold text-primary mt-1">{{ $student->guardian->mobile }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Alternate Phone</span>
                            <p class="font-mono font-semibold text-black dark:text-white mt-1">{{ $student->guardian->alternate_mobile ?? 'N/A' }}</p>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Guardian Email</span>
                            <p class="font-medium text-black dark:text-white mt-1">{{ $student->guardian->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-gray-400 py-6 text-center">No guardian details recorded.</p>
                @endif
            </div>

            @if($student->seat)
                <!-- Allocated Seat Details -->
                <div class="col-span-1 md:col-span-2 rounded-2xl border border-primary/20 bg-primary/5 p-6 shadow-sm dark:border-primary/30 dark:bg-primary/10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-primary/10 dark:border-primary/20 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-xl shadow-sm">
                                🪑
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-black dark:text-white">Allocated Desk: Seat {{ $student->seat->seat_number }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $student->seat->branch->name ?? 'Main Branch' }} • {{ $student->seat->room->name ?? 'General Hall' }} ({{ $student->seat->floor->name ?? 'Main Floor' }})</p>
                            </div>
                        </div>
                        <a href="{{ route('seats.map', ['branch_id' => $student->seat->branch_id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-boxdark text-primary dark:text-white font-semibold text-xs border border-primary/20 hover:bg-primary/10 transition">
                            🗺️ View on Seat Map
                        </a>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-xs">
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Seat Number</span>
                            <p class="font-mono font-extrabold text-base text-black dark:text-white mt-1">{{ $student->seat->seat_number }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Desk Category</span>
                            <p class="font-semibold text-black dark:text-white mt-1">{{ $student->seat->seatType->name ?? 'Standard' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Monthly Rate</span>
                            <p class="font-mono font-bold text-primary mt-1">₹{{ number_format($student->seat->seatType->monthly_price ?? 0, 2) }} / mo</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Seat Status</span>
                            <p class="mt-1"><span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Occupied by Student</span></p>
                        </div>
                    </div>
                </div>
            @endif

            @if($student->active_membership)
                <!-- Active Membership Package Details -->
                <div class="col-span-1 md:col-span-2 rounded-2xl border border-emerald-200 bg-emerald-50/50 p-6 shadow-sm dark:border-emerald-900/60 dark:bg-emerald-950/20">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-emerald-100 dark:border-emerald-900/40 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl shadow-sm">
                                💳
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-black dark:text-white">Active Package: {{ $student->active_membership->plan->name ?? 'Membership' }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Duration: <strong>{{ $student->active_membership->plan->duration_days ?? 30 }} Days</strong> • 
                                    Valid from {{ $student->active_membership->start_date?->format('d M Y') }} to {{ $student->active_membership->end_date?->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('memberships.index', ['student_id' => $student->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-boxdark text-emerald-700 dark:text-emerald-300 font-semibold text-xs border border-emerald-200 dark:border-emerald-800 hover:bg-emerald-50 transition">
                            📑 All Memberships History
                        </a>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-xs">
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Package Price</span>
                            <p class="font-mono font-bold text-emerald-700 dark:text-emerald-300 mt-1">₹{{ number_format($student->active_membership->final_amount, 2) }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Start Date</span>
                            <p class="font-semibold text-black dark:text-white mt-1">{{ $student->active_membership->start_date?->format('d M Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Expiration Date</span>
                            <p class="font-semibold text-black dark:text-white mt-1">{{ $student->active_membership->end_date?->format('d M Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Status</span>
                            <p class="mt-1"><span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Active Membership</span></p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- ID Card & Kiosk QR Badge Section -->
            <div class="col-span-1 md:col-span-2 rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-stroke dark:border-strokedark pb-4">
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold text-xl shadow-sm border border-purple-200 dark:border-purple-800">
                            🪪
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-black dark:text-white">Student Identity Card & Kiosk QR Badge</h4>
                            <p class="text-xs text-gray-500 dark:text-bodydark">Standard PVC / Lanyard format for attendance kiosk camera check-in</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a
                            href="{{ route('students.print-id-card', $student) }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition"
                        >
                            <span>🖨️</span>
                            <span>Print ID Card ↗</span>
                        </a>
                        @if($student->activeIdCard)
                            <a
                                href="{{ route('id-cards.show', $student->activeIdCard) }}"
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 hover:bg-gray-200 dark:hover:bg-strokedark text-gray-700 dark:text-bodydark font-semibold text-xs transition"
                            >
                                Preview Badge
                            </a>
                        @endif
                    </div>
                </div>

                @if($student->activeIdCard)
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-xs">
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Badge Card Number</span>
                            <p class="font-mono font-extrabold text-sm text-primary mt-1">{{ $student->activeIdCard->card_number }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Issue Date</span>
                            <p class="font-semibold text-black dark:text-white mt-1">{{ $student->activeIdCard->issue_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Expiry Date</span>
                            <p class="font-semibold text-black dark:text-white mt-1">{{ $student->activeIdCard->expiry_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Card Status</span>
                            <p class="mt-1">
                                <span class="px-2.5 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider {{ $student->activeIdCard->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                                    ● {{ $student->activeIdCard->status }}
                                </span>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="pt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs bg-gray-50/70 dark:bg-boxdark-2 p-4 rounded-xl border border-dashed border-stroke dark:border-strokedark mt-3">
                        <div class="text-gray-500 dark:text-bodydark">
                            No active ID card generated yet for this student. Click the button to automatically issue a unique QR card.
                        </div>
                        <a
                            href="{{ route('students.print-id-card', $student) }}"
                            target="_blank"
                            class="px-4 py-2 rounded-xl bg-primary hover:bg-opacity-90 text-white font-bold text-xs transition whitespace-nowrap shadow"
                        >
                            ⚡ Issue & Print ID Card
                        </a>
                    </div>
                @endif
            </div>

        </div>

    </div>
</x-app-layout>
