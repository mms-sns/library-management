<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Student ID Cards Directory
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark mt-0.5">
                    Manage student identity cards, QR tokens, and printable credentials
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('id-cards.batch-print') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-xs text-white shadow hover:bg-indigo-700 transition">
                    🖨️ Batch Print Sheet
                </a>
                <a href="{{ route('id-cards.create') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-4 py-2 font-semibold text-xs text-white shadow hover:bg-opacity-90 transition">
                    🎴 Issue New ID Card
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="rounded-2xl border border-stroke bg-white p-5 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <form method="GET" action="{{ route('id-cards.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-bodydark uppercase tracking-wider mb-1">Search Card or Student</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="IDC-000001, Student Name, LIB-000..." class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-bodydark uppercase tracking-wider mb-1">Card Status</label>
                    <select name="status" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="revoked" {{ request('status') === 'revoked' ? 'selected' : '' }}>Revoked</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-bodydark uppercase tracking-wider mb-1">Branch</label>
                    <select name="branch_id" class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-2 px-3 text-xs text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition">
                        <option value="">All Branches</option>
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full py-2 px-4 rounded-xl bg-black dark:bg-white text-white dark:text-black font-semibold text-xs hover:bg-opacity-80 transition">
                        Filter Cards
                    </button>
                    <a href="{{ route('id-cards.index') }}" class="py-2 px-3 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-600 dark:text-bodydark font-semibold text-xs hover:bg-gray-200 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- ID Cards Table Card -->
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 dark:text-bodydark1">
                    <thead class="bg-gray-50 dark:bg-boxdark-2 text-xs uppercase font-semibold text-gray-500 dark:text-bodydark border-b border-stroke dark:border-strokedark">
                        <tr>
                            <th class="py-3.5 px-4">Card #</th>
                            <th class="py-3.5 px-4">Student Info</th>
                            <th class="py-3.5 px-4">Branch</th>
                            <th class="py-3.5 px-4">QR Token</th>
                            <th class="py-3.5 px-4">Issue Date</th>
                            <th class="py-3.5 px-4">Expiry Date</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stroke dark:divide-strokedark">
                        @forelse($idCards as $card)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-boxdark-2/50 transition">
                                <td class="py-3.5 px-4">
                                    <span class="font-mono font-bold text-primary text-xs">{{ $card->card_number }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 flex-shrink-0 overflow-hidden rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                                            @if($card->student->photo)
                                                <img src="{{ Storage::url($card->student->photo) }}" class="h-full w-full object-cover" />
                                            @else
                                                {{ strtoupper(substr($card->student->first_name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('students.show', $card->student) }}" class="font-bold text-black dark:text-white hover:text-primary transition text-xs">
                                                {{ $card->student->full_name }}
                                            </a>
                                            <p class="text-[11px] font-mono text-gray-400">ID: {{ $card->student->student_number }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-xs font-medium">
                                    {{ $card->branch->name }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-mono text-[10px] bg-gray-100 dark:bg-boxdark-2 px-2 py-1 rounded text-gray-500 dark:text-bodydark" title="{{ $card->qr_token }}">
                                        {{ Str::limit($card->qr_token, 12, '...') }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs">
                                    {{ $card->issue_date->format('d M Y') }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs">
                                    {{ $card->expiry_date->format('d M Y') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @php
                                        $statusStyles = [
                                            'active' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                                            'expired' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                                            'revoked' => 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-full uppercase {{ $statusStyles[$card->status] ?? '' }}">
                                        {{ $card->status }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('id-cards.show', $card) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 dark:bg-boxdark-2 text-xs font-semibold text-gray-700 dark:text-bodydark hover:bg-primary hover:text-white transition">
                                            🎴 View Badge
                                        </a>

                                        @if($card->status === 'active')
                                            <form method="POST" action="{{ route('id-cards.revoke', $card) }}" onsubmit="return confirm('Revoke this ID card?')" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 text-rose-600 dark:bg-rose-950/40 text-xs font-semibold hover:bg-rose-600 hover:text-white transition">
                                                    Revoke
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-xs text-gray-400">
                                    No student ID cards issued yet. Click "Issue New ID Card" to generate cards.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($idCards->hasPages())
                <div class="p-4 border-t border-stroke dark:border-strokedark">
                    {{ $idCards->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
