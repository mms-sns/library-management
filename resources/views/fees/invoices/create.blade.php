<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                Create Fee Invoice
            </h2>
            <a href="{{ route('invoices.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                ← Back to Invoices
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-2" x-data="{
        selectedStudent: '{{ old('student_id', $selectedStudentId ?? '') }}',
        selectedMembership: '{{ old('membership_id', $selectedMembershipId ?? '') }}',
        memberships: {{ Js::from($memberships->map(fn($m) => [
            'id' => (string) $m->id,
            'student_id' => (string) $m->student_id,
            'plan_name' => $m->plan?->name ?? 'Membership',
            'price' => (float) $m->final_amount,
            'start_date' => $m->start_date ? $m->start_date->format('d M Y') : '',
            'end_date' => $m->end_date ? $m->end_date->format('d M Y') : '',
            'label' => ($m->plan?->name ?? 'Membership') . ' (' . ($m->start_date?->format('d/m') ?? '') . ' to ' . ($m->end_date?->format('d/m') ?? '') . ') — ₹' . number_format($m->final_amount, 2),
        ])) }},
        items: [
            { description: 'Monthly Library Membership Fee', quantity: 1, unit_price: 1500 }
        ],
        init() {
            if (this.selectedMembership) {
                this.applyMembershipDetails(this.selectedMembership);
            }
        },
        get filteredMemberships() {
            if (!this.selectedStudent) return this.memberships;
            return this.memberships.filter(m => m.student_id == this.selectedStudent);
        },
        onStudentChange() {
            if (this.selectedMembership) {
                const match = this.memberships.find(m => m.id == this.selectedMembership);
                if (!match || match.student_id != this.selectedStudent) {
                    this.selectedMembership = '';
                }
            }
        },
        onMembershipChange(membershipId) {
            this.selectedMembership = membershipId;
            if (membershipId) {
                this.applyMembershipDetails(membershipId);
            }
        },
        applyMembershipDetails(membershipId) {
            const m = this.memberships.find(item => item.id == membershipId);
            if (m) {
                if (!this.selectedStudent) {
                    this.selectedStudent = m.student_id;
                }
                this.items[0] = {
                    description: `${m.plan_name} (${m.start_date} to ${m.end_date})`,
                    quantity: 1,
                    unit_price: m.price
                };
            }
        },
        addItem() {
            this.items.push({ description: '', quantity: 1, unit_price: 0 });
        },
        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },
        subtotal() {
            return this.items.reduce((sum, item) => sum + (item.quantity * item.unit_price || 0), 0);
        }
    }">
        <form method="POST" action="{{ route('invoices.store') }}" class="rounded-2xl border border-stroke bg-white p-8 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-6">
            @csrf

            <!-- Section 1: Billing & Student Details -->
            <div class="border-b border-stroke dark:border-strokedark pb-3">
                <h3 class="text-base font-bold text-black dark:text-white">1. Student & Branch Info</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="student_id" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Select Student *</label>
                    <select id="student_id" name="student_id" required x-model="selectedStudent" @change="onStudentChange()" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="">-- Choose Student --</option>
                        @foreach($students as $st)
                            <option value="{{ $st->id }}" {{ old('student_id', $selectedStudentId ?? null) == $st->id ? 'selected' : '' }}>
                                {{ $st->full_name }} ({{ $st->student_number }})
                            </option>
                        @endforeach
                    </select>
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
                    <div class="flex items-center justify-between mb-2.5">
                        <label for="membership_id" class="block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            Link Membership (Optional)
                        </label>
                        <template x-if="selectedStudent">
                            <a :href="'{{ route('memberships.create') }}?student_id=' + selectedStudent" target="_blank" class="text-[11px] font-semibold text-primary hover:underline">
                                + Assign Membership
                            </a>
                        </template>
                    </div>
                    <select id="membership_id" name="membership_id" x-model="selectedMembership" @change="onMembershipChange($event.target.value)" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="">-- None (Standalone Invoice) --</option>
                        <template x-for="ms in filteredMemberships" :key="ms.id">
                            <option :value="ms.id" x-text="ms.label" :selected="selectedMembership == ms.id"></option>
                        </template>
                    </select>
                    <template x-if="selectedStudent && filteredMemberships.length === 0">
                        <p class="text-[11px] text-amber-600 dark:text-amber-400 mt-1.5 flex items-center gap-1">
                            <span>ℹ️</span> No active membership found for this student. <a :href="'{{ route('memberships.create') }}?student_id=' + selectedStudent" target="_blank" class="font-bold underline ml-1">Assign one here</a>
                        </p>
                    </template>
                </div>

                <div>
                    <label for="invoice_date" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Invoice Date *</label>
                    <input id="invoice_date" name="invoice_date" type="date" value="{{ old('invoice_date', date('Y-m-d')) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="due_date" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Due Date *</label>
                    <input id="due_date" name="due_date" type="date" value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" required class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>
            </div>

            <!-- Section 2: Dynamic Line Items -->
            <div class="border-b border-stroke dark:border-strokedark pb-3 pt-4 flex justify-between items-center">
                <div>
                    <h3 class="text-base font-bold text-black dark:text-white">2. Invoice Line Items</h3>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Fee breakdown and services</p>
                </div>
                <button type="button" @click="addItem()" class="px-3 py-1.5 rounded-lg bg-primary/10 text-primary text-xs font-bold hover:bg-primary/20 transition">
                    + Add Item Line
                </button>
            </div>

            <div class="space-y-4">
                <template x-for="(item, index) in items" :key="index">
                    <div class="grid grid-cols-12 gap-3 items-center bg-gray-50 dark:bg-boxdark-2 p-3 rounded-xl border border-stroke dark:border-strokedark">
                        <div class="col-span-6">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Item Description</label>
                            <input type="text" :name="`items[${index}][description]`" x-model="item.description" required placeholder="Description..." class="w-full rounded-lg border border-stroke bg-white dark:bg-boxdark py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary" />
                        </div>

                        <div class="col-span-2">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Qty</label>
                            <input type="number" min="1" :name="`items[${index}][quantity]`" x-model.number="item.quantity" required class="w-full font-mono rounded-lg border border-stroke bg-white dark:bg-boxdark py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary" />
                        </div>

                        <div class="col-span-3">
                            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Unit Price (₹)</label>
                            <input type="number" step="0.01" min="0" :name="`items[${index}][unit_price]`" x-model.number="item.unit_price" required class="w-full font-mono rounded-lg border border-stroke bg-white dark:bg-boxdark py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary" />
                        </div>

                        <div class="col-span-1 text-center pt-4">
                            <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700 font-bold text-sm">✕</button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Section 3: Summary & Optional Initial Payment -->
            <div class="border-b border-stroke dark:border-strokedark pb-3 pt-4">
                <h3 class="text-base font-bold text-black dark:text-white">3. Totals & Optional Payment Entry</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="discount" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Discount (INR ₹)</label>
                    <input id="discount" name="discount" type="number" step="0.01" value="0.00" min="0" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="paid_amount" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Initial Payment Received (₹)</label>
                    <input id="paid_amount" name="paid_amount" type="number" step="0.01" value="0.00" min="0" class="w-full font-mono rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label for="payment_method" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">Payment Method</label>
                    <select id="payment_method" name="payment_method" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="cash">Cash</option>
                        <option value="upi">UPI / QR Code</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="card">Credit/Debit Card</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-stroke dark:border-strokedark">
                <a href="{{ route('invoices.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-700 dark:text-bodydark font-semibold text-xs uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-strokedark transition">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-semibold text-xs uppercase tracking-widest hover:bg-primary-hover shadow-md transition">Generate Invoice</button>
            </div>
        </form>
    </div>
</x-app-layout>
