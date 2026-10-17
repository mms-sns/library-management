<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('id-cards.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                    ← ID Cards Directory
                </a>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Student Badge #{{ $idCard->card_number }}
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('students.show', $idCard->student) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-3.5 py-2 font-semibold text-xs text-gray-700 dark:text-bodydark hover:bg-gray-200 dark:hover:bg-strokedark transition print:hidden">
                    👤 Back to Student
                </a>
                <button onclick="window.print()" class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-4 py-2 font-semibold text-xs text-white shadow hover:bg-opacity-90 transition print:hidden">
                    🖨️ Print ID Card
                </button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <div class="text-center space-y-1 print:hidden">
            <h3 class="text-lg font-bold text-black dark:text-white">CR80 Pocket Identity Card Preview</h3>
            <p class="text-xs text-gray-500 dark:text-bodydark">Standard PVC / Lanyard format (Front & Back). Ready for instant printing.</p>
        </div>

        <!-- ID Card Preview Grid (CR80 Standard Specs ~ 85.6mm x 54mm) -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-8 print:block print:space-y-6">

            <!-- FRONT OF CARD -->
            <div class="w-[340px] h-[215px] rounded-2xl bg-white dark:bg-boxdark border border-stroke dark:border-strokedark shadow-xl overflow-hidden flex flex-col justify-between relative print:shadow-none print:border-black print:mx-auto">
                <!-- Top Brand Header Banner -->
                <div class="bg-primary px-4 py-2.5 text-white flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="h-6 w-6 rounded-lg bg-white/20 flex items-center justify-center font-extrabold text-xs">
                            L
                        </div>
                        <span class="font-extrabold text-xs tracking-wide truncate max-w-[180px]">{{ $idCard->library->name }}</span>
                    </div>
                    <span class="text-[9px] font-mono uppercase bg-white/20 px-1.5 py-0.5 rounded tracking-widest font-semibold">STUDENT</span>
                </div>

                <!-- Card Main Content Body -->
                <div class="p-3.5 flex gap-3.5 items-center">
                    <!-- Photo Box -->
                    <div class="h-24 w-20 flex-shrink-0 rounded-xl bg-gray-100 dark:bg-boxdark-2 border border-stroke dark:border-strokedark overflow-hidden flex items-center justify-center font-bold text-xl text-primary shadow-inner">
                        @if($idCard->student->photo)
                            <img src="{{ asset('storage/' . $idCard->student->photo) }}" class="h-full w-full object-cover" />
                        @else
                            {{ strtoupper(substr($idCard->student->first_name, 0, 1)) }}
                        @endif
                    </div>

                    <!-- Details Box -->
                    <div class="flex-1 space-y-1 overflow-hidden">
                        <h4 class="font-extrabold text-sm text-black dark:text-white truncate leading-tight">{{ $idCard->student->full_name }}</h4>
                        <p class="text-[11px] font-mono font-bold text-primary tracking-wide">ID: {{ $idCard->student->student_number }}</p>

                        <div class="text-[10px] text-gray-500 dark:text-bodydark space-y-0.5 pt-1">
                            <p class="truncate"><strong class="text-black dark:text-white">Branch:</strong> {{ $idCard->branch->name }}</p>
                            <p><strong class="text-black dark:text-white">Mobile:</strong> {{ $idCard->student->mobile }}</p>
                            <p><strong class="text-black dark:text-white">Validity:</strong> {{ $idCard->issue_date->format('m/Y') }} - {{ $idCard->expiry_date->format('m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Footer Card Strip -->
                <div class="px-4 py-1.5 bg-gray-50 dark:bg-boxdark-2 border-t border-stroke dark:border-strokedark flex justify-between items-center text-[9px]">
                    <span class="font-mono text-gray-400 font-bold">CARD #: {{ $idCard->card_number }}</span>
                    <span class="uppercase font-extrabold tracking-wider {{ $idCard->status === 'active' ? 'text-emerald-600' : 'text-rose-600' }}">
                        ● {{ $idCard->status }}
                    </span>
                </div>
            </div>

            <!-- BACK OF CARD -->
            <div class="w-[340px] h-[215px] rounded-2xl bg-white dark:bg-boxdark border border-stroke dark:border-strokedark shadow-xl overflow-hidden flex flex-col justify-between relative print:shadow-none print:border-black print:mx-auto">
                <!-- Top Header Banner -->
                <div class="bg-gray-800 dark:bg-boxdark-2 px-4 py-2 text-white flex justify-between items-center text-[10px]">
                    <span class="font-bold tracking-wider uppercase">DIGITAL ACCESS TOKEN</span>
                    <span class="font-mono text-gray-400">KIOSK QR</span>
                </div>

                <!-- Back Content Body with QR -->
                <div class="p-3 flex items-center gap-3">
                    <div class="flex-shrink-0 bg-white p-1 rounded-xl border border-stroke shadow-sm">
                        {!! $qrSvg !!}
                    </div>

                    <div class="space-y-1 text-[10px] text-gray-600 dark:text-bodydark">
                        <p class="font-semibold text-black dark:text-white leading-tight">Scan for attendance & seat check-in kiosk.</p>
                        <p class="text-[9px] text-gray-400 leading-tight">If found, please return to {{ $idCard->branch->address }}, {{ $idCard->branch->city }}.</p>
                        <p class="font-mono text-[9px] text-primary pt-1">Ph: {{ $idCard->branch->phone ?? $idCard->library->mobile }}</p>
                    </div>
                </div>

                <!-- Footer Signature Block -->
                <div class="px-4 py-2 bg-gray-50 dark:bg-boxdark-2 border-t border-stroke dark:border-strokedark flex justify-between items-end text-[9px]">
                    <div class="text-[8px] text-gray-400 leading-tight">
                        Non-Transferable Card<br/>Property of {{ $idCard->library->name }}
                    </div>
                    <div class="border-t border-stroke dark:border-strokedark px-2 pt-0.5 text-center">
                        <span class="font-bold text-black dark:text-white text-[9px]">Authorized Sign</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @if(request('print'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 350);
        });
    </script>
    @endif
</x-app-layout>
