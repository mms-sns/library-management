<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Interactive Seat Map & Occupancy
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Real-time study seat occupancy and allocation visualizer</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('seats.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-4 py-2 font-semibold text-xs text-gray-700 dark:text-bodydark hover:bg-gray-200 dark:hover:bg-strokedark transition">
                    📋 Seat Directory
                </a>
                @can('seats.create')
                    <a href="{{ route('seats.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 font-semibold text-xs text-white shadow hover:bg-opacity-90 transition">
                        + Add / Bulk Generate
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

        <!-- Filter Bar: Branch, Status & Quick Search (No Floors, No Rooms) -->
        <div class="rounded-2xl border border-stroke bg-white p-4 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <form method="GET" action="{{ route('seats.map') }}" class="flex flex-wrap items-center gap-4">
                <!-- Branch Selector -->
                <div class="w-full sm:w-64">
                    <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Select Branch</label>
                    <select
                        name="branch_id"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white font-semibold outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition cursor-pointer"
                    >
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $selectedBranchId == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }} ({{ $branch->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full sm:w-48">
                    <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Filter Status</label>
                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white font-semibold outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition cursor-pointer"
                    >
                        <option value="">All Statuses</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>🟢 Available</option>
                        <option value="occupied" {{ request('status') === 'occupied' ? 'selected' : '' }}>🔵 Occupied</option>
                        <option value="reserved" {{ request('status') === 'reserved' ? 'selected' : '' }}>🟡 Reserved</option>
                        <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>🔴 Maintenance</option>
                    </select>
                </div>

                <!-- Search Seat Number -->
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Search Seat Number</label>
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="e.g. A-01, CAB-05..."
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 pl-3 pr-8 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition font-mono uppercase"
                        />
                        <button type="submit" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary">
                            🔍
                        </button>
                    </div>
                </div>

                @if(request()->hasAny(['status', 'search']))
                    <div class="pt-4">
                        <a href="{{ route('seats.map', ['branch_id' => $selectedBranchId]) }}" class="px-3 py-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-600 dark:text-bodydark text-xs font-semibold hover:bg-gray-200 dark:hover:bg-strokedark transition">
                            Reset Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Occupancy Bar Metrics -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="rounded-2xl border border-stroke bg-white p-4 dark:border-strokedark dark:bg-boxdark text-center shadow-sm">
                <span class="text-xs text-gray-400 font-semibold uppercase">Total Seats</span>
                <p class="text-2xl font-extrabold text-black dark:text-white mt-1">{{ $totalSeats }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-4 dark:border-emerald-900/60 dark:bg-emerald-950/40 text-center shadow-sm">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold uppercase">Available</span>
                <p class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">{{ $availableSeats }}</p>
            </div>
            <div class="rounded-2xl border border-primary/20 bg-primary/5 p-4 dark:border-primary/40 dark:bg-primary/10 text-center shadow-sm">
                <span class="text-xs text-primary font-semibold uppercase">Occupied</span>
                <p class="text-2xl font-extrabold text-primary mt-1">{{ $occupiedSeats }}</p>
            </div>
            <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-4 dark:border-amber-900/60 dark:bg-amber-950/40 text-center shadow-sm">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold uppercase">Reserved</span>
                <p class="text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-1">{{ $reservedSeats }}</p>
            </div>
            <div class="rounded-2xl border border-red-200 bg-red-50/50 p-4 dark:border-red-900/60 dark:bg-red-950/40 text-center col-span-2 md:col-span-1 shadow-sm">
                <span class="text-xs text-red-600 dark:text-red-400 font-semibold uppercase">Maintenance</span>
                <p class="text-2xl font-extrabold text-red-600 dark:text-red-400 mt-1">{{ $maintenanceSeats }}</p>
            </div>
        </div>

        <!-- Legend -->
        <div class="flex flex-wrap items-center justify-between gap-4 px-4 py-3 bg-white dark:bg-boxdark rounded-xl border border-stroke dark:border-strokedark text-xs font-semibold">
            <div class="flex flex-wrap items-center gap-5">
                <span class="text-gray-400 uppercase tracking-wider text-[11px]">Legend:</span>
                <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-emerald-500"></span> Available</div>
                <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-primary"></span> Occupied</div>
                <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-amber-500"></span> Reserved</div>
                <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-red-500"></span> Maintenance</div>
            </div>
            <div class="text-gray-400 text-[11px] font-sans">
                Occupancy Rate: <strong class="text-black dark:text-white font-mono">{{ $occupancyRate }}%</strong>
            </div>
        </div>

        <!-- Interactive Visual Seat Grid -->
        <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
            @if($seats->isEmpty())
                <div class="text-center py-16">
                    <div class="h-14 w-14 rounded-full bg-gray-100 dark:bg-boxdark-2 flex items-center justify-center text-2xl mx-auto mb-3">
                        🪑
                    </div>
                    <p class="text-gray-500 dark:text-bodydark text-sm font-medium">No seats match the selected branch and criteria.</p>
                    <a href="{{ route('seats.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-xs font-semibold text-white rounded-xl shadow hover:bg-opacity-90 transition">
                        + Generate Seats for Branch
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3 sm:gap-4">
                    @foreach($seats as $seat)
                        @php
                            $colors = [
                                'available' => 'bg-emerald-50 text-emerald-800 border-emerald-300/80 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800/80 hover:border-emerald-400',
                                'occupied' => 'bg-primary/10 text-primary border-primary/30 dark:bg-primary/20 dark:text-white dark:border-primary/50 hover:border-primary',
                                'reserved' => 'bg-amber-50 text-amber-800 border-amber-300/80 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800/80 hover:border-amber-400',
                                'maintenance' => 'bg-red-50 text-red-800 border-red-300/80 dark:bg-red-950/40 dark:text-red-300 dark:border-red-800/80 hover:border-red-400',
                                'inactive' => 'bg-gray-100 text-gray-500 border-gray-300 dark:bg-boxdark-2 dark:text-bodydark dark:border-strokedark',
                            ];

                            $dotColors = [
                                'available' => 'bg-emerald-500',
                                'occupied' => 'bg-primary',
                                'reserved' => 'bg-amber-500',
                                'maintenance' => 'bg-red-500',
                                'inactive' => 'bg-gray-400',
                            ];
                        @endphp
                        <div
                            x-data="{ showMenu: false }"
                            class="relative p-3 rounded-2xl border text-center transition flex flex-col justify-between cursor-pointer shadow-sm hover:shadow-md {{ $colors[$seat->status] ?? '' }}"
                            @click="showMenu = !showMenu"
                        >
                            <!-- Top Status Dot -->
                            <div class="flex items-center justify-between">
                                <span class="h-2 w-2 rounded-full {{ $dotColors[$seat->status] ?? 'bg-gray-400' }}"></span>
                                <span class="text-[10px] uppercase font-bold tracking-wider font-sans opacity-80">
                                    {{ $seat->status }}
                                </span>
                            </div>

                            <!-- Large Seat Number -->
                            <div class="my-2.5">
                                <span class="text-xl sm:text-2xl font-black font-mono tracking-tight text-black dark:text-white">
                                    {{ $seat->seat_number }}
                                </span>
                            </div>

                            <!-- Assigned Student Info (if any) or Vacant Indicator -->
                            <div class="pt-1 text-[11px] font-sans truncate">
                                @if($seat->student)
                                    <div class="font-bold text-black dark:text-white truncate" title="{{ $seat->student->full_name }}">
                                        👤 {{ $seat->student->first_name }}
                                    </div>
                                    <div class="text-[9px] font-mono opacity-70">
                                        {{ $seat->student->student_number }}
                                    </div>
                                @else
                                    <span class="text-[10px] opacity-60 font-medium">
                                        {{ $seat->status === 'available' ? 'Vacant' : '—' }}
                                    </span>
                                @endif
                            </div>

                            <!-- Quick Action Popover Menu -->
                            <div
                                x-show="showMenu"
                                @click.outside="showMenu = false"
                                x-transition
                                class="absolute top-full left-1/2 -translate-x-1/2 mt-1.5 z-40 w-44 rounded-xl border border-stroke bg-white p-2 shadow-2xl dark:border-strokedark dark:bg-boxdark text-left text-xs font-sans"
                                style="display: none;"
                            >
                                <span class="block px-2 py-1 text-[10px] font-bold text-gray-400 uppercase border-b border-stroke dark:border-strokedark mb-1">
                                    Seat {{ $seat->seat_number }}
                                </span>

                                @if($seat->student)
                                    <a
                                        href="{{ route('students.show', $seat->student) }}"
                                        class="block w-full px-2 py-1.5 text-primary hover:bg-primary/10 rounded font-semibold transition"
                                    >
                                        👤 View Student Profile
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('seats.update-status', $seat) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="available">
                                    <button type="submit" class="w-full text-left px-2 py-1.5 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/50 rounded font-semibold transition flex items-center gap-1.5">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Mark Available
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('seats.update-status', $seat) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="occupied">
                                    <button type="submit" class="w-full text-left px-2 py-1.5 text-primary hover:bg-primary/10 rounded font-semibold transition flex items-center gap-1.5">
                                        <span class="h-2 w-2 rounded-full bg-primary"></span> Mark Occupied
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('seats.update-status', $seat) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="reserved">
                                    <button type="submit" class="w-full text-left px-2 py-1.5 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-950/50 rounded font-semibold transition flex items-center gap-1.5">
                                        <span class="h-2 w-2 rounded-full bg-amber-500"></span> Mark Reserved
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('seats.update-status', $seat) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="maintenance">
                                    <button type="submit" class="w-full text-left px-2 py-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded font-semibold transition flex items-center gap-1.5">
                                        <span class="h-2 w-2 rounded-full bg-red-500"></span> Mark Maintenance
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
