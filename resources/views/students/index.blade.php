<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Student Directory
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Manage member admissions, profiles, and status</p>
            </div>
            @can('students.create')
                <a href="{{ route('students.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 font-semibold text-xs text-white shadow-md hover:bg-primary-hover transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    New Student Registration
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

        <!-- Filter & Search Bar -->
        <div class="rounded-2xl border border-stroke bg-white p-4 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <form method="GET" action="{{ route('students.index') }}" class="flex flex-col sm:flex-row items-center gap-4">
                <!-- Search Input -->
                <div class="relative flex-1 w-full">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name, student number (LIB-000001), mobile, or email..."
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 pl-10 pr-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    />
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Status Filter -->
                <div class="w-full sm:w-48">
                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                    >
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="blacklisted" {{ request('status') === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                    </select>
                </div>

                <!-- Submit / Clear -->
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary-hover transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('students.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-600 dark:text-bodydark text-xs font-semibold hover:bg-gray-200 dark:hover:bg-strokedark transition">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Student Table -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            @if($students->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-bodydark text-sm">No students found matching your criteria.</p>
                </div>
            @else
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                        <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                            <tr>
                                <th class="p-4 px-6">Student</th>
                                <th class="p-4">Student ID</th>
                                <th class="p-4">Mobile & Email</th>
                                <th class="p-4">Guardian</th>
                                <th class="p-4">Joined Date</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stroke dark:divide-strokedark">
                            @foreach($students as $student)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                    <td class="p-4 px-6">
                                        <div class="flex items-center gap-3">
                                            @if($student->photo)
                                                <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->full_name }}" class="h-10 w-10 rounded-full object-cover border border-stroke dark:border-strokedark">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                                    {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('students.show', $student) }}" class="font-bold text-black dark:text-white hover:text-primary transition">
                                                    {{ $student->full_name }}
                                                </a>
                                                <span class="block text-xs text-gray-400 capitalize">{{ $student->gender }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="bg-primary/10 text-primary font-mono text-xs px-2.5 py-1 rounded-md font-bold">
                                            {{ $student->student_number }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <span class="font-medium text-black dark:text-white font-mono text-xs">{{ $student->mobile }}</span>
                                        <span class="block text-xs text-gray-400 truncate max-w-[150px]">{{ $student->email ?? 'N/A' }}</span>
                                    </td>
                                    <td class="p-4">
                                        @if($student->guardian)
                                            <span class="font-medium text-black dark:text-white">{{ $student->guardian->name }}</span>
                                            <span class="block text-xs text-gray-400">({{ $student->guardian->relationship }}) — {{ $student->guardian->mobile }}</span>
                                        @else
                                            <span class="text-xs text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-xs font-mono">
                                        {{ $student->joined_at ? $student->joined_at->format('d-m-Y') : 'N/A' }}
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $statusColors = [
                                                'active' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                                                'inactive' => 'bg-gray-100 text-gray-800 dark:bg-boxdark-2 dark:text-bodydark',
                                                'suspended' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                                                'blacklisted' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$student->status] ?? '' }}">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 px-6 text-right space-x-3">
                                        <a href="{{ route('students.show', $student) }}" class="text-primary hover:text-primary-hover font-semibold text-xs">View</a>

                                        @can('update', $student)
                                            <a href="{{ route('students.edit', $student) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold text-xs">Edit</a>
                                        @endcan

                                        @can('delete', $student)
                                            <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to archive this student record?')">
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
                    {{ $students->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
