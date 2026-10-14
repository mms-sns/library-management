<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('students.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                    ← Students
                </a>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Student Profile — {{ $student->full_name }}
                </h2>
            </div>
            @can('update', $student)
                <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 font-semibold text-xs text-white shadow-md hover:bg-primary-hover transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Profile
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

        <!-- Profile Header Card -->
        <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark flex flex-col md:flex-row items-center md:items-start gap-6">
            @if($student->photo)
                <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->full_name }}" class="h-28 w-28 rounded-2xl object-cover border-2 border-primary/20 shadow-md">
            @else
                <div class="h-28 w-28 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-extrabold text-3xl shadow-inner">
                    {{ strtoupper(substr($student->first_name, 0, 1)) }}
                </div>
            @endif

            <div class="flex-1 text-center md:text-left space-y-2">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                    <h3 class="text-2xl font-bold text-black dark:text-white">{{ $student->full_name }}</h3>
                    <span class="bg-primary/10 text-primary font-mono text-sm px-3 py-1 rounded-lg font-bold">
                        {{ $student->student_number }}
                    </span>
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
                </div>

                <p class="text-xs text-gray-500 dark:text-bodydark">
                    Joined on <strong class="font-mono text-black dark:text-white">{{ $student->joined_at ? $student->joined_at->format('d M Y') : 'N/A' }}</strong>
                </p>

                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 pt-2 text-xs font-medium">
                    <span class="flex items-center gap-1.5 text-gray-700 dark:text-gray-300">
                        📞 <span class="font-mono font-bold">{{ $student->mobile }}</span>
                    </span>
                    @if($student->email)
                        <span class="flex items-center gap-1.5 text-gray-700 dark:text-gray-300">
                            ✉️ {{ $student->email }}
                        </span>
                    @endif
                    <span class="flex items-center gap-1.5 text-gray-700 dark:text-gray-300 capitalize">
                        👤 {{ $student->gender }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Personal Information -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-4">
                <h4 class="text-base font-bold text-black dark:text-white border-b border-stroke dark:border-strokedark pb-3">Personal & Address Details</h4>
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400 uppercase tracking-wider font-semibold">Date of Birth</span>
                        <p class="font-semibold text-black dark:text-white mt-1">{{ $student->date_of_birth ? $student->date_of_birth->format('d-m-Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 uppercase tracking-wider font-semibold">City</span>
                        <p class="font-semibold text-black dark:text-white mt-1">{{ $student->city ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 uppercase tracking-wider font-semibold">State</span>
                        <p class="font-semibold text-black dark:text-white mt-1">{{ $student->state ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 uppercase tracking-wider font-semibold">Pincode</span>
                        <p class="font-semibold text-black dark:text-white mt-1">{{ $student->pincode ?? 'N/A' }}</p>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-400 uppercase tracking-wider font-semibold">Residential Address</span>
                        <p class="font-medium text-black dark:text-white mt-1">{{ $student->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Guardian Information -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-4">
                <h4 class="text-base font-bold text-black dark:text-white border-b border-stroke dark:border-strokedark pb-3">Guardian & Emergency Contact</h4>
                @if($student->guardian)
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Guardian Name</span>
                            <p class="font-bold text-black dark:text-white mt-1">{{ $student->guardian->name }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Relationship</span>
                            <p class="font-semibold text-black dark:text-white mt-1">{{ $student->guardian->relationship }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Mobile Phone</span>
                            <p class="font-mono font-bold text-primary mt-1">{{ $student->guardian->mobile }}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Alternate Phone</span>
                            <p class="font-mono font-semibold text-black dark:text-white mt-1">{{ $student->guardian->alternate_mobile ?? 'N/A' }}</p>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-400 uppercase tracking-wider font-semibold">Guardian Email</span>
                            <p class="font-medium text-black dark:text-white mt-1">{{ $student->guardian->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-gray-400 py-6 text-center">No guardian details recorded.</p>
                @endif
            </div>

        </div>

    </div>
</x-app-layout>
