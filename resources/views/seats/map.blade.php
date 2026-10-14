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
                <a href="{{ route('seat-types.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-4 py-2 font-semibold text-xs text-gray-700 dark:text-bodydark hover:bg-gray-200 dark:hover:bg-strokedark transition">
                    🏷️ Seat Packages
                </a>
                @can('seats.create')
                    <a href="{{ route('seats.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 font-semibold text-xs text-white shadow hover:bg-primary-hover transition">
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

        <!-- Filter Bar -->
        <div class="rounded-2xl border border-stroke bg-white p-4 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <form method="GET" action="{{ route('seats.map') }}" class="flex flex-wrap items-center gap-4">
                <!-- Branch Selector -->
                <div class="w-full sm:w-64">
                    <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Select Branch</label>
                    <select
                        name="branch_id"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white font-semibold outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $selectedBranchId == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }} ({{ $branch->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Floor Filter -->
                <div class="w-full sm:w-48">
                    <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Filter Floor</label>
                    <select
                        name="floor_id"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white font-semibold outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        <option value="">All Floors</option>
                        @foreach($floors as $fl)
                            <option value="{{ $fl->id }}" {{ request('floor_id') == $fl->id ? 'selected' : '' }}>
                                {{ $fl->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Room Filter -->
                <div class="w-full sm:w-48">
                    <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Filter Room</label>
                    <select
                        name="room_id"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white font-semibold outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        <option value="">All Rooms</option>
                        @foreach($rooms as $rm)
                            <option value="{{ $rm->id }}" {{ request('room_id') == $rm->id ? 'selected' : '' }}>
                                {{ $rm->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Occupancy Bar Metrics -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="rounded-2xl border border-stroke bg-white p-4 dark:border-strokedark dark:bg-boxdark text-center">
                <span class="text-xs text-gray-400 font-semibold uppercase">Total Seats</span>
                <p class="text-2xl font-extrabold text-black dark:text-white mt-1">{{ $totalSeats }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-4 dark:border-emerald-900 dark:bg-emerald-950/40 text-center">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold uppercase">Available</span>
                <p class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">{{ $availableSeats }}</p>
            </div>
            <div class="rounded-2xl border border-primary/20 bg-primary/5 p-4 dark:border-primary/40 dark:bg-primary/10 text-center">
                <span class="text-xs text-primary font-semibold uppercase">Occupied</span>
                <p class="text-2xl font-extrabold text-primary mt-1">{{ $occupiedSeats }}</p>
            </div>
            <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-4 dark:border-amber-900 dark:bg-amber-950/40 text-center">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold uppercase">Reserved</span>
                <p class="text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-1">{{ $reservedSeats }}</p>
            </div>
            <div class="rounded-2xl border border-red-200 bg-red-50/50 p-4 dark:border-red-900 dark:bg-red-950/40 text-center col-span-2 md:col-span-1">
                <span class="text-xs text-red-600 dark:text-red-400 font-semibold uppercase">Maintenance</span>
                <p class="text-2xl font-extrabold text-red-600 dark:text-red-400 mt-1">{{ $maintenanceSeats }}</p>
            </div>
        </div>

        <!-- Legend -->
        <div class="flex flex-wrap items-center gap-6 px-4 py-3 bg-white dark:bg-boxdark rounded-xl border border-stroke dark:border-strokedark text-xs font-semibold">
            <span class="text-gray-400">Status Legend:</span>
            <div class="flex items-center gap-2"><span class="h-3.5 w-3.5 rounded bg-emerald-500"></span> Available</div>
            <div class="flex items-center gap-2"><span class="h-3.5 w-3.5 rounded bg-primary"></span> Occupied</div>
            <div class="flex items-center gap-2"><span class="h-3.5 w-3.5 rounded bg-amber-500"></span> Reserved</div>
            <div class="flex items-center gap-2"><span class="h-3.5 w-3.5 rounded bg-red-500"></span> Maintenance</div>
            <div class="flex items-center gap-2"><span class="h-3.5 w-3.5 rounded bg-gray-400"></span> Inactive</div>
        </div>

        <!-- Interactive Visual Seat Grid -->
        <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
            @if($seats->isEmpty())
                <div class="text-center py-16">
                    <p class="text-gray-500 dark:text-bodydark text-sm">No seats found for this branch selection.</p>
                    <a href="{{ route('seats.create') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-primary text-xs font-semibold text-white rounded-xl">
                        + Generate Seats Now
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
                    @foreach($seats as $seat)
                        @php
                            $colors = [
                                'available' => 'bg-emerald-50 text-emerald-700 border-emerald-300 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800 hover:bg-emerald-100',
                                'occupied' => 'bg-primary/10 text-primary border-primary/30 dark:bg-primary/20 dark:text-white dark:border-primary/50 hover:bg-primary/20',
                                'reserved' => 'bg-amber-50 text-amber-700 border-amber-300 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800 hover:bg-amber-100',
                                'maintenance' => 'bg-red-50 text-red-700 border-red-300 dark:bg-red-950/60 dark:text-red-300 dark:border-red-800 hover:bg-red-100',
                                'inactive' => 'bg-gray-100 text-gray-500 border-gray-300 dark:bg-boxdark-2 dark:text-bodydark dark:border-strokedark',
                            ];
                        @endphp
                        <div
                            x-data="{ showMenu: false }"
                            class="relative p-3.5 rounded-2xl border text-center font-mono transition flex flex-col justify-between cursor-pointer shadow-sm hover:shadow-md {{ $colors[$seat->status] ?? '' }}"
                            @click="showMenu = !showMenu"
                        >
                            <div class="flex items-center justify-between text-[10px] text-gray-400 mb-1 font-sans">
                                <span>{{ $seat->seatType->name }}</span>
                                <span class="font-bold">₹{{ number_format($seat->seatType->monthly_price, 0) }}</span>
                            </div>

                            <div class="my-1">
                                <span class="text-lg font-bold tracking-tight text-black dark:text-white">{{ $seat->seat_number }}</span>
                            </div>

                            <div class="mt-1 text-[10px] uppercase font-bold tracking-wider font-sans">
                                {{ $seat->status }}
                            </div>

                            <!-- Quick Action Popover Menu -->
                            <div
                                x-show="showMenu"
                                @click.outside="showMenu = false"
                                x-transition
                                class="absolute top-full left-0 mt-2 z-30 w-44 rounded-xl border border-stroke bg-white p-2 shadow-xl dark:border-strokedark dark:bg-boxdark text-left text-xs font-sans"
                            >
                                <span class="block px-2 py-1 text-[10px] font-bold text-gray-400 uppercase border-b border-stroke dark:border-strokedark mb-1">Seat {{ $seat->seat_number }} Actions</span>

                                <form method="POST" action="{{ route('seats.update-status', $seat) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="available">
                                    <button type="submit" class="w-full text-left px-2 py-1 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/50 rounded font-semibold">Mark Available</button>
                                </form>

                                <form method="POST" action="{{ route('seats.update-status', $seat) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="maintenance">
                                    <button type="submit" class="w-full text-left px-2 py-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded font-semibold">Mark Maintenance</button>
                                </form>

                                <form method="POST" action="{{ route('seats.update-status', $seat) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="reserved">
                                    <button type="submit" class="w-full text-left px-2 py-1 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-950/50 rounded font-semibold">Mark Reserved</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
