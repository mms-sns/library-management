<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                Assign New Student Membership
            </h2>
            <a href="{{ route('memberships.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← Back to Memberships
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-2">
        <form method="POST" action="{{ route('memberships.store') }}" class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            @csrf

            <div class="border-b border-stroke dark:border-strokedark pb-3">
                <h3 class="text-base font-bold text-black dark:text-white">Membership Details</h3>
                <p class="text-xs text-gray-500 dark:text-bodydark">Select student, plan, and pricing info</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="student_id" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Select Student *</label>
                    <select id="student_id" name="student_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="">-- Choose Student --</option>
                        @foreach($students as $st)
                            <option value="{{ $st->id }}" {{ (old('student_id', $preselectedStudentId) == $st->id) ? 'selected' : '' }}>
                                {{ $st->full_name }} ({{ $st->student_number }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-1" :messages="$errors->get('student_id')" />
                </div>

                <div>
                    <label for="branch_id" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Branch *</label>
                    <select id="branch_id" name="branch_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="membership_plan_id" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Membership Plan *</label>
                    <select id="membership_plan_id" name="membership_plan_id" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="">-- Choose Plan --</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('membership_plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} ({{ $plan->duration_days }} Days) — ₹{{ number_format($plan->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="start_date" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Start Date *</label>
                    <input id="start_date" name="start_date" type="date" value="{{ old('start_date', date('Y-m-d')) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="price" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Package Base Price (INR ₹) *</label>
                    <input id="price" name="price" type="number" step="0.01" value="{{ old('price', 1500.00) }}" required class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="discount" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Discount (INR ₹)</label>
                    <input id="discount" name="discount" type="number" step="0.01" value="{{ old('discount', 0.00) }}" min="0" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="status" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Initial Status *</label>
                    <select id="status" name="status" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending Payment</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="notes" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Notes / Special Instructions</label>
                    <textarea id="notes" name="notes" rows="2" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-stroke dark:border-strokedark">
                <a href="{{ route('memberships.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-700 dark:text-bodydark font-semibold text-xs uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-strokedark transition">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-semibold text-xs uppercase tracking-widest hover:bg-primary-hover shadow-md transition">Assign Membership</button>
            </div>
        </form>
    </div>
</x-app-layout>
