<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
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

    {{-- NAV --}}
    <x-nav sticky full-width class="border-b bg-base-100/80 backdrop-blur-md">
        <x-slot:brand>
            {{-- LOGO --}}
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
            <div class="hidden lg:block">
                <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto">
            </div>
        </x-slot:brand>

        <x-slot:actions>


            {{-- USER MENU --}}
            <x-dropdown>
                <x-slot:trigger>
                    <x-button icon="o-user" class="btn-circle btn-ghost" />
                </x-slot:trigger>
                
                <div class="p-4 bg-primary text-primary-content rounded-t-box text-center">
                    <x-avatar image="{{ auth()->user()->user_details && auth()->user()->user_details['photo_url'] ? '/storage/'.auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}" class="w-12! mx-auto mb-2" />
                    <div class="font-bold font-lg">{{ auth()->user()->name }}</div>
                </div>

                <x-menu-item title="Profile" icon="o-user-circle" link="/student/profile" />
                <x-menu-item title="Reset Password" icon="o-key" link="/resetpassword_student" />
                <x-menu-separator />
                <x-menu-item title="Logout" icon="o-power" link="/logout" no-wire-navigate class="text-error" />
            </x-dropdown>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100">

            {{-- STUDENT CARD --}}
            <div class="mb-4">
                <div class="flex items-center gap-4 p-3 group">
                    <x-avatar image="{{ auth()->user()->user_details && auth()->user()->user_details['photo_url'] ? '/storage/'.auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}" class="w-12! h-12! ring ring-primary/20 ring-offset-2" />
                    <div class="flex-1 min-w-0">
                        <div class="font-bold truncate text-base-content">{{ auth()->user()->name }}</div>
                        <div class="font-semibold tracking-wider text-base-content/50 truncate">
                           @if(auth()->user()->user_details)
                                <small style="font-size: 0.75rem; color: #6c757d;">
                                    {{ auth()->user()->user_details->education_type_data?->name ?? '' }} / 
                                    {{ auth()->user()->user_details->class_data?->name ?? '' }}
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- MENU --}}
            <x-menu activate-by-route>
                <x-menu-item title="Homepage" icon="o-home" link="{{ route('home_page') ?? '/' }}" exact />
                <x-menu-item title="Dashboard" icon="o-squares-2x2" link="{{ route('student.dashboard') }}" exact />
                
                <x-menu-separator />
 
                {{-- TESTS --}}
                <x-menu-sub title="Tests & Quizzes" icon="o-clipboard-document-list">
                    <x-menu-item title="Attempted Test" icon="o-check-circle" link="{{ route('student.test-attempt') }}" />
                    <x-menu-item title="Practice Test" icon="o-pencil-square" link="{{ route('student.dashboard_tests_list') }}" />
                    <x-menu-item title="Institute Test" icon="o-building-library" link="{{ route('student.institute_tests') }}" />
                    @foreach(\App\Models\TestCat::get() as $cat)
                        <x-menu-item title="{{ $cat->cat_name }}" icon="o-tag" link="{{ route('student.dashboard_gyanology_list', ['cat' => $cat->id]) }}" />
                    @endforeach
                </x-menu-sub>
 
                <x-menu-item title="Live Classes" icon="o-video-camera" link="{{ route('student.showvideo') }}" />
                <x-menu-item title="Current Affairs" icon="o-newspaper" link="{{ route('student.showgk') }}" />
 
                {{-- MATERIAL --}}
                <x-menu-sub title="Study Material" icon="o-book-open">
                    <x-menu-item title="Notes & E-Books" icon="o-document-text" link="{{ route('student.show') }}" />
                    <x-menu-item title="Comprehensive Material" icon="o-archive-box" link="{{ route('student.showComprehensive') }}" />
                    <x-menu-item title="Short Notes & One Liners" icon="o-bolt" link="{{ route('student.showShortNotes') }}" />
                    <x-menu-item title="Premium Notes" icon="o-star" link="{{ route('student.showPremium') }}" />
                </x-menu-sub>
 
                {{-- PACKAGES --}}
                <x-menu-sub title="Packages" icon="o-credit-card">
                    <x-menu-item title="Premium Packages" icon="o-gift" link="{{ route('student.plan', ['type' => 'premium']) }}" />
                    <x-menu-item title="Free Packages" icon="o-gift" link="{{ route('student.plan', ['type' => 'free']) }}" />
                    <x-menu-item title="My Packages" icon="o-shopping-bag" link="{{ route('student.my-plan') }}" />
                </x-menu-sub>
 
                <x-menu-separator />
                
                <x-menu-item title="Feedback" icon="o-chat-bubble-left-right" link="{{ route('student.review.index') }}" />
                {{-- ACCOUNT --}}
                <x-menu-separator />
                <x-menu-item title="My Profile" icon="o-user-circle" link="{{ route('student.profile') }}" />
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
