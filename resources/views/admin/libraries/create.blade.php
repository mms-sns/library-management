<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.libraries.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← SaaS Libraries Directory
            </a>
            <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                Provision New Tenant Library
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            <div>
                <h3 class="text-base font-bold text-black dark:text-white">Tenant Library Provisioning Form</h3>
                <p class="text-xs text-gray-500 dark:text-bodydark">Instantly create a library tenant, main campus branch, owner account, and SaaS package subscription.</p>
            </div>

            <form method="POST" action="{{ route('admin.libraries.store') }}" class="space-y-6">
                @csrf

                <!-- Section 1: Library Info -->
                <div class="space-y-4 border-b border-stroke dark:border-strokedark pb-6">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-primary">1. Library Organization Details</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Library Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Apex Study Hub & Reading Room" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                            @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Main Branch Name *</label>
                            <input type="text" name="branch_name" value="{{ old('branch_name', 'Main Campus') }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                            @error('branch_name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Official Library Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="contact@apexlibrary.com" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                            @error('email') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Official Mobile Number *</label>
                            <input type="text" name="mobile" value="{{ old('mobile') }}" placeholder="9810098100" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                            @error('mobile') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">City</label>
                            <input type="text" name="city" value="{{ old('city') }}" placeholder="e.g. New Delhi" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">GSTIN / Tax Number (Optional)</label>
                            <input type="text" name="gst_number" value="{{ old('gst_number') }}" placeholder="e.g. 07AAAAA0000A1Z5" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                        </div>
                    </div>
                </div>

                <!-- Section 2: Owner Credentials -->
                <div class="space-y-4 border-b border-stroke dark:border-strokedark pb-6">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-600">2. Tenant Library Owner Account</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Owner Full Name *</label>
                            <input type="text" name="owner_name" value="{{ old('owner_name') }}" placeholder="e.g. Rajesh Kumar" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                            @error('owner_name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Owner Login Email *</label>
                            <input type="email" name="owner_email" value="{{ old('owner_email') }}" placeholder="owner@apexlibrary.com" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                            @error('owner_email') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Initial Password *</label>
                            <input type="password" name="owner_password" required minlength="8" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                            @error('owner_password') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Owner Mobile Number</label>
                            <input type="text" name="owner_mobile" value="{{ old('owner_mobile') }}" placeholder="9810012345" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                        </div>
                    </div>
                </div>

                <!-- Section 3: Initial SaaS Package -->
                <div class="space-y-4">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-indigo-600">3. Initial SaaS Package Subscription</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Select SaaS Plan</label>
                            <select name="saas_package_id" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                                <option value="">-- No Initial Package (Trial) --</option>
                                @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}" {{ old('saas_package_id') == $pkg->id ? 'selected' : '' }}>
                                        {{ $pkg->name }} - ₹{{ number_format($pkg->monthly_price, 2) }}/mo
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Billing Cycle</label>
                            <select name="billing_cycle" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                                <option value="monthly">Monthly Billing</option>
                                <option value="yearly">Yearly Billing (Save 20%)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-stroke dark:border-strokedark">
                    <a href="{{ route('admin.libraries.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark hover:bg-gray-200 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-xs font-semibold text-white shadow hover:bg-opacity-90 transition">
                        🚀 Provision Tenant Library
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
