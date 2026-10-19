<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
        sidebarToggle: false
    }"
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
    :class="{ 'dark': darkMode }"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Library SaaS') }}</title>

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-slate-800 dark:bg-boxdark-2 dark:text-bodydark1 print:bg-white print:text-black">
        <!-- Page Wrapper -->
        <div class="flex h-screen overflow-hidden print:h-auto print:overflow-visible print:block">

            <!-- TailAdmin Sidebar -->
            @include('layouts.sidebar')

            <!-- Content Area -->
            <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden print:h-auto print:overflow-visible print:block">

                <!-- TailAdmin Header -->
                @include('layouts.header')

                <!-- Main Content Slot -->
                <main class="w-full print:w-full print:p-0">
                    @isset($header)
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8 border-b border-stroke dark:border-strokedark bg-white dark:bg-boxdark print:hidden">
                            {{ $header }}
                        </div>
                    @endisset

                    <div class="mx-auto max-w-7xl p-4 md:p-6 2xl:p-10 print:max-w-none print:p-0 print:m-0">
                        {{ $slot }}
                    </div>
                </main>

            </div>
            <!-- Content Area -->

        </div>
        <!-- Page Wrapper -->
    </body>
</html>
