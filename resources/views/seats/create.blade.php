<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                Add / Generate Seats
            </h2>
            <a href="{{ route('seats.map') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← Back to Seat Map
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-2 space-y-8" x-data="{ mode: 'bulk' }">

        <!-- Mode Toggle Tabs -->
        <div class="flex justify-center border-b border-stroke dark:border-strokedark pb-4">
            <div class="inline-flex rounded-xl bg-gray-100 dark:bg-boxdark-2 p-1.5 border border-stroke dark:border-strokedark">
                <button
                    type="button"
                    @click="mode = 'bulk'"
                    :class="mode === 'bulk' ? 'bg-white dark:bg-boxdark text-black dark:text-white shadow-sm font-bold' : 'text-gray-500 font-semibold'"
                    class="px-5 py-2 rounded-lg text-xs transition"
                >
                    ⚡ Bulk Seat Generator
                </button>
                <button
                    type="button"
                    @click="mode = 'single'"
                    :class="mode === 'single' ? 'bg-white dark:bg-boxdark text-black dark:text-white shadow-sm font-bold' : 'text-gray-500 font-semibold'"
                    class="px-5 py-2 rounded-lg text-xs transition"
                >
                    ➕ Single Seat Creation
                </button>
            </div>
        </div>

        <!-- 1. BULK SEAT GENERATOR -->
        <form x-show="mode === 'bulk'" method="POST" action="{{ route('seats.bulk-generate') }}" class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            @csrf

            <div class="border-b border-stroke dark:border-strokedark pb-3">
                <h3 class="text-base font-bold text-black dark:text-white">Batch Seat Generator</h3>
                <p class="text-xs text-gray-500 dark:text-bodydark">Instantly create a range of sequential seats (e.g. A-01 to A-30)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="bulk_branch_id" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Branch *</label>
                    <select id="bulk_branch_id" name="branch_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }} ({{ $branch->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="bulk_seat_type_id" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Seat Package / Type *</label>
                    <select id="bulk_seat_type_id" name="seat_type_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        @foreach($seatTypes as $st)
                            <option value="{{ $st->id }}">{{ $st->name }} — ₹{{ number_format($st->monthly_price, 0) }}/mo</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="prefix" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Seat Prefix *</label>
                    <input id="prefix" name="prefix" type="text" value="A-" required placeholder="e.g. A- or CAB-" class="w-full uppercase font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_num" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Start # *</label>
                        <input id="start_num" name="start_num" type="number" value="1" min="1" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>
                    <div>
                        <label for="end_num" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">End # *</label>
                        <input id="end_num" name="end_num" type="number" value="25" min="1" max="500" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-stroke dark:border-strokedark">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-semibold text-xs uppercase tracking-widest hover:bg-primary-hover shadow-md transition">⚡ Generate Seat Batch</button>
            </div>
        </form>

        <!-- 2. SINGLE SEAT CREATION -->
        <form x-show="mode === 'single'" method="POST" action="{{ route('seats.store') }}" class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            @csrf

            <div class="border-b border-stroke dark:border-strokedark pb-3">
                <h3 class="text-base font-bold text-black dark:text-white">Create Single Seat</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="branch_id" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Branch *</label>
                    <select id="branch_id" name="branch_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="seat_number" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Seat Number *</label>
                    <input id="seat_number" name="seat_number" type="text" required placeholder="e.g. A-101" class="w-full font-mono uppercase rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="seat_type_id" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Seat Package / Type *</label>
                    <select id="seat_type_id" name="seat_type_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        @foreach($seatTypes as $st)
                            <option value="{{ $st->id }}">{{ $st->name }} — ₹{{ number_format($st->monthly_price, 0) }}/mo</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Status *</label>
                    <select id="status" name="status" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="reserved">Reserved</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-stroke dark:border-strokedark">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-semibold text-xs uppercase tracking-widest hover:bg-primary-hover shadow-md transition">Create Seat</button>
            </div>
        </form>

    </div>
</x-app-layout>
