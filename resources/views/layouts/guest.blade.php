@props(['full' => false, 'title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0a0f1d">

        <title>{{ $title ? $title . ' — ' . config('app.name', 'StudyCenter Pro') : config('app.name', 'StudyCenter Pro') . ' — Authentication' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --font-display: 'Plus Jakarta Sans', 'Manrope', -apple-system, sans-serif;
                --font-body: 'DM Sans', -apple-system, sans-serif;
            }
            body {
                font-family: var(--font-body);
                -webkit-font-smoothing: antialiased;
            }
            .font-display {
                font-family: var(--font-display);
            }
            @keyframes pulseGlow {
                0%, 100% { opacity: 0.45; transform: scale(1); }
                50% { opacity: 0.75; transform: scale(1.08); }
            }
            @keyframes radarPing {
                0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7), 0 0 8px #10b981; }
                50% { box-shadow: 0 0 0 7px rgba(16, 185, 129, 0), 0 0 14px #10b981; }
            }
            @keyframes shimmerGlow {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(200%); }
            }
            @keyframes floatA {
                0% { transform: translateY(0px) rotate(0deg); }
                100% { transform: translateY(-10px) rotate(1.2deg); }
            }
            @keyframes floatB {
                0% { transform: translateY(0px) rotate(0deg); }
                100% { transform: translateY(-8px) rotate(-1.5deg); }
            }
            @keyframes floatC {
                0% { transform: translateY(0px) rotate(0deg); }
                100% { transform: translateY(-11px) rotate(0.8deg); }
            }
            .anim-float-a { animation: floatA 6s ease-in-out infinite alternate; }
            .anim-float-b { animation: floatB 7.5s ease-in-out infinite alternate; }
            .anim-float-c { animation: floatC 8.5s ease-in-out infinite alternate; }
            .shimmer-sweep {
                position: absolute;
                inset: 0;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.22), transparent);
                transform: translateX(-100%);
            }
            .group:hover .shimmer-sweep {
                animation: shimmerGlow 1.4s infinite;
            }
        </style>
    </head>
    <body class="h-full antialiased text-slate-800 bg-[#0a0f1d] selection:bg-indigo-500 selection:text-white">
        @if ($full)
            {{ $slot }}
        @else
            <!-- Standard Centered Card for Register, Forgot Password, Reset, etc. -->
            <div class="min-h-screen relative flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
                <!-- Ambient Glowing Backdrops -->
                <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-violet-600/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,0.06)_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

                <div class="relative z-10 w-full max-w-md">
                    <!-- Brand Mark -->
                    <div class="text-center mb-8">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                            <span class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-violet-600 flex items-center justify-center shadow-xl shadow-indigo-500/25 group-hover:scale-105 transition-all text-white">
                                <svg class="w-7 h-7" viewBox="0 0 40 40" fill="none" aria-hidden="true">
                                    <rect x="3" y="3" width="34" height="34" rx="10" fill="currentColor" fill-opacity="0.2"/>
                                    <path d="M11 13.5c4-2.2 8-1.8 11 0v14c-3-1.8-7-2.2-11 0z" fill="#fff"/>
                                    <path d="M29 13.5c-4-2.2-8-1.8-11 0v14c3-1.8 7-2.2 11 0z" fill="#c8f2df"/>
                                    <path d="M20 14v13" stroke="#101d35" stroke-width="1.8"/>
                                </svg>
                            </span>
                            <span class="text-2xl font-black tracking-tight text-white font-display">
                                StudyCenter<span class="bg-gradient-to-r from-indigo-400 to-violet-400 bg-clip-text text-transparent">Pro</span>
                            </span>
                        </a>
                        <p class="text-xs text-slate-400 mt-2">The Operating System for Study Centers &amp; Libraries</p>
                    </div>

                    <!-- Glassmorphic Card Container -->
                    <div class="bg-white/95 backdrop-blur-xl border border-white/20 shadow-2xl shadow-black/40 rounded-2xl p-6 sm:p-8">
                        {{ $slot }}
                    </div>

                    <!-- Back to Home -->
                    <div class="text-center mt-6">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-white transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to website
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </body>
</html>
