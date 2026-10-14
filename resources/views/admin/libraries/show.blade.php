<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.libraries.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                    ← SaaS Libraries Directory
                </a>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    {{ $library->name }}
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <form method="POST" action="{{ route('admin.libraries.toggle-status', $library) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold text-white shadow transition {{ $library->status === 'active' ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-600 hover:bg-emerald-700' }}">
                        {{ $library->status === 'active' ? '🔒 Suspend Tenant' : '🔓 Activate Tenant' }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Tenant Info Overview -->
            <div class="md:col-span-2 rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">TENANT DETAILS</span>
                        <h3 class="text-xl font-extrabold text-black dark:text-white mt-0.5">{{ $library->name }}</h3>
                        <p class="text-xs font-mono text-primary font-bold">Slug: {{ $library->slug }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full uppercase {{ $library->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                        {{ $library->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400">Email:</span>
                        <p class="font-mono font-semibold text-black dark:text-white">{{ $library->email }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400">Mobile:</span>
                        <p class="font-mono font-semibold text-black dark:text-white">{{ $library->mobile }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400">Location:</span>
                        <p class="font-semibold text-black dark:text-white">{{ $library->city ?? 'N/A' }}, {{ $library->state ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400">GSTIN Tax ID:</span>
                        <p class="font-mono font-semibold text-black dark:text-white">{{ $library->settings?->gst_number ?? 'Not Configured' }}</p>
                    </div>
                </div>

                <!-- Branches List -->
                <div class="border-t border-stroke dark:border-strokedark pt-4 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-black dark:text-white">Active Branches ({{ $library->branches->count() }})</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($library->branches as $b)
                            <div class="p-3 bg-gray-50 dark:bg-boxdark-2 rounded-xl border border-stroke dark:border-strokedark text-xs">
                                <span class="font-bold text-black dark:text-white">{{ $b->name }}</span>
                                <p class="text-[11px] font-mono text-primary font-bold">Code: {{ $b->code }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Users / Staff List -->
                <div class="border-t border-stroke dark:border-strokedark pt-4 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-black dark:text-white">Assigned Owners & Staff</h4>
                    <div class="divide-y divide-stroke dark:divide-strokedark">
                        @foreach($library->users as $u)
                            <div class="py-2 flex justify-between items-center text-xs">
                                <div>
                                    <span class="font-bold text-black dark:text-white">{{ $u->name }}</span>
                                    <span class="font-mono text-[11px] text-gray-400 block">{{ $u->email }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold bg-gray-100 dark:bg-boxdark-2 text-primary">
                                    {{ $u->roles->first()?->name ?? 'User' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- SaaS Subscription Card -->
            <div class="space-y-6">
                <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">SAAS SUBSCRIPTION PLAN</span>

                    @if($library->activeSubscription && $library->activeSubscription->package)
                        <div class="bg-indigo-50 dark:bg-indigo-950/40 p-4 rounded-xl border border-indigo-200 dark:border-indigo-800 space-y-2">
                            <h4 class="text-lg font-extrabold text-indigo-900 dark:text-indigo-200">{{ $library->activeSubscription->package->name }}</h4>
                            <p class="text-xs font-mono font-bold text-indigo-700 dark:text-indigo-400">₹{{ number_format($library->activeSubscription->price, 2) }} / {{ $library->activeSubscription->billing_cycle }}</p>
                            <div class="text-[11px] text-gray-500 dark:text-bodydark pt-1 space-y-0.5">
                                <p>Started: <strong class="text-black dark:text-white">{{ $library->activeSubscription->starts_at->format('d M Y') }}</strong></p>
                                <p>Expires: <strong class="text-black dark:text-white">{{ $library->activeSubscription->ends_at->format('d M Y') }}</strong></p>
                            </div>
                        </div>
                    @else
                        <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 text-xs text-amber-800 dark:text-amber-300">
                            No active SaaS package assigned. Assign a package below to activate tenant features.
                        </div>
                    @endif

                    <!-- Change / Upgrade Plan Form -->
                    <div class="border-t border-stroke dark:border-strokedark pt-4 space-y-3">
                        <h5 class="text-xs font-bold text-black dark:text-white">Assign or Upgrade SaaS Plan</h5>
                        <form method="POST" action="{{ route('admin.tenant-subscriptions.store') }}" class="space-y-3">
                            @csrf
                            <input type="hidden" name="library_id" value="{{ $library->id }}">

                            <div>
                                <label class="mb-1 block text-[10px] font-semibold uppercase tracking-wider text-gray-400">Select SaaS Package</label>
                                <select name="saas_package_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                                    @foreach($packages as $pkg)
                                        <option value="{{ $pkg->id }}" {{ $library->activeSubscription?->saas_package_id == $pkg->id ? 'selected' : '' }}>
                                            {{ $pkg->name }} - ₹{{ number_format($pkg->monthly_price, 2) }}/mo
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-[10px] font-semibold uppercase tracking-wider text-gray-400">Billing Cycle</label>
                                <select name="billing_cycle" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                                    <option value="monthly">Monthly Billing</option>
                                    <option value="yearly">Yearly Billing</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full py-2 px-4 rounded-xl bg-indigo-600 text-white font-semibold text-xs shadow hover:bg-indigo-700 transition">
                                Update Tenant Subscription
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>
</x-app-layout>
