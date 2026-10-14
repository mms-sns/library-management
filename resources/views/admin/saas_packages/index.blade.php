<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    SaaS Subscription Packages & Pricing Tiers
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark mt-0.5">
                    Define feature limits, pricing models, and tier capabilities for tenant libraries
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.libraries.index') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-4 py-2 font-semibold text-xs text-gray-700 dark:text-bodydark hover:bg-gray-200 transition">
                    ← Tenants Directory
                </a>
                <a href="{{ route('admin.saas-packages.create') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-4 py-2 font-semibold text-xs text-white shadow hover:bg-opacity-90 transition">
                    ➕ Create SaaS Package Tier
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Pricing Tiers Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($packages as $pkg)
                <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark flex flex-col justify-between space-y-6 relative hover:border-primary transition">
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-primary">TIER PACKAGE</span>
                                <h3 class="text-xl font-extrabold text-black dark:text-white mt-0.5">{{ $pkg->name }}</h3>
                            </div>
                            <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full uppercase {{ $pkg->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800' }}">
                                {{ $pkg->status }}
                            </span>
                        </div>

                        <!-- Price Highlight -->
                        <div class="bg-gray-50 dark:bg-boxdark-2 p-4 rounded-xl border border-stroke dark:border-strokedark flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold font-mono text-black dark:text-white">₹{{ number_format($pkg->monthly_price, 0) }}</span>
                            <span class="text-xs text-gray-500 font-medium">/ month</span>
                            <span class="text-[11px] font-mono text-gray-400 ml-auto">(₹{{ number_format($pkg->yearly_price, 0) }}/yr)</span>
                        </div>

                        <p class="text-xs text-gray-500 dark:text-bodydark">{{ $pkg->description ?? 'Standard SaaS features package.' }}</p>

                        <!-- Feature Limits List -->
                        <div class="space-y-2 border-t border-stroke dark:border-strokedark pt-4 text-xs">
                            <div class="flex justify-between text-gray-600 dark:text-bodydark">
                                <span>Max Branches:</span>
                                <strong class="font-mono text-black dark:text-white">{{ $pkg->formatted_max_branches }}</strong>
                            </div>
                            <div class="flex justify-between text-gray-600 dark:text-bodydark">
                                <span>Max Seats Capacity:</span>
                                <strong class="font-mono text-black dark:text-white">{{ $pkg->formatted_max_seats }}</strong>
                            </div>
                            <div class="flex justify-between text-gray-600 dark:text-bodydark">
                                <span>Max Active Students:</span>
                                <strong class="font-mono text-black dark:text-white">{{ $pkg->formatted_max_students }}</strong>
                            </div>
                            <div class="flex justify-between text-gray-600 dark:text-bodydark pt-1 border-t border-dashed border-stroke dark:border-strokedark">
                                <span>Subscribed Tenants:</span>
                                <strong class="font-mono text-primary font-bold">{{ $pkg->subscriptions_count }} Tenant(s)</strong>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-stroke dark:border-strokedark">
                        <a href="{{ route('admin.saas-packages.edit', $pkg) }}" class="w-full inline-flex justify-center items-center py-2 px-4 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark hover:bg-primary hover:text-white transition">
                            ✏️ Edit Package Specs
                        </a>
                    </div>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-12 text-xs text-gray-400">
                    No SaaS packages configured. Click "Create SaaS Package Tier" to add pricing tiers.
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
