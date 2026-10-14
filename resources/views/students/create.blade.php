<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                New Student Admission & Registration
            </h2>
            <a href="{{ route('students.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← Back to Students
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-2">
        <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data" class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            @csrf

            <!-- Section 1: Personal Details -->
            <div class="border-b border-stroke dark:border-strokedark pb-3">
                <h3 class="text-base font-bold text-black dark:text-white">1. Personal Information</h3>
                <p class="text-xs text-gray-500 dark:text-bodydark">Basic identity and contact info</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="first_name" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">First Name *</label>
                    <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required placeholder="e.g. Rahul" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    <x-input-error class="mt-1" :messages="$errors->get('first_name')" />
                </div>

                <div>
                    <label for="last_name" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Last Name</label>
                    <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" placeholder="e.g. Sharma" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="gender" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Gender *</label>
                    <select id="gender" name="gender" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label for="mobile" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Mobile Number *</label>
                    <input id="mobile" name="mobile" type="text" value="{{ old('mobile') }}" required placeholder="e.g. 9810098100" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    <x-input-error class="mt-1" :messages="$errors->get('mobile')" />
                </div>

                <div>
                    <label for="email" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="e.g. rahul@example.com" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="date_of_birth" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Date of Birth</label>
                    <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="joined_at" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Joining Date *</label>
                    <input id="joined_at" name="joined_at" type="date" value="{{ old('joined_at', date('Y-m-d')) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="status" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Account Status *</label>
                    <select id="status" name="status" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="blacklisted" {{ old('status') === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                    </select>
                </div>

                <div>
                    <label for="photo" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Student Photo</label>
                    <input id="photo" name="photo" type="file" accept="image/*" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>
            </div>

            <!-- Address Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div>
                    <label for="city" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">City</label>
                    <input id="city" name="city" type="text" value="{{ old('city') }}" placeholder="e.g. New Delhi" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="state" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">State</label>
                    <input id="state" name="state" type="text" value="{{ old('state') }}" placeholder="e.g. Delhi" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="pincode" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Pincode</label>
                    <input id="pincode" name="pincode" type="text" value="{{ old('pincode') }}" placeholder="e.g. 110001" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div class="md:col-span-3">
                    <label for="address" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Full Residential Address</label>
                    <textarea id="address" name="address" rows="2" placeholder="e.g. House No. 45, Sector 12" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">{{ old('address') }}</textarea>
                </div>
            </div>

            <!-- Section 2: Guardian Details -->
            <div class="border-b border-stroke dark:border-strokedark pb-3 pt-4">
                <h3 class="text-base font-bold text-black dark:text-white">2. Guardian Details</h3>
                <p class="text-xs text-gray-500 dark:text-bodydark">Parent or local guardian emergency contact information</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="guardian_name" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Guardian Name</label>
                    <input id="guardian_name" name="guardian_name" type="text" value="{{ old('guardian_name') }}" placeholder="e.g. Suresh Sharma" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="guardian_relationship" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Relationship</label>
                    <input id="guardian_relationship" name="guardian_relationship" type="text" value="{{ old('guardian_relationship') }}" placeholder="e.g. Father, Mother, Uncle" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="guardian_mobile" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Guardian Mobile</label>
                    <input id="guardian_mobile" name="guardian_mobile" type="text" value="{{ old('guardian_mobile') }}" placeholder="e.g. 9810012345" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="guardian_alternate_mobile" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Alternate Phone</label>
                    <input id="guardian_alternate_mobile" name="guardian_alternate_mobile" type="text" value="{{ old('guardian_alternate_mobile') }}" placeholder="e.g. 011-23456789" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div class="md:col-span-2">
                    <label for="guardian_email" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Guardian Email</label>
                    <input id="guardian_email" name="guardian_email" type="email" value="{{ old('guardian_email') }}" placeholder="e.g. suresh@example.com" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-stroke dark:border-strokedark">
                <a href="{{ route('students.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-700 dark:text-bodydark font-semibold text-xs uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-strokedark transition">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-semibold text-xs uppercase tracking-widest hover:bg-primary-hover shadow-md transition">Register Student</button>
            </div>
        </form>
    </div>
</x-app-layout>
