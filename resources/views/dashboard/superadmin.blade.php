<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Super Admin Platform Dashboard
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Global SaaS platform metrics & active library tenants</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                ⚡ System Super Admin
            </span>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 text-primary font-bold">
                    🏛️
                </div>
                <div class="mt-4">
                    <h4 class="text-3xl font-extrabold text-black dark:text-white">{{ $stats['total_libraries'] }}</h4>
                    <span class="text-xs font-medium text-gray-500 dark:text-bodydark">Total Library Tenants</span>
                    <span class="block text-xs text-emerald-500 font-semibold mt-0.5">{{ $stats['active_libraries'] }} Active</span>
                </div>
            </div>

            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 font-bold">
                    🏢
                </div>
                <div class="mt-4">
                    <h4 class="text-3xl font-extrabold text-black dark:text-white">{{ $stats['total_branches'] }}</h4>
                    <span class="text-xs font-medium text-gray-500 dark:text-bodydark">Total Branches</span>
                </div>
            </div>

            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 font-bold">
                    👤
                </div>
                <div class="mt-4">
                    <h4 class="text-3xl font-extrabold text-black dark:text-white">{{ $stats['total_users'] }}</h4>
                    <span class="text-xs font-medium text-gray-500 dark:text-bodydark">Platform System Users</span>
                </div>
            </div>

            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 font-bold">
                    ✅
                </div>
                <div class="mt-4">
                    <h4 class="text-3xl font-extrabold text-emerald-500">100%</h4>
                    <span class="text-xs font-medium text-gray-500 dark:text-bodydark">System Health & Isolation</span>
                </div>
            </div>
        </div>

        <!-- Registered Libraries Table -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden p-6 space-y-4">
            <h3 class="text-base font-bold text-black dark:text-white">Registered SaaS Libraries</h3>
            <div class="max-w-full overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                    <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                        <tr>
                            <th class="p-4">Library Name</th>
                            <th class="p-4">Slug ID</th>
                            <th class="p-4">Branches</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stroke dark:divide-strokedark">
                        @foreach($libraries as $lib)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                <td class="p-4 font-bold text-black dark:text-white">{{ $lib->name }}</td>
                                <td class="p-4 font-mono text-xs text-primary font-semibold">{{ $lib->slug }}</td>
                                <td class="p-4 font-semibold">{{ $lib->branches_count }}</td>
                                <td class="p-4">{{ $lib->email }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 uppercase">
                                        {{ $lib->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
