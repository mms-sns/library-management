<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Library Profile & Configuration
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">Global settings, contact information, and GST details</p>
            </div>
            @can('update', $library)
                <a href="{{ route('library.edit') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 font-semibold text-xs text-white shadow-md hover:bg-primary-hover transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Library Settings
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

        <!-- Public Landing Page Status Card -->
        <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-stroke dark:border-strokedark pb-3">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🌐</span>
                    <div>
                        <h3 class="text-base font-bold text-black dark:text-white">Public Landing Page</h3>
                        <p class="text-xs text-gray-500 dark:text-bodydark">Your center's branded public website for student admissions and inquiries</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('library.landing-page.edit') }}"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-3.5 py-2 font-semibold text-xs text-white hover:bg-primary-hover shadow-sm transition"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span>Configure Website</span>
                    </a>

                    <a
                        href="{{ route('public.library.show', $library->slug) }}"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-stroke dark:border-strokedark bg-gray-50 dark:bg-boxdark-2 px-3.5 py-2 font-semibold text-xs text-black dark:text-white hover:bg-gray-100 dark:hover:bg-strokedark transition"
                    >
                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        <span>View Page</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Publish Status</span>
                    <div class="mt-1">
                        @if($library->landingPage?->is_enabled)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Published &amp; Live
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-boxdark-2 dark:text-bodydark">
                                <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                                Disabled / Draft
                            </span>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-2">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Public Web Address (URL)</span>
                    <div class="mt-1 flex items-center gap-2">
                        <a
                            href="{{ route('public.library.show', $library->slug) }}"
                            target="_blank"
                            class="font-mono text-sm font-bold text-primary hover:underline truncate"
                        >
                            {{ route('public.library.show', $library->slug) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Information Card -->
        <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-4">
            <h3 class="text-base font-bold text-black dark:text-white border-b border-stroke dark:border-strokedark pb-3">General Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Library Name</span>
                    <p class="text-base font-bold text-black dark:text-white mt-1">{{ $library->name }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Tenant Identifier</span>
                    <p class="text-base font-mono font-bold text-primary mt-1">{{ $library->slug }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Contact Email</span>
                    <p class="text-base font-medium text-black dark:text-white mt-1">{{ $library->email }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Mobile Phone</span>
                    <p class="text-base font-medium text-black dark:text-white mt-1">{{ $library->mobile }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">City & State</span>
                    <p class="text-base font-medium text-black dark:text-white mt-1">{{ $library->city ?? 'N/A' }}, {{ $library->state ?? 'N/A' }} ({{ $library->pincode ?? '' }})</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Full Address</span>
                    <p class="text-base font-medium text-black dark:text-white mt-1">{{ $library->address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Operating & Attendance Card -->
        <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-4">
            <h3 class="text-base font-bold text-black dark:text-white border-b border-stroke dark:border-strokedark pb-3">Operating & Attendance Rules</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Timezone</span>
                    <p class="text-base font-semibold text-black dark:text-white mt-1">{{ $library->settings->timezone ?? 'Asia/Kolkata' }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Currency</span>
                    <p class="text-base font-semibold text-black dark:text-white mt-1">{{ $library->settings->currency ?? 'INR' }} (₹)</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Daily Operating Hours</span>
                    <p class="text-base font-semibold text-black dark:text-white mt-1">
                        {{ $library->settings->opening_time ?? '06:00' }} to {{ $library->settings->closing_time ?? '23:00' }}
                    </p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Grace Period</span>
                    <p class="text-base font-semibold text-black dark:text-white mt-1">{{ $library->settings->grace_period_days ?? 0 }} Days</p>
                </div>
            </div>
        </div>

        <!-- Tax & Invoicing Settings -->
        <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-4">
            <h3 class="text-base font-bold text-black dark:text-white border-b border-stroke dark:border-strokedark pb-3">Tax & Invoicing Configuration</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">GST Status</span>
                    <div class="mt-1">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ ($library->settings->gst_enabled ?? false) ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-gray-100 text-gray-800 dark:bg-boxdark-2 dark:text-bodydark' }}">
                            {{ ($library->settings->gst_enabled ?? false) ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">GSTIN Number</span>
                    <p class="text-base font-mono font-bold text-black dark:text-white mt-1">{{ $library->settings->gst_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Default Tax Rate (%)</span>
                    <p class="text-base font-bold text-black dark:text-white mt-1">{{ $library->settings->tax_rate ?? '0.00' }} %</p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
