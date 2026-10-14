<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.saas-packages.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← SaaS Packages
            </a>
            <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                Edit SaaS Package: {{ $saasPackage->name }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            <div>
                <h3 class="text-base font-bold text-black dark:text-white">Update Package Tier Specifications</h3>
                <p class="text-xs text-gray-500 dark:text-bodydark">Modify pricing and capacity quotas for this SaaS tier.</p>
            </div>

            <form method="POST" action="{{ route('admin.saas-packages.update', $saasPackage) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Package Name *</label>
                    <input type="text" name="name" value="{{ old('name', $saasPackage->name) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Description</label>
                    <input type="text" name="description" value="{{ old('description', $saasPackage->description) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Monthly Price (INR ₹) *</label>
                        <input type="number" step="0.01" name="monthly_price" value="{{ old('monthly_price', $saasPackage->monthly_price) }}" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Yearly Price (INR ₹) *</label>
                        <input type="number" step="0.01" name="yearly_price" value="{{ old('yearly_price', $saasPackage->yearly_price) }}" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Max Branches *</label>
                        <input type="number" name="max_branches" value="{{ old('max_branches', $saasPackage->max_branches) }}" min="0" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                        <span class="text-[10px] text-gray-400 mt-0.5 block">0 = Unlimited</span>
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Max Seats *</label>
                        <input type="number" name="max_seats" value="{{ old('max_seats', $saasPackage->max_seats) }}" min="0" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                        <span class="text-[10px] text-gray-400 mt-0.5 block">0 = Unlimited</span>
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Max Students *</label>
                        <input type="number" name="max_students" value="{{ old('max_students', $saasPackage->max_students) }}" min="0" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                        <span class="text-[10px] text-gray-400 mt-0.5 block">0 = Unlimited</span>
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Status *</label>
                    <select name="status" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="active" {{ $saasPackage->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $saasPackage->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-stroke dark:border-strokedark">
                    <a href="{{ route('admin.saas-packages.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark hover:bg-gray-200 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-xs font-semibold text-white shadow hover:bg-opacity-90 transition">
                        Update SaaS Package
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
