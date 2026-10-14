<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('id-cards.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← ID Cards Directory
            </a>
            <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                Issue Student Identity Card
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            <div>
                <h3 class="text-base font-bold text-black dark:text-white">ID Card Issuance Details</h3>
                <p class="text-xs text-gray-500 dark:text-bodydark">Issue a digital and physical QR identity badge for an active student.</p>
            </div>

            <form method="POST" action="{{ route('id-cards.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Select Student *</label>
                    <select name="student_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="">-- Choose Active Student --</option>
                        @foreach($students as $st)
                            <option value="{{ $st->id }}" {{ (old('student_id') ?? $selectedStudentId) == $st->id ? 'selected' : '' }}>
                                {{ $st->full_name }} ({{ $st->student_number }}) - Mobile: {{ $st->mobile }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Issue Date *</label>
                        <input type="date" name="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                        @error('issue_date')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Expiry Date *</label>
                        <input type="date" name="expiry_date" value="{{ old('expiry_date', date('Y-m-d', strtotime('+1 year'))) }}" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                        @error('expiry_date')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Issuance Notes</label>
                    <input type="text" name="notes" value="{{ old('notes', 'Standard Identity Card Issued') }}" placeholder="e.g. Regular issue, Replacement for lost card" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2.5 px-3 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    @error('notes')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-stroke dark:border-strokedark">
                    <a href="{{ route('id-cards.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark hover:bg-gray-200 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-xs font-semibold text-white shadow hover:bg-opacity-90 transition">
                        🎴 Generate & Issue Card
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
