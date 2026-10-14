<!-- TailAdmin Sidebar -->
<aside
    :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
    class="absolute left-0 top-0 z-40 flex h-screen w-72 flex-col overflow-y-hidden bg-boxdark duration-300 ease-linear lg:static lg:translate-x-0 border-r border-strokedark"
    @click.outside="sidebarToggle = false"
>
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6 border-b border-strokedark/50">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary text-white font-extrabold text-xl shadow-lg shadow-primary/30">
                L
            </div>
            <div class="flex flex-col">
                <span class="text-lg font-bold text-white tracking-wide">LIB-SaaS</span>
                <span class="text-[10px] text-bodydark font-medium tracking-wider uppercase">Study Room Manager</span>
            </div>
        </a>

        <button
            class="block lg:hidden text-bodydark hover:text-white"
            @click.stop="sidebarToggle = !sidebarToggle"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear py-4 px-4 lg:px-6">
        <!-- Sidebar Menu -->
        <nav class="mt-2 space-y-6">

            <!-- Menu Group: MAIN -->
            <div>
                <h3 class="mb-3 text-xs font-semibold text-bodydark2 uppercase tracking-wider px-3">
                    Main Menu
                </h3>

                <ul class="space-y-1.5">
                    <!-- Dashboard -->
                    <li>
                        <a
                            href="{{ route('dashboard') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-boxdark-2 text-white font-semibold shadow-inner' : '' }}"
                        >
                            <svg class="w-5 h-5 text-bodydark group-hover:text-primary transition {{ request()->routeIs('dashboard') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Dashboard
                            @if(request()->routeIs('dashboard'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-primary"></span>
                            @endif
                        </a>
                    </li>

                    <!-- Students (Phase 2) -->
                    @can('students.view')
                    <li>
                        <a
                            href="{{ route('students.index') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('students.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-bodydark group-hover:text-primary transition {{ request()->routeIs('students.*') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Students Directory
                            @if(request()->routeIs('students.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-primary"></span>
                            @endif
                        </a>
                    </li>
                    @endcan

                    <!-- ID Cards & QR Tokens (Phase 6) -->
                    @can('students.view')
                    <li>
                        <a
                            href="{{ route('id-cards.index') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('id-cards.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-bodydark group-hover:text-primary transition {{ request()->routeIs('id-cards.*') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            Student ID Cards
                            @if(request()->routeIs('id-cards.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-primary"></span>
                            @endif
                        </a>
                    </li>
                    @endcan

                    <!-- Memberships & Plans (Phase 4) -->
                    @can('memberships.view')
                    <li>
                        <a
                            href="{{ route('memberships.index') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('memberships.*') || request()->routeIs('membership-plans.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-bodydark group-hover:text-primary transition {{ request()->routeIs('memberships.*') || request()->routeIs('membership-plans.*') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            Memberships & Plans
                            @if(request()->routeIs('memberships.*') || request()->routeIs('membership-plans.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-primary"></span>
                            @endif
                        </a>
                    </li>
                    @endcan

                    <!-- Invoices & Fees (Phase 5) -->
                    @can('invoices.view')
                    <li>
                        <a
                            href="{{ route('invoices.index') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('invoices.*') || request()->routeIs('payments.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-bodydark group-hover:text-primary transition {{ request()->routeIs('invoices.*') || request()->routeIs('payments.*') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Invoices & Payments
                            @if(request()->routeIs('invoices.*') || request()->routeIs('payments.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-primary"></span>
                            @endif
                        </a>
                    </li>
                    @endcan

                    <!-- Seats & Interactive Map (Phase 3) -->
                    @can('seats.view')
                    <li>
                        <a
                            href="{{ route('seats.map') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('seats.*') || request()->routeIs('seat-types.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-bodydark group-hover:text-primary transition {{ request()->routeIs('seats.*') || request()->routeIs('seat-types.*') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Seats & Seat Map
                            @if(request()->routeIs('seats.*') || request()->routeIs('seat-types.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-primary"></span>
                            @endif
                        </a>
                    </li>
                    @endcan

                    <!-- Branches -->
                    @can('branches.view')
                    <li>
                        <a
                            href="{{ route('branches.index') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('branches.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-bodydark group-hover:text-primary transition {{ request()->routeIs('branches.*') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Branches
                            @if(request()->routeIs('branches.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-primary"></span>
                            @endif
                        </a>
                    </li>
                    @endcan

                    <!-- Library Settings -->
                    @can('library.view')
                    <li>
                        <a
                            href="{{ route('library.show') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('library.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-bodydark group-hover:text-primary transition {{ request()->routeIs('library.*') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Library Config
                            @if(request()->routeIs('library.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-primary"></span>
                            @endif
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>

            <!-- Menu Group: ATTENDANCE & KIOSK (Phase 7) -->
            <div>
                <h3 class="mb-3 text-xs font-semibold text-bodydark2 uppercase tracking-wider px-3">
                    Attendance
                </h3>

                <ul class="space-y-1.5">
                    <li>
                        <a
                            href="{{ route('attendances.index') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('attendances.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-bodydark group-hover:text-primary transition {{ request()->routeIs('attendances.*') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Attendance Logs
                            @if(request()->routeIs('attendances.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-primary"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('kiosk.index') }}"
                            target="_blank"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('kiosk.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-emerald-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            Attendance Kiosk ↗
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Menu Group: SAAS PLATFORM ADMIN (Super Admin Only) -->
            @if(Auth::user()->isSuperAdmin())
            <div class="pt-2 border-t border-strokedark/50">
                <h3 class="mb-3 text-xs font-bold text-amber-400 uppercase tracking-wider px-3 flex items-center gap-1.5">
                    <span>👑</span> SaaS Platform Admin
                </h3>

                <ul class="space-y-1.5">
                    <li>
                        <a
                            href="{{ route('admin.libraries.index') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('admin.libraries.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-amber-400 group-hover:text-white transition {{ request()->routeIs('admin.libraries.*') ? 'text-amber-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Tenant Libraries
                            @if(request()->routeIs('admin.libraries.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-amber-400"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('admin.saas-packages.index') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('admin.saas-packages.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-amber-400 group-hover:text-white transition {{ request()->routeIs('admin.saas-packages.*') ? 'text-amber-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            SaaS Packages
                            @if(request()->routeIs('admin.saas-packages.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-amber-400"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('admin.tenant-subscriptions.index') }}"
                            class="group relative flex items-center gap-3 rounded-lg py-2.5 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->routeIs('admin.tenant-subscriptions.*') ? 'bg-boxdark-2 text-white font-semibold' : '' }}"
                        >
                            <svg class="w-5 h-5 text-amber-400 group-hover:text-white transition {{ request()->routeIs('admin.tenant-subscriptions.*') ? 'text-amber-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Billing & Subscriptions
                            @if(request()->routeIs('admin.tenant-subscriptions.*'))
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-l bg-amber-400"></span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
            @endif

            <!-- Account / User Footer -->
            <div class="pt-6 border-t border-strokedark/50 mt-auto">
                <div class="flex items-center gap-3 px-3 py-2 bg-boxdark-2 rounded-xl">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex flex-col truncate">
                        <span class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</span>
                        <span class="text-[11px] text-bodydark uppercase tracking-wider font-semibold">
                            {{ Auth::user()->roles->first()?->name ?? 'User' }}
                        </span>
                    </div>
                </div>
            </div>

        </nav>
    </div>
</aside>
