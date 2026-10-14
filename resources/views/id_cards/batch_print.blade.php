<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('id-cards.index') }}" class="text-xs font-semibold text-gray-500 hover:text-black dark:hover:text-white">
                    ← ID Cards Directory
                </a>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight">
                    Batch Print ID Cards Sheet
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-5 py-2 font-semibold text-xs text-white shadow hover:bg-opacity-90 transition">
                    🖨️ Print Batch Sheet
                </button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <div class="bg-indigo-50 dark:bg-indigo-950/40 border-l-4 border-indigo-500 p-4 rounded-xl shadow-sm print:hidden">
            <p class="text-xs text-indigo-800 dark:text-indigo-300 font-semibold">
                🎴 Batch Print Mode: Rendering {{ $idCards->count() }} active student identity cards optimized for standard PVC / Card sheet printers.
            </p>
        </div>

        <!-- Printable Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 print:grid-cols-2 print:gap-6">
            @foreach($idCards as $idCard)
                <div class="w-[340px] h-[215px] mx-auto rounded-2xl bg-white border border-stroke shadow-md overflow-hidden flex flex-col justify-between relative print:shadow-none print:border-black print:break-inside-avoid">
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
                        <div class="h-24 w-20 flex-shrink-0 rounded-xl bg-gray-100 border border-stroke overflow-hidden flex items-center justify-center font-bold text-xl text-primary shadow-inner">
                            @if($idCard->student->photo)
                                <img src="{{ Storage::url($idCard->student->photo) }}" class="h-full w-full object-cover" />
                            @else
                                {{ strtoupper(substr($idCard->student->first_name, 0, 1)) }}
                            @endif
                        </div>

                        <!-- Details Box -->
                        <div class="flex-1 space-y-1 overflow-hidden">
                            <h4 class="font-extrabold text-sm text-black truncate leading-tight">{{ $idCard->student->full_name }}</h4>
                            <p class="text-[11px] font-mono font-bold text-primary tracking-wide">ID: {{ $idCard->student->student_number }}</p>

                            <div class="text-[10px] text-gray-600 space-y-0.5 pt-1">
                                <p class="truncate"><strong>Branch:</strong> {{ $idCard->branch->name }}</p>
                                <p><strong>Mobile:</strong> {{ $idCard->student->mobile }}</p>
                                <p><strong>Validity:</strong> {{ $idCard->issue_date->format('m/Y') }} - {{ $idCard->expiry_date->format('m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Card Strip -->
                    <div class="px-4 py-1.5 bg-gray-50 border-t border-stroke flex justify-between items-center text-[9px]">
                        <span class="font-mono text-gray-500 font-bold">CARD #: {{ $idCard->card_number }}</span>
                        <span class="uppercase font-extrabold tracking-wider text-emerald-600">
                            ● ACTIVE
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
