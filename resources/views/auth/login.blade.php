<x-guest-layout :full="true" title="Sign In">
    <div class="min-h-screen w-full flex flex-col lg:grid lg:grid-cols-12 bg-white relative overflow-hidden">

        <!-- ========================================== -->
        <!-- LEFT COLUMN: Pristine Sign-In Form (5 cols on lg, 5 on xl) -->
        <!-- ========================================== -->
        <div class="w-full lg:col-span-6 xl:col-span-5 flex flex-col justify-between p-6 sm:p-10 lg:p-12 xl:p-14 bg-white z-20 min-h-screen">

            <!-- Top Navigation / Status Header -->
            <div class="flex items-center justify-between gap-4">
                <a href="{{ url('/') }}" class="group inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-indigo-600 transition-colors py-1.5 px-3 rounded-lg hover:bg-slate-50 border border-transparent hover:border-slate-200">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back to home</span>
                </a>

                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-[11px] font-semibold text-emerald-700">
                    <span class="w-2 h-2 rounded-full bg-emerald-500" style="animation: radarPing 2s infinite;"></span>
                    <span>System Operational</span>
                </div>
            </div>

            <!-- Form Body Centered -->
            <div class="w-full max-w-md mx-auto my-auto py-8">

                <!-- Brand Badge -->
                <div class="mb-8">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                        <span class="w-11 h-11 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/25 group-hover:scale-105 transition-all text-white">
                            <svg class="w-6 h-6" viewBox="0 0 40 40" fill="none" aria-hidden="true">
                                <rect x="3" y="3" width="34" height="34" rx="10" fill="currentColor" fill-opacity="0.2"/>
                                <path d="M11 13.5c4-2.2 8-1.8 11 0v14c-3-1.8-7-2.2-11 0z" fill="#fff"/>
                                <path d="M29 13.5c-4-2.2-8-1.8-11 0v14c3-1.8 7-2.2 11 0z" fill="#c8f2df"/>
                                <path d="M20 14v13" stroke="#101d35" stroke-width="1.8"/>
                            </svg>
                        </span>
                        <div>
                            <span class="text-2xl font-black tracking-tight text-slate-900 font-display">
                                StudyCenter<span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Pro</span>
                            </span>
                        </div>
                    </a>

                    <div class="mt-6">
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display tracking-tight">
                            Welcome back
                        </h1>
                        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">
                            Sign in to manage student seats, QR attendance, fees, and daily center operations.
                        </p>
                    </div>
                </div>

                <!-- Session Status Notice -->
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginForm">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Email address <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   autocomplete="username"
                                   placeholder="name@studycenter.com"
                                   class="block w-full pl-11 pr-4 py-3 rounded-xl border @error('email') border-rose-300 bg-rose-50/20 text-rose-900 @else border-slate-200 bg-slate-50/50 text-slate-900 @enderror text-sm placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/15 transition-all shadow-sm">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1.5 font-medium">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Password <span class="text-rose-500">*</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors hover:underline">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="••••••••••••"
                                   class="block w-full pl-11 pr-11 py-3 rounded-xl border @error('password') border-rose-300 bg-rose-50/20 text-rose-900 @else border-slate-200 bg-slate-50/50 text-slate-900 @enderror text-sm placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/15 transition-all shadow-sm">

                            <!-- Toggle Password Visibility Button -->
                            <button type="button"
                                    id="togglePassword"
                                    aria-label="Toggle password visibility"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none cursor-pointer">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1.5 font-medium">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me Option -->
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center gap-2.5 cursor-pointer select-none group">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="w-4 h-4 rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-0 transition-colors cursor-pointer">
                            <span class="text-xs font-medium text-slate-600 group-hover:text-slate-900 transition-colors">
                                Remember me on this device
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                                id="submitBtn"
                                class="group relative w-full py-3.5 px-4 rounded-xl font-bold text-white text-sm tracking-wide bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-600 hover:from-indigo-500 hover:to-violet-500 shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 overflow-hidden cursor-pointer">
                            <span class="shimmer-sweep"></span>
                            <span class="relative z-10 flex items-center justify-center gap-2 font-display">
                                <span>Sign In to Dashboard</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </span>
                        </button>
                    </div>

                    <!-- Quick Demo Credentials (1-Click Fill) -->
                    <div class="pt-5 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-2.5">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                Quick Demo Credentials
                            </span>
                            <span class="text-[10px] text-slate-400">Click to autofill</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button"
                                    onclick="fillDemoAccount('owner@apexlibrary.com', 'password', this)"
                                    class="demo-fill-btn p-2 rounded-lg border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50 text-left transition-all group cursor-pointer">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-slate-800 group-hover:text-indigo-600">
                                    <span>👑</span> Library Owner
                                </div>
                                <div class="text-[10px] text-slate-400 truncate mt-0.5">owner@apexlibrary.com</div>
                            </button>
                            <button type="button"
                                    onclick="fillDemoAccount('admin@saas.com', 'password', this)"
                                    class="demo-fill-btn p-2 rounded-lg border border-slate-200 hover:border-violet-300 hover:bg-violet-50/50 text-left transition-all group cursor-pointer">
                                <div class="flex items-center gap-1.5 text-xs font-bold text-slate-800 group-hover:text-violet-600">
                                    <span>⚡</span> Super Admin
                                </div>
                                <div class="text-[10px] text-slate-400 truncate mt-0.5">admin@saas.com</div>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Register Footer Link -->
                @if (Route::has('register'))
                    <p class="text-center text-xs text-slate-500 mt-6">
                        Don’t have a library account yet?
                        <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors hover:underline">
                            Start free trial ↗
                        </a>
                    </p>
                @endif
            </div>

            <!-- Footer Trust Marks -->
            <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-[11px] text-slate-400">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>256-Bit SSL Encrypted</span>
                </div>
                <div>
                    <span>© {{ date('Y') }} {{ config('app.name', 'StudyCenter Pro') }}</span>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- RIGHT COLUMN: High-Tech SaaS Showcase Canvas (7 cols on xl, 6 on lg) -->
        <!-- ========================================== -->
        <div class="hidden lg:flex lg:col-span-6 xl:col-span-7 bg-[#080d1a] relative flex-col justify-between p-10 xl:p-14 overflow-hidden border-l border-slate-800/80">

            <!-- Tech Blueprint Grid & Glow Mesh -->
            <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,0.07)_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
            <div class="absolute -top-32 -right-32 w-[480px] h-[480px] bg-gradient-to-br from-indigo-600/30 via-violet-600/25 to-transparent rounded-full blur-3xl pointer-events-none" style="animation: pulseGlow 10s infinite ease-in-out;"></div>
            <div class="absolute -bottom-32 -left-32 w-[480px] h-[480px] bg-gradient-to-tr from-cyan-600/20 via-indigo-600/20 to-transparent rounded-full blur-3xl pointer-events-none" style="animation: pulseGlow 12s infinite ease-in-out reverse;"></div>

            <!-- Top Header Pill -->
            <div class="relative z-10 flex items-center justify-between">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-[11px] font-bold text-indigo-300 tracking-wide backdrop-blur-md">
                    <span>✦</span> REAL-TIME OPERATIONS SUITE
                </span>
                <span class="text-xs text-slate-400 font-medium">Multi-Branch Architecture</span>
            </div>

            <!-- Middle Visual Centerpiece: Floating Interactive Feature Cards -->
            <div class="relative z-10 my-auto py-8">
                <div class="max-w-lg mb-8">
                    <h2 class="text-3xl xl:text-4xl font-black text-white font-display tracking-tight leading-tight">
                        Manage seats, attendance &amp; dues from one live screen.
                    </h2>
                    <p class="text-sm text-slate-400 mt-3 leading-relaxed">
                        Designed around the real rhythm of study libraries. Instant QR verification, live seat matrices, and automated WhatsApp dues reminders.
                    </p>
                </div>

                <!-- Showcase Floating Cards Grid -->
                <div class="space-y-4">

                    <!-- Card 1: Live QR Check-in Activity -->
                    <div class="anim-float-a bg-white/[0.07] hover:bg-white/[0.1] backdrop-blur-xl border border-white/15 rounded-2xl p-4 xl:p-5 shadow-2xl transition-all max-w-md">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400" style="animation: radarPing 2s infinite;"></span>
                                <span class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider">Live Check-In Event</span>
                            </div>
                            <span class="text-[11px] font-mono text-slate-400">Just now · Hall A</span>
                        </div>
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-md">
                                AS
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between">
                                    <strong class="text-sm font-bold text-white truncate">Aarav Sharma</strong>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">Seat 18</span>
                                </div>
                                <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-400">
                                    <span>ID: SC-1048</span>
                                    <span>·</span>
                                    <span class="text-emerald-400">QR Validated ✓</span>
                                    <span>·</span>
                                    <span>Monthly Pass</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Interactive Real-Time Seat Glance -->
                    <div class="anim-float-b bg-white/[0.07] hover:bg-white/[0.1] backdrop-blur-xl border border-white/15 rounded-2xl p-4 xl:p-5 shadow-2xl transition-all max-w-md ml-auto">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] font-bold text-indigo-300 uppercase tracking-wider">Silent Hall · Seat Map</span>
                            <span class="text-xs font-bold text-white">87% Full (312 / 360)</span>
                        </div>
                        <!-- Mini Seat Dots Grid -->
                        <div class="grid grid-cols-8 gap-1.5 my-2">
                            @for ($i = 1; $i <= 16; $i++)
                                @php
                                    $isTaken = in_array($i, [1, 2, 4, 5, 7, 8, 9, 10, 12, 13, 14, 16]);
                                    $isSelected = ($i == 6);
                                @endphp
                                <div class="h-5 rounded-md flex items-center justify-center text-[9px] font-bold transition-all
                                    {{ $isSelected ? 'bg-indigo-500 text-white ring-2 ring-white/60 shadow-lg shadow-indigo-500/50' : ($isTaken ? 'bg-indigo-600/80 text-indigo-100' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30') }}">
                                    {{ $i }}
                                </div>
                            @endfor
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-2.5 border-t border-white/10 text-[10px] text-slate-400">
                            <span class="flex items-center gap-1.5"><i class="w-2 h-2 rounded bg-indigo-600 inline-block"></i> Occupied (312)</span>
                            <span class="flex items-center gap-1.5"><i class="w-2 h-2 rounded bg-emerald-500/40 border border-emerald-500/50 inline-block"></i> Available (48)</span>
                            <span class="text-indigo-300 font-semibold">Live sync</span>
                        </div>
                    </div>

                    <!-- Card 3: Instant UPI Fee Collection Notification -->
                    <div class="anim-float-c bg-white/[0.07] hover:bg-white/[0.1] backdrop-blur-xl border border-white/15 rounded-2xl p-4 xl:p-5 shadow-2xl transition-all max-w-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center font-bold text-sm">
                                    ₹
                                </div>
                                <div>
                                    <strong class="text-xs font-bold text-white block">Fee Received: ₹1,800</strong>
                                    <span class="text-[10px] text-slate-400">UPI Ref: 839210 · INV-2026-1048</span>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                Paid &amp; Synced
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Bottom Testimonial / Trust Seal -->
            <div class="relative z-10 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-slate-400">
                <div class="flex items-center gap-3">
                    <div class="flex text-amber-400 text-sm">
                        ★★★★★
                    </div>
                    <span class="text-slate-300 font-medium">Trusted by 120+ modern study centers across India</span>
                </div>
                <div class="text-[11px] text-indigo-400 font-semibold">
                    v2.4 LTS Enterprise
                </div>
            </div>

        </div>

    </div>

    <!-- Micro-Interactions Script (Password reveal & 1-click Demo Fill) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', () => {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeIcon.classList.toggle('hidden', isPassword);
                    eyeSlashIcon.classList.toggle('hidden', !isPassword);
                });
            }
        });

        function fillDemoAccount(email, password, btn) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            if (emailInput && passwordInput) {
                emailInput.value = email;
                passwordInput.value = password;

                // Add brief pulse animation
                emailInput.classList.add('ring-4', 'ring-indigo-500/30');
                passwordInput.classList.add('ring-4', 'ring-indigo-500/30');

                if (btn) {
                    btn.classList.add('scale-95');
                    setTimeout(() => {
                        btn.classList.remove('scale-95');
                        emailInput.classList.remove('ring-4', 'ring-indigo-500/30');
                        passwordInput.classList.remove('ring-4', 'ring-indigo-500/30');
                    }, 300);
                }
            }
        }
    </script>
</x-guest-layout>
