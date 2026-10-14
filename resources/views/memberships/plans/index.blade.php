<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Membership Duration Plans & Packages
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Manage library subscription plans (Monthly, Quarterly, Half-Yearly, Yearly)</p>
            </div>
            <a href="{{ route('memberships.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← Back to Memberships
            </a>
        </div>
    </x-slot>

    <div class="space-y-6" x-data="{ showModal: false, isEdit: false, formAction: '', name: '', duration_days: '', price: '', description: '', status: 'active' }">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <div class="flex justify-end">
            <button
                @click="showModal = true; isEdit = false; name = ''; duration_days = '30'; price = ''; description = ''; status = 'active';"
                class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 font-semibold text-xs text-white shadow hover:bg-primary-hover transition"
            >
                + Add Membership Plan
            </button>
        </div>

        <!-- Plans Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($plans as $plan)
                <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-4 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-bold text-black dark:text-white">{{ $plan->name }}</h3>
                            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $plan->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($plan->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-bodydark mt-1">{{ $plan->description ?? 'Library subscription package' }}</p>

                        <div class="mt-4 pt-3 border-t border-stroke dark:border-strokedark flex items-baseline justify-between">
                            <span class="text-2xl font-extrabold text-primary font-mono">₹{{ number_format($plan->price, 0) }}</span>
                            <span class="text-xs font-bold text-gray-400 uppercase font-mono">{{ $plan->duration_days }} Days</span>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-stroke dark:border-strokedark flex justify-end">
                        <button
                            @click="showModal = true; isEdit = true; formAction = '{{ route('membership-plans.update', $plan) }}'; name = '{{ $plan->name }}'; duration_days = '{{ $plan->duration_days }}'; price = '{{ $plan->price }}'; description = '{{ $plan->description }}'; status = '{{ $plan->status }}';"
                            class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline"
                        >
                            Edit Plan
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Add/Edit Plan Modal -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div class="w-full max-w-md rounded-2xl border border-stroke bg-white p-6 shadow-xl dark:border-strokedark dark:bg-boxdark space-y-4" @click.outside="showModal = false">
                <h3 class="text-base font-bold text-black dark:text-white" x-text="isEdit ? 'Edit Membership Plan' : 'Create Membership Plan'"></h3>

                <form method="POST" :action="isEdit ? formAction : '{{ route('membership-plans.store') }}'" class="space-y-4">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Plan Name *</label>
                        <input type="text" name="name" x-model="name" required placeholder="e.g. Monthly Plan" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Duration (Days) *</label>
                            <input type="number" name="duration_days" x-model="duration_days" required min="1" max="3650" placeholder="30" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Price (INR ₹) *</label>
                            <input type="number" step="0.01" name="price" x-model="price" required placeholder="1500" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                        </div>
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
                        <button type="submit" class="px-5 py-2 rounded-xl bg-primary text-xs font-semibold text-white hover:bg-primary-hover">Save Plan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
