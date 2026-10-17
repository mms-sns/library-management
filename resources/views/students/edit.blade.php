<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                Edit Student Profile — {{ $student->full_name }} ({{ $student->student_number }})
            </h2>
            <a href="{{ route('students.show', $student) }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← Back to Profile
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-2">
        <form method="POST" action="{{ route('students.update', $student) }}" enctype="multipart/form-data" class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Personal Details -->
            <div class="border-b border-stroke dark:border-strokedark pb-3">
                <h3 class="text-base font-bold text-black dark:text-white">1. Personal Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="first_name" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">First Name *</label>
                    <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $student->first_name) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    <x-input-error class="mt-1" :messages="$errors->get('first_name')" />
                </div>

                <div>
                    <label for="last_name" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Last Name</label>
                    <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $student->last_name) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="gender" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Gender *</label>
                    <select id="gender" name="gender" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="male" {{ old('gender', $student->gender) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $student->gender) === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $student->gender) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label for="mobile" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Mobile Number *</label>
                    <input id="mobile" name="mobile" type="text" value="{{ old('mobile', $student->mobile) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                    <x-input-error class="mt-1" :messages="$errors->get('mobile')" />
                </div>

                <div>
                    <label for="email" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $student->email) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="date_of_birth" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Date of Birth</label>
                    <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="joined_at" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Joining Date *</label>
                    <input id="joined_at" name="joined_at" type="date" value="{{ old('joined_at', $student->joined_at?->format('Y-m-d')) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="status" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Account Status *</label>
                    <select id="status" name="status" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="active" {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $student->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ old('status', $student->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="blacklisted" {{ old('status', $student->status) === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                    </select>
                </div>

                <div>
                    <label for="photo" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Update Photo</label>
                    <input id="photo" name="photo" type="file" accept="image/*" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>
            </div>

            <!-- Address Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div>
                    <label for="city" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">City</label>
                    <input id="city" name="city" type="text" value="{{ old('city', $student->city) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="state" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">State</label>
                    <input id="state" name="state" type="text" value="{{ old('state', $student->state) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="pincode" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Pincode</label>
                    <input id="pincode" name="pincode" type="text" value="{{ old('pincode', $student->pincode) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div class="md:col-span-3">
                    <label for="address" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Full Address</label>
                    <textarea id="address" name="address" rows="2" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">{{ old('address', $student->address) }}</textarea>
                </div>
            </div>

            <!-- Section 2: Seat Allocation -->
            <div class="border-b border-stroke dark:border-strokedark pb-3 pt-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-black dark:text-white">2. Seat Allocation</h3>
                        <p class="text-xs text-gray-500 dark:text-bodydark">Reassign or unassign the student's dedicated desk</p>
                    </div>
                    @if($student->seat)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary dark:bg-primary/20 dark:text-white border border-primary/20">
                            Current Seat: {{ $student->seat->seat_number }}
                        </span>
                    @endif
                </div>
            </div>

            <div
                x-data="{
                    selectedSeatId: '{{ old('seat_id', $student->seat_id ?? '') }}',
                    branchFilter: '{{ $branches->count() === 1 ? $branches->first()->id : '' }}',
                    search: '',
                    seats: {{ Js::from($availableSeats->map(fn($s) => [
                        'id' => $s->id,
                        'number' => $s->seat_number,
                        'branch_id' => (string) $s->branch_id,
                        'branch_name' => $s->branch->name ?? '',
                        'floor_name' => $s->floor->name ?? 'Main Floor',
                        'room_name' => $s->room->name ?? 'General Hall',
                        'type_name' => $s->seatType->name ?? 'Standard Desk',
                        'monthly_price' => number_format($s->seatType->monthly_price ?? 0, 0),
                    ])) }},
                    get filteredSeats() {
                        return this.seats.filter(s => {
                            const matchBranch = !this.branchFilter || s.branch_id === String(this.branchFilter);
                            const matchSearch = !this.search || 
                                s.number.toLowerCase().includes(this.search.toLowerCase()) || 
                                s.room_name.toLowerCase().includes(this.search.toLowerCase()) ||
                                s.type_name.toLowerCase().includes(this.search.toLowerCase());
                            return matchBranch && matchSearch;
                        });
                    },
                    get selectedSeat() {
                        return this.seats.find(s => String(s.id) === String(this.selectedSeatId));
                    },
                    selectSeat(id) {
                        this.selectedSeatId = String(this.selectedSeatId) === String(id) ? '' : String(id);
                    },
                    clearSeat() {
                        this.selectedSeatId = '';
                    }
                }"
                class="space-y-4"
            >
                <input type="hidden" name="seat_id" :value="selectedSeatId">
                <x-input-error class="mt-1" :messages="$errors->get('seat_id')" />

                <!-- Selection Status / Active Seat Banner -->
                <div class="rounded-xl p-4 border transition-all"
                    :class="selectedSeat ? 'border-primary/40 bg-primary/5 dark:bg-primary/10 dark:border-primary/40' : 'border-stroke bg-gray-50/50 dark:border-strokedark dark:bg-boxdark-2/50'">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl flex items-center justify-center font-bold text-base transition-colors"
                                :class="selectedSeat ? 'bg-primary text-white shadow-sm' : 'bg-gray-200 dark:bg-strokedark text-gray-500'">
                                <template x-if="selectedSeat">
                                    <span>🪑</span>
                                </template>
                                <template x-if="!selectedSeat">
                                    <span>—</span>
                                </template>
                            </div>
                            <div>
                                <template x-if="selectedSeat">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-extrabold text-black dark:text-white font-mono" x-text="'Seat ' + selectedSeat.number"></span>
                                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Allocated</span>
                                            <span class="text-xs font-bold text-primary font-mono" x-text="'₹' + selectedSeat.monthly_price + '/mo'"></span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-bodydark mt-0.5" x-text="selectedSeat.branch_name + ' • ' + selectedSeat.room_name + ' (' + selectedSeat.floor_name + ') • ' + selectedSeat.type_name"></p>
                                    </div>
                                </template>
                                <template x-if="!selectedSeat">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">No Seat Allocated (Flexible / Walk-in / Self-study)</p>
                                        <p class="text-[11px] text-gray-400">Select an available seat below to assign a dedicated desk</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                x-show="selectedSeat"
                                @click="clearSeat()"
                                class="text-xs font-medium text-red-500 hover:text-red-700 hover:underline px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-900 bg-white dark:bg-boxdark shadow-xs transition cursor-pointer"
                            >
                                ✕ Clear Seat Assignment
                            </button>
                        </div>
                    </div>
                </div>

                @if($availableSeats->isEmpty())
                    <div class="rounded-xl border border-dashed border-amber-300 dark:border-amber-800 bg-amber-50/60 dark:bg-amber-950/20 p-5 text-center">
                        <p class="text-xs font-semibold text-amber-800 dark:text-amber-300">No available seats in the system.</p>
                        <p class="text-[11px] text-amber-600 dark:text-amber-400 mt-1">All other library seats are currently occupied or under maintenance.</p>
                    </div>
                @else
                    <!-- Search and Branch Filter Bar -->
                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                        @if($branches->count() > 1)
                            <div class="w-full sm:w-1/3">
                                <select
                                    x-model="branchFilter"
                                    class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark transition font-semibold"
                                >
                                    <option value="">All Branches</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="w-full sm:flex-1 relative">
                            <input
                                type="text"
                                x-model="search"
                                placeholder="Search by seat number, room or seat type..."
                                class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 pl-9 pr-4 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark transition"
                            />
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Available Seats Grid -->
                    <div class="border border-stroke dark:border-strokedark rounded-xl p-3 bg-gray-50/40 dark:bg-boxdark-2/40">
                        <div class="max-h-64 overflow-y-auto pr-1">
                            <template x-if="filteredSeats.length === 0">
                                <div class="text-center py-8 text-xs text-gray-400">
                                    No seats match your search or filter.
                                </div>
                            </template>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2.5">
                                <template x-for="seat in filteredSeats" :key="seat.id">
                                    <button
                                        type="button"
                                        @click="selectSeat(seat.id)"
                                        class="p-2.5 rounded-xl border text-left transition-all relative flex flex-col justify-between group cursor-pointer"
                                        :class="String(selectedSeatId) === String(seat.id)
                                            ? 'border-primary bg-primary/10 ring-2 ring-primary/30 shadow-sm dark:bg-primary/20'
                                            : 'border-stroke bg-white hover:border-primary/50 hover:bg-gray-50 dark:border-strokedark dark:bg-boxdark dark:hover:bg-boxdark-2'"
                                    >
                                        <!-- Top Info: Room & Price -->
                                        <div class="flex items-center justify-between text-[10px] text-gray-500 dark:text-gray-400 w-full mb-1">
                                            <span class="truncate max-w-[70%]" x-text="seat.room_name"></span>
                                            <span class="font-bold font-mono text-primary" x-text="'₹' + seat.monthly_price"></span>
                                        </div>

                                        <!-- Seat Number & Active Indicator -->
                                        <div class="flex items-center justify-between my-0.5">
                                            <span class="font-mono text-base font-extrabold text-black dark:text-white" x-text="seat.number"></span>
                                            <template x-if="String(selectedSeatId) === String(seat.id)">
                                                <span class="h-4 w-4 rounded-full bg-primary text-white flex items-center justify-center text-[10px] font-bold">✓</span>
                                            </template>
                                        </div>

                                        <!-- Floor & Type -->
                                        <div class="text-[10px] text-gray-400 truncate mt-1">
                                            <span x-text="seat.type_name"></span>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Section 3: Guardian Details -->
            <div class="border-b border-stroke dark:border-strokedark pb-3 pt-4">
                <h3 class="text-base font-bold text-black dark:text-white">3. Guardian Details</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="guardian_name" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Guardian Name</label>
                    <input id="guardian_name" name="guardian_name" type="text" value="{{ old('guardian_name', $student->guardian?->name) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="guardian_relationship" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Relationship</label>
                    <input id="guardian_relationship" name="guardian_relationship" type="text" value="{{ old('guardian_relationship', $student->guardian?->relationship) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="guardian_mobile" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Guardian Mobile</label>
                    <input id="guardian_mobile" name="guardian_mobile" type="text" value="{{ old('guardian_mobile', $student->guardian?->mobile) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="guardian_alternate_mobile" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Alternate Phone</label>
                    <input id="guardian_alternate_mobile" name="guardian_alternate_mobile" type="text" value="{{ old('guardian_alternate_mobile', $student->guardian?->alternate_mobile) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div class="md:col-span-2">
                    <label for="guardian_email" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Guardian Email</label>
                    <input id="guardian_email" name="guardian_email" type="email" value="{{ old('guardian_email', $student->guardian?->email) }}" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-stroke dark:border-strokedark">
                <a href="{{ route('students.show', $student) }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-700 dark:text-bodydark font-semibold text-xs uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-strokedark transition">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-semibold text-xs uppercase tracking-widest hover:bg-primary-hover shadow-md transition">Update Student Profile</button>
            </div>
        </form>
    </div>
</x-app-layout>
