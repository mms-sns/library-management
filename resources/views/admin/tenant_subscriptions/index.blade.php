<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Tenant SaaS Subscriptions Billing Ledger
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark mt-0.5">
                    Track tenant library subscriptions, renewals, and SaaS billing cycles
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.libraries.index') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-4 py-2 font-semibold text-xs text-gray-700 dark:text-bodydark hover:bg-gray-200 transition">
                    ← Tenants Directory
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

        <!-- Tenant Subscriptions Table -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                    <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                        <tr>
                            <th class="py-3.5 px-4">Tenant Library</th>
                            <th class="py-3.5 px-4">SaaS Package</th>
                            <th class="py-3.5 px-4">Billing Cycle</th>
                            <th class="py-3.5 px-4">Price</th>
                            <th class="py-3.5 px-4">Start Date</th>
                            <th class="py-3.5 px-4">Expiry Date</th>
                            <th class="py-3.5 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stroke dark:divide-strokedark">
                        @forelse($subscriptions as $sub)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                <td class="py-3.5 px-4">
                                    <a href="{{ route('admin.libraries.show', $sub->library) }}" class="font-bold text-black dark:text-white hover:text-primary transition text-xs">
                                        {{ $sub->library->name }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-4 text-xs font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ $sub->package->name }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs uppercase">
                                    {{ $sub->billing_cycle }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs font-bold text-black dark:text-white">
                                    ₹{{ number_format($sub->price, 2) }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs">
                                    {{ $sub->starts_at->format('d M Y') }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs">
                                    {{ $sub->ends_at->format('d M Y') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-full uppercase {{ $sub->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-gray-100 text-gray-700 dark:bg-boxdark-2 dark:text-bodydark' }}">
                                        {{ $sub->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-xs text-gray-400">
                                    No tenant SaaS subscriptions logged yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subscriptions->hasPages())
                <div class="p-4 border-t border-stroke dark:border-strokedark">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
