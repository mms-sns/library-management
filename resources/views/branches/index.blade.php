<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Branch Directory
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Manage physical library locations & branch permissions</p>
            </div>
            @can('branches.create')
                <a href="{{ route('branches.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 font-semibold text-xs text-white shadow-md hover:bg-primary-hover transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add New Branch
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="space-y-6">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- TailAdmin Table Container -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            @if($branches->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-bodydark text-sm">No branches found.</p>
                </div>
            @else
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                        <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                            <tr>
                                <th class="p-4 px-6">Branch Name</th>
                                <th class="p-4">Code</th>
                                <th class="p-4">City / Address</th>
                                <th class="p-4">Phone</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stroke dark:divide-strokedark">
                            @foreach($branches as $branch)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                    <td class="p-4 px-6 font-bold text-black dark:text-white">{{ $branch->name }}</td>
                                    <td class="p-4">
                                        <span class="bg-primary/10 text-primary font-mono text-xs px-2.5 py-1 rounded-md font-bold">
                                            {{ $branch->code }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $branch->city ?? 'N/A' }}</span>
                                        <span class="block text-xs text-gray-400 dark:text-bodydark mt-0.5">{{ Str::limit($branch->address, 35) }}</span>
                                    </td>
                                    <td class="p-4 font-mono text-xs">{{ $branch->phone ?? 'N/A' }}</td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $branch->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300' }}">
                                            {{ ucfirst($branch->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 px-6 text-right space-x-3">
                                        @can('update', $branch)
                                            <a href="{{ route('branches.edit', $branch) }}" class="text-primary hover:text-primary-hover font-semibold text-xs">Edit</a>
                                        @endcan

                                        @can('delete', $branch)
                                            <form method="POST" action="{{ route('branches.destroy', $branch) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to archive this branch?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs">Archive</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-stroke dark:border-strokedark">
                    {{ $branches->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
