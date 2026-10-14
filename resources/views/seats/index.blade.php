<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Seats Directory
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Manage individual seats, floor locations, and packages</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('seats.map') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary/10 text-primary px-4 py-2 font-semibold text-xs hover:bg-primary/20 transition">
                    🗺️ Open Seat Map
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
            <form method="GET" action="{{ route('seats.index') }}" class="flex flex-wrap items-center gap-4">
                <div class="w-full sm:w-64">
                    <select
                        name="branch_id"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full sm:w-48">
                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        <option value="">All Statuses</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="occupied" {{ request('status') === 'occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="reserved" {{ request('status') === 'reserved' ? 'selected' : '' }}>Reserved</option>
                        <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                @if(request()->hasAny(['branch_id', 'status']))
                    <a href="{{ route('seats.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-600 dark:text-bodydark text-xs font-semibold hover:bg-gray-200 dark:hover:bg-strokedark transition">
                        Clear Filters
                    </a>
                @endif
            </form>
        </div>

        <!-- Seats Table -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            @if($seats->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-bodydark text-sm">No seats found.</p>
                </div>
            @else
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                        <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                            <tr>
                                <th class="p-4 px-6">Seat Number</th>
                                <th class="p-4">Branch</th>
                                <th class="p-4">Floor & Room</th>
                                <th class="p-4">Seat Package / Pricing</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stroke dark:divide-strokedark">
                            @foreach($seats as $seat)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                    <td class="p-4 px-6">
                                        <span class="font-mono text-base font-bold text-black dark:text-white bg-gray-100 dark:bg-boxdark-2 px-3 py-1 rounded-lg">
                                            {{ $seat->seat_number }}
                                        </span>
                                    </td>
                                    <td class="p-4 font-semibold text-black dark:text-white">
                                        {{ $seat->branch->name }}
                                    </td>
                                    <td class="p-4 text-xs">
                                        <span class="block text-black dark:text-white font-medium">{{ $seat->floor->name ?? 'Main Floor' }}</span>
                                        <span class="block text-gray-400">{{ $seat->room->name ?? 'General Hall' }}</span>
                                    </td>
                                    <td class="p-4">
                                        <span class="font-bold text-black dark:text-white">{{ $seat->seatType->name }}</span>
                                        <span class="block text-xs font-mono text-primary font-bold">₹{{ number_format($seat->seatType->monthly_price, 2) }} / mo</span>
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $statusColors = [
                                                'available' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                                                'occupied' => 'bg-primary/10 text-primary dark:bg-primary/20 dark:text-white',
                                                'reserved' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                                                'maintenance' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300',
                                                'inactive' => 'bg-gray-100 text-gray-800 dark:bg-boxdark-2 dark:text-bodydark',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$seat->status] ?? '' }}">
                                            {{ ucfirst($seat->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 px-6 text-right space-x-2">
                                        @can('delete', $seat)
                                            <form method="POST" action="{{ route('seats.destroy', $seat) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to archive this seat?')">
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
                    {{ $seats->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
