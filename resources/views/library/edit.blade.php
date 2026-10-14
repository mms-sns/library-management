<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                Edit Library Settings & Configuration
            </h2>
            <a href="{{ route('library.show') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← Back to Profile
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-2">
        <form method="POST" action="{{ route('library.update') }}" class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            @csrf
            @method('PUT')

            @if(Auth::user()->isSuperAdmin())
                <input type="hidden" name="library_id" value="{{ $library->id }}">
            @endif

            <div class="border-b border-stroke dark:border-strokedark pb-3">
                <h3 class="text-base font-bold text-black dark:text-white">General Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Library Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $library->name) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    <x-input-error class="mt-1" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label for="email" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Contact Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $library->email) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    <x-input-error class="mt-1" :messages="$errors->get('email')" />
                </div>

                <div>
                    <label for="mobile" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Mobile Phone</label>
                    <input id="mobile" name="mobile" type="text" value="{{ old('mobile', $library->mobile) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    <x-input-error class="mt-1" :messages="$errors->get('mobile')" />
                </div>

                <div>
                    <label for="city" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">City</label>
                    <input id="city" name="city" type="text" value="{{ old('city', $library->city) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="state" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">State</label>
                    <input id="state" name="state" type="text" value="{{ old('state', $library->state) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="pincode" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Pincode</label>
                    <input id="pincode" name="pincode" type="text" value="{{ old('pincode', $library->pincode) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Full Address</label>
                    <textarea id="address" name="address" rows="3" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">{{ old('address', $library->address) }}</textarea>
                </div>
            </div>

            <div class="border-b border-stroke dark:border-strokedark pb-3 pt-4">
                <h3 class="text-base font-bold text-black dark:text-white">Operating & Attendance Rules</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="opening_time" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Opening Time</label>
                    <input id="opening_time" name="opening_time" type="time" value="{{ old('opening_time', $settings->opening_time ?? '06:00') }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="closing_time" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Closing Time</label>
                    <input id="closing_time" name="closing_time" type="time" value="{{ old('closing_time', $settings->closing_time ?? '23:00') }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="grace_period_days" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Grace Period (Days)</label>
                    <input id="grace_period_days" name="grace_period_days" type="number" min="0" max="30" value="{{ old('grace_period_days', $settings->grace_period_days ?? 0) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>
            </div>

            <div class="border-b border-stroke dark:border-strokedark pb-3 pt-4">
                <h3 class="text-base font-bold text-black dark:text-white">GST & Taxation Settings</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <div class="flex items-center gap-3 pt-6">
                    <input id="gst_enabled" name="gst_enabled" type="checkbox" value="1" {{ old('gst_enabled', $settings->gst_enabled ?? false) ? 'checked' : '' }} class="h-5 w-5 rounded border-stroke text-primary focus:ring-primary dark:border-strokedark dark:bg-boxdark-2" />
                    <label for="gst_enabled" class="text-sm font-semibold text-black dark:text-white">Enable GST Invoicing</label>
                </div>

                <div>
                    <label for="gst_number" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">GSTIN Number</label>
                    <input id="gst_number" name="gst_number" type="text" value="{{ old('gst_number', $settings->gst_number) }}" placeholder="e.g. 07AAAAA0000A1Z5" class="w-full uppercase font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="tax_rate" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Tax Rate (%)</label>
                    <input id="tax_rate" name="tax_rate" type="number" step="0.01" value="{{ old('tax_rate', $settings->tax_rate ?? 0.00) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-stroke dark:border-strokedark">
                <a href="{{ route('library.show') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-700 dark:text-bodydark font-semibold text-xs uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-strokedark transition">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-semibold text-xs uppercase tracking-widest hover:bg-primary-hover shadow-md transition">Save Changes</button>
            </div>
        </form>
    </div>
</x-app-layout>
