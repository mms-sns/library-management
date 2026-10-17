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

            <!-- Section 2: Seat Allocation -->
            <div class="border-b border-stroke dark:border-strokedark pb-3 pt-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-black dark:text-white">2. Seat Allocation (Optional)</h3>
                        <p class="text-xs text-gray-500 dark:text-bodydark">Assign an available study desk or seat to this student upon admission</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ $availableSeats->count() }} Available
                    </span>
                </div>
            </div>

            <div
                x-data="{
                    selectedSeatId: '{{ old('seat_id', '') }}',
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
                                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Ready to Allocate</span>
                                            <span class="text-xs font-bold text-primary font-mono" x-text="'₹' + selectedSeat.monthly_price + '/mo'"></span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-bodydark mt-0.5" x-text="selectedSeat.branch_name + ' • ' + selectedSeat.room_name + ' (' + selectedSeat.floor_name + ') • ' + selectedSeat.type_name"></p>
                                    </div>
                                </template>
                                <template x-if="!selectedSeat">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">No Seat Selected (Walk-in / Flexible Desk)</p>
                                        <p class="text-[11px] text-gray-400">Click any available seat below to assign a dedicated desk</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                x-show="selectedSeat"
                                @click="clearSeat()"
                                class="text-xs font-medium text-red-500 hover:text-red-700 hover:underline px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-900 bg-white dark:bg-boxdark shadow-xs transition"
                            >
                                ✕ Clear Selection
                            </button>
                        </div>
                    </div>
                </div>

                @if($availableSeats->isEmpty())
                    <div class="rounded-xl border border-dashed border-amber-300 dark:border-amber-800 bg-amber-50/60 dark:bg-amber-950/20 p-5 text-center">
                        <p class="text-xs font-semibold text-amber-800 dark:text-amber-300">No seats are currently available for allocation.</p>
                        <p class="text-[11px] text-amber-600 dark:text-amber-400 mt-1">All library seats are currently occupied or under maintenance. You can proceed to register the student, and assign a seat later from the Seat Map.</p>
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
                                    No available seats match your filter.
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

            <!-- Section 3: Membership Plan -->
            <div class="border-b border-stroke dark:border-strokedark pb-3 pt-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-black dark:text-white">3. Membership Plan (Optional)</h3>
                        <p class="text-xs text-gray-500 dark:text-bodydark">Enroll student into a reading membership package and generate admission fee invoice</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary dark:bg-primary/20 dark:text-white border border-primary/20">
                        ✨ {{ $membershipPlans->count() }} Plans Available
                    </span>
                </div>
            </div>

            <div
                x-data="{
                    selectedPlanId: '{{ old('membership_plan_id', '') }}',
                    startDate: '{{ old('membership_start_date', date('Y-m-d')) }}',
                    discount: '{{ old('membership_discount', '0') }}',
                    paymentStatus: '{{ old('membership_payment_status', 'unpaid') }}',
                    paymentMethod: '{{ old('membership_payment_method', 'cash') }}',
                    plans: {{ Js::from($membershipPlans->map(fn($p) => [
                        'id' => $p->id,
                        'name' => $p->name,
                        'duration_days' => (int) $p->duration_days,
                        'price' => (float) $p->price,
                        'description' => $p->description,
                    ])) }},
                    get currentPlan() {
                        return this.plans.find(p => String(p.id) === String(this.selectedPlanId));
                    },
                    get basePrice() {
                        return this.currentPlan ? Number(this.currentPlan.price) : 0;
                    },
                    get finalPayable() {
                        const disc = parseFloat(this.discount) || 0;
                        return Math.max(0, this.basePrice - disc);
                    },
                    get endDatePreview() {
                        if (!this.currentPlan || !this.startDate) return '';
                        try {
                            const parts = this.startDate.split('-');
                            if (parts.length === 3) {
                                const d = new Date(parts[0], parts[1] - 1, parts[2]);
                                d.setDate(d.getDate() + this.currentPlan.duration_days - 1);
                                return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                            }
                        } catch(e) {}
                        return '';
                    },
                    selectPlan(id) {
                        this.selectedPlanId = String(this.selectedPlanId) === String(id) ? '' : String(id);
                    },
                    clearPlan() {
                        this.selectedPlanId = '';
                        this.discount = '0';
                    }
                }"
                class="space-y-4"
            >
                <input type="hidden" name="membership_plan_id" :value="selectedPlanId">
                <x-input-error class="mt-1" :messages="$errors->get('membership_plan_id')" />

                @if($membershipPlans->isEmpty())
                    <div class="rounded-xl border border-dashed border-gray-300 dark:border-strokedark bg-gray-50/60 dark:bg-boxdark-2/60 p-5 text-center">
                        <p class="text-xs font-semibold text-gray-600 dark:text-bodydark">No active membership packages currently available.</p>
                        <p class="text-[11px] text-gray-400 mt-1">You can configure packages under <a href="{{ route('membership-plans.index') }}" class="text-primary hover:underline font-semibold">Membership Plans</a>.</p>
                    </div>
                @else
                    <!-- Plans Selector Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                        <template x-for="plan in plans" :key="plan.id">
                            <button
                                type="button"
                                @click="selectPlan(plan.id)"
                                class="p-4 rounded-2xl border text-left transition-all relative flex flex-col justify-between group cursor-pointer shadow-xs"
                                :class="String(selectedPlanId) === String(plan.id)
                                    ? 'border-primary bg-primary/10 ring-2 ring-primary/40 dark:bg-primary/20 shadow-md'
                                    : 'border-stroke bg-white hover:border-primary/50 hover:bg-gray-50/50 dark:border-strokedark dark:bg-boxdark dark:hover:bg-boxdark-2'"
                            >
                                <div class="flex items-center justify-between w-full mb-2">
                                    <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full"
                                        :class="String(selectedPlanId) === String(plan.id)
                                            ? 'bg-primary text-white font-extrabold'
                                            : 'bg-gray-100 text-gray-600 dark:bg-boxdark-2 dark:text-bodydark'"
                                        x-text="plan.duration_days + ' Days'"
                                    ></span>
                                    <template x-if="String(selectedPlanId) === String(plan.id)">
                                        <span class="h-4 w-4 rounded-full bg-primary text-white flex items-center justify-center text-[10px] font-bold">✓</span>
                                    </template>
                                </div>

                                <div class="my-1">
                                    <h4 class="text-sm font-bold text-black dark:text-white" x-text="plan.name"></h4>
                                    <p class="text-[11px] text-gray-400 truncate mt-0.5" x-text="plan.description || 'Full Library Access'"></p>
                                </div>

                                <div class="pt-3 border-t border-stroke/60 dark:border-strokedark/60 mt-2 flex items-baseline justify-between">
                                    <span class="text-xs text-gray-500 font-medium">Fee:</span>
                                    <span class="text-base font-extrabold font-mono text-primary" x-text="'₹' + Number(plan.price).toLocaleString()"></span>
                                </div>
                            </button>
                        </template>
                    </div>

                    <!-- Selected Plan Configuration Drawer -->
                    <div
                        x-show="currentPlan"
                        x-transition
                        class="rounded-2xl border border-primary/30 bg-primary/5 dark:bg-primary/10 p-5 space-y-4"
                    >
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-primary/20 pb-3">
                            <div class="flex items-center gap-3">
                                <span class="h-9 w-9 rounded-xl bg-primary text-white flex items-center justify-center text-lg font-bold shadow-xs">💳</span>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-bold text-black dark:text-white" x-text="currentPlan ? currentPlan.name : ''"></h4>
                                        <span class="text-[11px] font-mono font-bold text-primary" x-text="'Base: ₹' + (currentPlan ? Number(currentPlan.price).toLocaleString() : '0')"></span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-bodydark" x-text="'Valid for ' + (currentPlan ? currentPlan.duration_days : 0) + ' days • Expiry: ' + endDatePreview"></p>
                                </div>
                            </div>

                            <button
                                type="button"
                                @click="clearPlan()"
                                class="text-xs font-semibold text-red-500 hover:text-red-700 hover:underline px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-900 bg-white dark:bg-boxdark self-start sm:self-auto cursor-pointer"
                            >
                                ✕ Remove Plan (No Membership)
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Start Date</label>
                                <input
                                    type="date"
                                    name="membership_start_date"
                                    x-model="startDate"
                                    class="w-full rounded-xl border border-stroke bg-white dark:bg-boxdark py-2.5 px-3 text-xs text-black dark:text-white font-medium outline-none focus:border-primary dark:border-strokedark transition"
                                />
                            </div>

                            <div>
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Discount (₹)</label>
                                <input
                                    type="number"
                                    name="membership_discount"
                                    x-model="discount"
                                    min="0"
                                    step="1"
                                    placeholder="0"
                                    class="w-full rounded-xl border border-stroke bg-white dark:bg-boxdark py-2.5 px-3 text-xs text-black dark:text-white font-mono font-medium outline-none focus:border-primary dark:border-strokedark transition"
                                />
                            </div>

                            <div>
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Net Payable</label>
                                <div class="w-full rounded-xl border border-primary/30 bg-white dark:bg-boxdark py-2 px-3 text-sm font-bold font-mono text-primary flex items-center justify-between">
                                    <span class="text-xs font-normal text-gray-400">Total:</span>
                                    <span x-text="'₹' + finalPayable.toLocaleString()"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Initial Payment Status -->
                        <div class="border-t border-primary/20 pt-3">
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Admission Fee Payment Status</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition text-xs font-medium"
                                    :class="paymentStatus === 'unpaid'
                                        ? 'border-amber-400 bg-amber-50/60 dark:bg-amber-950/40 text-amber-900 dark:text-amber-200 ring-2 ring-amber-300'
                                        : 'border-stroke bg-white dark:bg-boxdark text-gray-700 dark:text-bodydark'"
                                >
                                    <input type="radio" name="membership_payment_status" value="unpaid" x-model="paymentStatus" class="text-amber-500 focus:ring-amber-400" />
                                    <div>
                                        <span class="font-bold block">⏳ Generate Due Invoice (Collect Later)</span>
                                        <span class="text-[11px] text-gray-500">Invoice issued with 7 days due date. Fee can be collected later.</span>
                                    </div>
                                </label>

                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition text-xs font-medium"
                                    :class="paymentStatus === 'paid'
                                        ? 'border-emerald-400 bg-emerald-50/60 dark:bg-emerald-950/40 text-emerald-900 dark:text-emerald-200 ring-2 ring-emerald-300'
                                        : 'border-stroke bg-white dark:bg-boxdark text-gray-700 dark:text-bodydark'"
                                >
                                    <input type="radio" name="membership_payment_status" value="paid" x-model="paymentStatus" class="text-emerald-500 focus:ring-emerald-400" />
                                    <div>
                                        <span class="font-bold block">✓ Payment Received Today (Mark Paid)</span>
                                        <span class="text-[11px] text-gray-500">Records payment immediately and clears the admission invoice balance.</span>
                                    </div>
                                </label>
                            </div>

                            <!-- Payment Method (If Paid) -->
                            <div x-show="paymentStatus === 'paid'" x-transition class="mt-3 pt-3 border-t border-dashed border-primary/20">
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Payment Method</label>
                                <select
                                    name="membership_payment_method"
                                    x-model="paymentMethod"
                                    class="w-full sm:w-1/2 rounded-xl border border-stroke bg-white dark:bg-boxdark py-2 px-3 text-xs text-black dark:text-white font-semibold outline-none focus:border-primary dark:border-strokedark transition"
                                >
                                    <option value="cash">💵 Cash Payment</option>
                                    <option value="upi">📱 UPI / QR Code (PhonePe, GPay, Paytm)</option>
                                    <option value="card">💳 Debit / Credit Card</option>
                                    <option value="netbanking">🏦 Net Banking / Transfer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Section 4: Guardian Details -->
            <div class="border-b border-stroke dark:border-strokedark pb-3 pt-4">
                <h3 class="text-base font-bold text-black dark:text-white">4. Guardian Details</h3>
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
