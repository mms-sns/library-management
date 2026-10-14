<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    SaaS Tenant Libraries Directory
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark mt-0.5">
                    Central Super Admin management for all provisioned library tenants
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.saas-packages.index') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-xs text-white shadow hover:bg-indigo-700 transition">
                    📦 Manage SaaS Packages
                </a>
                <a href="{{ route('admin.libraries.create') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-4 py-2 font-semibold text-xs text-white shadow hover:bg-opacity-90 transition">
                    🏛️ Provision New Tenant Library
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

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="rounded-2xl border border-stroke bg-white p-5 shadow-sm dark:border-strokedark dark:bg-boxdark flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">Total Libraries</span>
                    <h3 class="text-3xl font-extrabold text-black dark:text-white mt-1">{{ $stats['total_libraries'] }}</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Registered SaaS tenants</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold text-xl">
                    🏛️
                </div>
            </div>

            <div class="rounded-2xl border border-stroke bg-white p-5 shadow-sm dark:border-strokedark dark:bg-boxdark flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Active Tenants</span>
                    <h3 class="text-3xl font-extrabold text-black dark:text-white mt-1">{{ $stats['active_libraries'] }}</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Live operational centers</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 flex items-center justify-center font-bold text-xl">
                    🟢
                </div>
            </div>

            <div class="rounded-2xl border border-stroke bg-white p-5 shadow-sm dark:border-strokedark dark:bg-boxdark flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-500">Suspended</span>
                    <h3 class="text-3xl font-extrabold text-black dark:text-white mt-1">{{ $stats['suspended_libraries'] }}</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Inactive or locked tenants</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-rose-50 dark:bg-rose-950/50 text-rose-500 flex items-center justify-center font-bold text-xl">
                    ⚠️
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="rounded-2xl border border-stroke bg-white p-5 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <form method="GET" action="{{ route('admin.libraries.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-bodydark uppercase tracking-wider mb-1">Search Tenant</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Library Name, Email, City..." class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-bodydark uppercase tracking-wider mb-1">Status</label>
                    <select name="status" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full py-2 px-4 rounded-xl bg-black dark:bg-white text-white dark:text-black font-semibold text-xs hover:bg-opacity-80 transition">
                        Filter Tenants
                    </button>
                    <a href="{{ route('admin.libraries.index') }}" class="py-2 px-3 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-600 dark:text-bodydark font-semibold text-xs hover:bg-gray-200 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Tenant Libraries Table -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                    <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                        <tr>
                            <th class="py-3.5 px-4">Library Name</th>
                            <th class="py-3.5 px-4">City / Location</th>
                            <th class="py-3.5 px-4">Branches</th>
                            <th class="py-3.5 px-4">SaaS Package</th>
                            <th class="py-3.5 px-4">Owner Contact</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stroke dark:divide-strokedark">
                        @forelse($libraries as $lib)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                <td class="py-3.5 px-4">
                                    <a href="{{ route('admin.libraries.show', $lib) }}" class="font-extrabold text-black dark:text-white hover:text-primary transition text-xs">
                                        {{ $lib->name }}
                                    </a>
                                    <p class="text-[11px] font-mono text-gray-400">Slug: {{ $lib->slug }}</p>
                                </td>
                                <td class="py-3.5 px-4 text-xs font-medium">
                                    {{ $lib->city ?? 'N/A' }}, {{ $lib->state ?? 'N/A' }}
                                </td>
                                <td class="py-3.5 px-4 text-xs font-mono font-bold">
                                    <span class="px-2 py-0.5 rounded bg-gray-100 dark:bg-boxdark-2 text-primary">
                                        {{ $lib->branches->count() }} Branch(es)
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($lib->activeSubscription && $lib->activeSubscription->package)
                                        <span class="px-2.5 py-0.5 text-[11px] font-bold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300 uppercase">
                                            {{ $lib->activeSubscription->package->name }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">No Active Plan</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-xs">
                                    <p class="font-bold text-black dark:text-white">{{ $lib->users->first()?->name ?? 'N/A' }}</p>
                                    <p class="font-mono text-[11px] text-gray-400">{{ $lib->email }}</p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-full uppercase {{ $lib->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                                        {{ $lib->status }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.libraries.show', $lib) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark hover:bg-primary hover:text-white transition">
                                            🔍 Manage Tenant
                                        </a>

                                        <form method="POST" action="{{ route('admin.libraries.toggle-status', $lib) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-semibold transition {{ $lib->status === 'active' ? 'bg-rose-50 text-rose-600 dark:bg-rose-950/40 hover:bg-rose-600 hover:text-white' : 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 hover:bg-emerald-600 hover:text-white' }}">
                                                {{ $lib->status === 'active' ? 'Suspend' : 'Activate' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-xs text-gray-400">
                                    No tenant libraries provisioned yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($libraries->hasPages())
                <div class="p-4 border-t border-stroke dark:border-strokedark">
                    {{ $libraries->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
