<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: true }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance Kiosk - {{ config('app.name', 'Laravel SaaS') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-white font-sans antialiased min-h-screen flex flex-col justify-between p-6 select-none overflow-hidden" x-data="kioskApp()">

    <!-- KIOSK HEADER -->
    <header class="flex justify-between items-center border-b border-slate-800 pb-6">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 rounded-2xl bg-primary text-white flex items-center justify-center font-extrabold text-2xl shadow-lg shadow-primary/30">
                L
            </div>
            <div>
                <h1 class="text-xl font-extrabold tracking-wide">STUDY CENTER ATTENDANCE KIOSK</h1>
                <p class="text-xs text-slate-400">Scan Student ID Card or QR Token to Check-In / Check-Out</p>
            </div>
        </div>

        <!-- Branch Select & Live Clock -->
        <div class="flex items-center gap-6">
            <div class="text-right">
                <label class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block">Current Branch</label>
                <select x-model="branchId" class="bg-slate-900 border border-slate-800 rounded-xl text-xs py-1.5 px-3 text-white focus:outline-none focus:border-primary font-medium">
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-right font-mono border-l border-slate-800 pl-6">
                <div class="text-2xl font-extrabold text-primary tracking-wider" x-text="currentTime"></div>
                <div class="text-[11px] text-slate-400 font-sans" x-text="currentDate"></div>
            </div>
        </div>
    </header>

    <!-- KIOSK MAIN SCANNER SECTION -->
    <main class="max-w-2xl mx-auto w-full my-auto py-8 text-center space-y-8">

        <!-- Scanner Prompt Card -->
        <div class="bg-slate-900/80 border border-slate-800/80 rounded-3xl p-10 shadow-2xl backdrop-blur space-y-6">
            <div class="h-20 w-20 mx-auto rounded-full bg-primary/10 border border-primary/30 flex items-center justify-center text-3xl text-primary animate-pulse">
                📷
            </div>

            <div>
                <h2 class="text-2xl font-extrabold tracking-tight">Ready to Scan ID Card</h2>
                <p class="text-xs text-slate-400 mt-1">Hold your Student ID QR Code in front of the scanner or type ID number below.</p>
            </div>

            <!-- Auto-Focused Input Form -->
            <form @submit.prevent="submitScan" class="max-w-md mx-auto relative">
                <input
                    type="text"
                    x-ref="scanInput"
                    x-model="scanToken"
                    placeholder="Scan QR code or enter LIB-000..."
                    class="w-full bg-slate-950 border-2 border-slate-800 focus:border-primary rounded-2xl py-4 px-5 text-center font-mono text-lg text-white placeholder-slate-600 outline-none transition shadow-inner"
                    autocomplete="off"
                    autofocus
                    @blur="$nextTick(() => $refs.scanInput.focus())"
                />

                <button type="submit" class="mt-4 w-full py-3.5 rounded-xl bg-primary hover:bg-opacity-90 font-bold text-sm text-white shadow-lg transition">
                    Process Entry / Exit
                </button>
            </form>
        </div>

        <!-- Scan Result Modal Overlay / Alert -->
        <template x-if="result">
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4" x-transition>
                <div
                    class="w-full max-w-md rounded-3xl border p-8 shadow-2xl text-center space-y-6"
                    :class="{
                        'bg-slate-900 border-emerald-500/50': result.success && result.action === 'check_in',
                        'bg-slate-900 border-amber-500/50': result.success && result.action === 'check_out',
                        'bg-slate-900 border-rose-500/50': !result.success
                    }"
                >
                    <!-- Result Status Icon Badge -->
                    <div class="h-20 w-20 mx-auto rounded-full flex items-center justify-center text-4xl shadow-lg"
                        :class="{
                            'bg-emerald-500/20 text-emerald-400 border border-emerald-500/40': result.success && result.action === 'check_in',
                            'bg-amber-500/20 text-amber-400 border border-amber-500/40': result.success && result.action === 'check_out',
                            'bg-rose-500/20 text-rose-400 border border-rose-500/40': !result.success
                        }">
                        <span x-text="result.success ? (result.action === 'check_in' ? '🟢' : '🏁') : '❌'"></span>
                    </div>

                    <!-- Student Info Box -->
                    <template x-if="result.student">
                        <div class="space-y-2">
                            <h3 class="text-2xl font-extrabold text-white" x-text="result.student.full_name"></h3>
                            <p class="text-xs font-mono text-slate-400" x-text="'Student ID: ' + result.student.student_number"></p>
                        </div>
                    </template>

                    <!-- Feedback Message -->
                    <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 text-sm font-semibold"
                        :class="{
                            'text-emerald-400': result.success && result.action === 'check_in',
                            'text-amber-400': result.success && result.action === 'check_out',
                            'text-rose-400': !result.success
                        }"
                        x-text="result.message">
                    </div>

                    <!-- Duration details if Check-out -->
                    <template x-if="result.attendance && result.attendance.duration">
                        <div class="text-xs font-mono text-slate-400 pt-1">
                            Total Session Duration: <strong class="text-white" x-text="result.attendance.duration"></strong>
                        </div>
                    </template>

                    <div class="pt-2">
                        <button @click="clearResult()" class="px-6 py-2.5 rounded-xl bg-slate-800 text-xs font-semibold text-white hover:bg-slate-700 transition">
                            Dismiss (Auto-dismissing)
                        </button>
                    </div>
                </div>
            </div>
        </template>

    </main>

    <!-- KIOSK FOOTER -->
    <footer class="border-t border-slate-800 pt-4 flex justify-between items-center text-xs text-slate-500">
        <div>
            <span>LIB-SaaS Attendance System</span> | <span>Status: <strong class="text-emerald-400 font-mono">ONLINE</strong></span>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="hover:text-white transition">Exit Kiosk Mode ←</a>
        </div>
    </footer>

    <script>
        function kioskApp() {
            return {
                scanToken: '',
                branchId: {{ $defaultBranch?->id ?? 1 }},
                currentTime: '',
                currentDate: '',
                result: null,
                dismissTimer: null,

                init() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                    this.$nextTick(() => this.$refs.scanInput.focus());
                },

                updateClock() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    this.currentDate = now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                },

                async submitScan() {
                    if (!this.scanToken.trim()) return;

                    try {
                        const response = await fetch('{{ route('kiosk.scan') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                token: this.scanToken,
                                branch_id: this.branchId
                            })
                        });

                        const data = await response.json();
                        this.result = data;
                        this.scanToken = '';

                        if (this.dismissTimer) clearTimeout(this.dismissTimer);
                        this.dismissTimer = setTimeout(() => {
                            this.clearResult();
                        }, 4000);

                    } catch (e) {
                        this.result = {
                            success: false,
                            message: 'Network error processing scan. Please try again.'
                        };
                        this.scanToken = '';
                    }
                },

                clearResult() {
                    this.result = null;
                    if (this.dismissTimer) clearTimeout(this.dismissTimer);
                    this.$nextTick(() => this.$refs.scanInput.focus());
                }
            }
        }
    </script>
</body>
</html>
