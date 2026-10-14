<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <div>
                <h2 class="font-bold text-xl text-gray-900 dark:text-white tracking-tight">
                    Dashboard Overview
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Physical Reading Library & Branch Analytics for {{ $library->name }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Tenant Active
                </span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Flash Status Message -->
        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Metric Cards Grid (TailAdmin Card Aesthetic) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Branches Metric Card -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-black dark:text-white text-3xl">
                            {{ $stats['total_branches'] }}
                        </h4>
                        <span class="text-sm font-medium text-gray-500 dark:text-bodydark">Total Branches</span>
                    </div>
                    <span class="flex items-center gap-1 text-xs font-bold text-emerald-500 bg-emerald-50 dark:bg-emerald-950/50 px-2 py-1 rounded-md">
                        {{ $stats['active_branches'] }} Operational
                    </span>
                </div>
            </div>

            <!-- Staff Metric Card -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-title-md font-bold text-black dark:text-white text-3xl">
                            {{ $stats['total_staff'] }}
                        </h4>
                        <span class="text-sm font-medium text-gray-500 dark:text-bodydark">System Users & Staff</span>
                    </div>
                    <span class="text-xs font-medium text-gray-400">Multi-Role RBAC</span>
                </div>
            </div>

            <!-- Operating Hours Card -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-amber-50 dark:bg-amber-950/50 text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <h4 class="text-xl font-extrabold text-black dark:text-white">
                            {{ $library->settings->opening_time ?? '06:00' }} - {{ $library->settings->closing_time ?? '23:00' }}
                        </h4>
                        <span class="text-sm font-medium text-gray-500 dark:text-bodydark">Operating Hours</span>
                    </div>
                    <span class="text-xs font-mono font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 px-2 py-1 rounded">
                        {{ $library->settings->timezone ?? 'Asia/Kolkata' }}
                    </span>
                </div>
            </div>

        </div>

        <!-- Branches Table / Grid Section -->
        <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 border-b border-stroke dark:border-strokedark pb-4">
                <div>
                    <h3 class="text-lg font-bold text-black dark:text-white">Physical Locations & Branches</h3>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Configured branches for {{ $library->name }}</p>
                </div>
                @can('branches.create')
                    <a href="{{ route('branches.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 font-semibold text-xs text-white shadow-md hover:bg-primary-hover transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Branch
                    </a>
                @endcan
            </div>

            @if($branches->isEmpty())
                <div class="text-center py-12 bg-gray-50 dark:bg-boxdark-2 rounded-2xl border border-dashed border-stroke dark:border-strokedark">
                    <p class="text-gray-500 dark:text-bodydark text-sm">No branches created yet.</p>
                    @can('branches.create')
                        <a href="{{ route('branches.create') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-primary text-xs font-semibold text-white rounded-xl">
                            Create First Branch
                        </a>
                    @endcan
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($branches as $branch)
                        <div class="p-5 border border-stroke dark:border-strokedark rounded-2xl bg-gray-50/50 dark:bg-boxdark-2 hover:border-primary transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-black dark:text-white text-base">{{ $branch->name }}</h4>
                                        <span class="text-[11px] bg-primary/10 text-primary font-mono px-2 py-0.5 rounded-md font-bold">{{ $branch->code }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-bodydark mt-1.5">{{ $branch->address }}, {{ $branch->city }}</p>
                                    <p class="text-xs text-gray-400 mt-1">📞 {{ $branch->phone ?? 'N/A' }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $branch->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300' }}">
                                    {{ ucfirst($branch->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
