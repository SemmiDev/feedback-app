<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dasbor') - Feedback App</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <link rel="stylesheet" href="/build/assets/app-CmtpiSwD.css">
	<script src="/build/assets/app-X2UW5owF.js" defer></script>


    <!-- Flowbite -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @yield('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="antialiased bg-gray-50">
        <!-- Top Header Bar -->
        <header class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Left side: Menu toggle + Logo -->
                    <div class="flex items-center space-x-4">
                        <!-- Mobile menu button -->
                        <button
                            data-drawer-target="logo-sidebar"
                            data-drawer-toggle="logo-sidebar"
                            aria-controls="logo-sidebar"
                            type="button"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                        >
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                            </svg>
                        </button>

                        <!-- Logo and Title -->
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md border border-emerald-200">
                                    <img src="/logo-mui.png" alt="MUI Logo" class="object-contain w-6 h-6 drop-shadow" />
                                </div>
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md border border-emerald-200">
                                    <img src="/logo-unri.png" alt="UNRI Logo" class="object-contain w-5 h-5 drop-shadow" />
                                </div>
                            </div>
                            <div class="hidden sm:block">
                <h1 class="text-lg font-semibold text-gray-900">Dasbor MUI Riau</h1>
                <p class="text-xs text-gray-500">Sistem Evaluasi Umpan Balik</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right side: Profile dropdown -->
                    <div class="flex items-center space-x-4">
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button
                                type="button"
                                class="flex items-center space-x-3 text-sm bg-white border border-gray-200 rounded-full px-3 py-2 hover:bg-gray-50 focus:ring-4 focus:ring-emerald-200 shadow-sm transition-colors"
                                id="user-menu-button"
                                aria-expanded="false"
                                data-dropdown-toggle="user-dropdown"
                                data-dropdown-placement="bottom"
                            >
                <span class="sr-only">Buka menu pengguna</span>
                                <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-600">{{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-gray-200" id="user-dropdown">
                                <div class="px-4 py-3 bg-gray-50 rounded-t-lg">
                                    <span class="block text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                                    <span class="block text-sm text-gray-600 truncate">{{ auth()->user()->username }}</span>
                                </div>
                                <ul class="py-2" aria-labelledby="user-menu-button">
                                    <li>
                                        <a href="{{ route('dashboard.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                            <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                            </svg>
                            Dasbor
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="my-2 border-gray-200">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                                <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <aside id="logo-sidebar" class="fixed top-16 left-0 z-40 w-64 h-[calc(100vh-4rem)] transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0" aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto bg-white">
                <!-- Navigation Menu -->
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="{{ route('dashboard.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.index') ? 'text-emerald-700 border-r-4 border-emerald-500' : '' }}">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ request()->routeIs('dashboard.index') ? 'text-emerald-600' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('dashboard.feedbacks.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.feedbacks.*') ? 'text-emerald-700 border-r-4 border-emerald-500' : '' }}">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ request()->routeIs('dashboard.feedbacks.*') ? 'text-emerald-600' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">All Feedbacks</span>
                            @php
                                $totalFeedbacks = \App\Models\Feedback::count();
                            @endphp
                            @if($totalFeedbacks > 0)
                                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-emerald-800 bg-emerald-100 rounded-full">{{ $totalFeedbacks }}</span>
                            @endif
                        </a>
                    </li> --}}
                </ul>

                @if(auth()->user()->isAdmin())
                <!-- Dashboard Menu Section -->
                <div class="mt-6">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Menu Dasbor</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('dashboard.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.index') ? 'text-emerald-800 border border-r-4 border-emerald-200' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('dashboard.index') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Ringkasan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.feedbacks.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.feedbacks.index') ? 'text-emerald-800 border border-r-4 border-emerald-200' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('dashboard.feedbacks.*') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Kelola Umpan Balik
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.sentiment') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.sentiment') ? 'text-emerald-800 border border-r-4 border-emerald-200' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('dashboard.sentiment.*') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Visualisasi Sentimen
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.feedbacks.export') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.feedbacks.export') ? 'text-emerald-800 border border-r-4 border-emerald-200' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('dashboard.feedbacks.export') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Ekspor Umpan Balik
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('dashboard.pengurus-masjid.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.pengurus-masjid.*') ? 'text-emerald-800 border border-r-4 border-emerald-200' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('dashboard.pengurus-masjid.*') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Akun Pengurus Masjid
                            </a>
                        </li> --}}
                    </ul>
                @elseif(auth()->user()->isPenceramah())
                <!-- Penceramah Dashboard Menu -->
                <div class="mt-6">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Menu Penceramah</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('dashboard.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.index') ? 'text-emerald-800 border border-r-4 border-emerald-200' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('dashboard.index') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Ringkasan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.feedbacks.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.feedbacks.index') ? 'text-emerald-800 border border-r-4 border-emerald-200' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('dashboard.feedbacks.*') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Umpan Balik Anda
                            </a>
                        </li>
                    </ul>
                @elseif(auth()->user()->isPengurusMasjid())
                <!-- Pengurus Masjid Dashboard Menu -->
                <div class="mt-6">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Menu Pengurus Masjid</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('dashboard.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.index') ? 'text-emerald-800 border border-r-4 border-emerald-200' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('dashboard.index') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Ringkasan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.feedbacks.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.feedbacks.index') ? 'text-emerald-800 border border-r-4 border-emerald-200' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('dashboard.feedbacks.*') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Umpan Balik Masjid
                            </a>
                        </li>
                        <li>

                        </li>
                    </ul>
                @endif
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('dashboard.settings.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard.settings.*') ? 'text-emerald-700 border border-r-4 border-emerald-500' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('dashboard.settings.*') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Pengaturan
                            </a>
                        @elseif(auth()->user()->isPenceramah())
                            <a href="{{ route('profile.show') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('profile.*') ? 'text-emerald-700 border border-r-4 border-emerald-500' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('profile.*') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profil
                            </a>
                        @else
                         <a href="{{ route('profile.show') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('profile.*') ? 'text-emerald-700 border border-r-4 border-emerald-500' : '' }}">
                                <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-500 {{ request()->routeIs('profile.*') ? 'text-emerald-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profil
                            </a>
                        @endif
                    </ul>
                </div>

                @if(auth()->user()->isAdmin())
                    <!-- Quick Actions -->
                    <div class="mt-4">
                        <a href="{{ route('feedback.create') }}" class="flex items-center w-full p-3 text-sm font-medium text-emerald-700 bg-emerald-100 rounded-lg hover:bg-emerald-200 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Formulir Publik
                        </a>
                    </div>
                @endif
            </div>
        </aside>

        <!-- Main Content -->
        <div class="p-4 sm:ml-64 mt-16">
            <div class="p-4 rounded-lg">
                @if(session('success'))
                    <div class="flex items-center p-4 mb-4 text-sm text-emerald-800 border border-emerald-300 rounded-lg bg-emerald-50 animate-slide-in" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-emerald-50 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerald-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-border-3" aria-label="Close">
                            <span class="sr-only">Tutup</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 animate-slide-in" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-border-1" aria-label="Close">
                            <span class="sr-only">Tutup</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    @stack('scripts')
</body>
</html>
