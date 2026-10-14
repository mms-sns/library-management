<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Seat Packages & Monthly Pricing
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Manage seat categories (Normal, Premium AC, Cabin) and monthly pricing</p>
            </div>
            <a href="{{ route('seats.map') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← Back to Seat Map
            </a>
        </div>
    </x-slot>

    <div class="space-y-6" x-data="{ showModal: false, isEdit: false, formAction: '', name: '', description: '', price: '', status: 'active' }">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <div class="flex justify-end">
            <button
                @click="showModal = true; isEdit = false; name = ''; description = ''; price = ''; status = 'active';"
                class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 font-semibold text-xs text-white shadow hover:bg-primary-hover transition"
            >
                + Add Seat Package
            </button>
        </div>

        <!-- Seat Packages Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($seatTypes as $st)
                <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-3 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-bold text-black dark:text-white">{{ $st->name }}</h3>
                            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $st->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($st->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-bodydark mt-1">{{ $st->description ?? 'Standard seat package' }}</p>
                    </div>

                    <div class="border-t border-stroke dark:border-strokedark pt-3 flex justify-between items-center">
                        <div>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Monthly Rate</span>
                            <span class="text-xl font-extrabold text-primary font-mono">₹{{ number_format($st->monthly_price, 2) }}</span>
                        </div>
                        <button
                            @click="showModal = true; isEdit = true; formAction = '{{ route('seat-types.update', $st) }}'; name = '{{ $st->name }}'; description = '{{ $st->description }}'; price = '{{ $st->monthly_price }}'; status = '{{ $st->status }}';"
                            class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline"
                        >
                            Edit Pricing
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Add/Edit Seat Package Modal -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div class="w-full max-w-md rounded-2xl border border-stroke bg-white p-6 shadow-xl dark:border-strokedark dark:bg-boxdark space-y-4" @click.outside="showModal = false">
                <h3 class="text-base font-bold text-black dark:text-white" x-text="isEdit ? 'Edit Seat Package' : 'Create Seat Package'"></h3>

                <form method="POST" :action="isEdit ? formAction : '{{ route('seat-types.store') }}'" class="space-y-4">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Package Name *</label>
                        <input type="text" name="name" x-model="name" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Monthly Price (INR ₹) *</label>
                        <input type="number" step="0.01" name="monthly_price" x-model="price" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Description</label>
                        <textarea name="description" x-model="description" rows="2" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"></textarea>
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Status</label>
                        <select name="status" x-model="status" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-stroke dark:border-strokedark">
                        <button type="button" @click="showModal = false" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-primary text-xs font-semibold text-white hover:bg-primary-hover">Save Package</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
