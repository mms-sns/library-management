<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                Add New Library Branch
            </h2>
            <a href="{{ route('branches.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← Back to Branches
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-2">
        <form method="POST" action="{{ route('branches.store') }}" class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            @csrf

            <div class="border-b border-stroke dark:border-strokedark pb-4">
                <h3 class="text-base font-bold text-black dark:text-white">Branch Information</h3>
                <p class="text-xs text-gray-500 dark:text-bodydark">Physical branch details for location management</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Branch Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required placeholder="e.g. Connaught Place Branch" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    <x-input-error class="mt-1" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label for="code" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Branch Code</label>
                    <input id="code" name="code" type="text" value="{{ old('code') }}" required placeholder="e.g. CP-01" class="w-full uppercase font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    <x-input-error class="mt-1" :messages="$errors->get('code')" />
                </div>

                <div>
                    <label for="phone" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Phone Number</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="e.g. 011-23456789" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="status" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Status</label>
                    <select id="status" name="status" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label for="city" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">City</label>
                    <input id="city" name="city" type="text" value="{{ old('city') }}" placeholder="e.g. New Delhi" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="state" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">State</label>
                    <input id="state" name="state" type="text" value="{{ old('state') }}" placeholder="e.g. Delhi" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="pincode" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Pincode</label>
                    <input id="pincode" name="pincode" type="text" value="{{ old('pincode') }}" placeholder="e.g. 110001" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Full Address</label>
                    <textarea id="address" name="address" rows="3" placeholder="e.g. 12 Barakhamba Road, Connaught Place" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-stroke dark:border-strokedark">
                <a href="{{ route('branches.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-700 dark:text-bodydark font-semibold text-xs uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-strokedark transition">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-semibold text-xs uppercase tracking-widest hover:bg-primary-hover shadow-md transition">Create Branch</button>
            </div>
        </form>
    </div>
</x-app-layout>
