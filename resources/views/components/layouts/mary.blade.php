<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/mary.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200/50">

    {{-- MAIN --}}
    <x-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100">

            {{-- BRAND --}}
            <div class="p-6 pt-3 ml-1 text-2xl font-bold">
                <x-icon name="o-academic-cap" class="text-primary" />
                <span class="ml-2">Student Panel</span>
            </div>

            {{-- MENU --}}
            <x-menu activate-by-route>
                <x-menu-item title="Dashboard" icon="o-home" link="/student/dashboard" />
                <x-menu-item title="Exams & Tests" icon="o-clipboard-document-list" link="/student/exams" />
                <x-menu-item title="My Performance" icon="o-chart-bar" link="/student/review" />
                <x-menu-item title="Study Material" icon="o-book-open" link="/student/material" />
                
                <x-menu-separator />

                <x-menu-item title="My Plans" icon="o-credit-card" link="/student/myplan" />
                <x-menu-item title="Profile" icon="o-user" link="/student/profile" />
                
                <x-menu-separator />
                
                <x-menu-item title="Legacy View" icon="o-arrow-path" link="/old/student/dashboard" />
                <x-menu-item title="Logout" icon="o-power" link="/logout" no-wire-navigate />
            </x-menu>
        </x-slot:sidebar>

        {{-- CONTENT --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- TOAST --}}
    <x-toast />
</body>
</html>
