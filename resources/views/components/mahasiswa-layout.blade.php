<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SIPKL' }} - Mahasiswa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Menambahkan transisi yang mulus untuk margin */
        .transition-margin {
            transition: margin-left 0.3s ease-in-out;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
    {{-- Komponen Alpine.js untuk state management sidebar --}}
    <div x-data="{ sidebarOpen: false, sidebarMinimized: false }" @keydown.escape.window="sidebarOpen = false"
        class="h-screen flex overflow-hidden bg-gray-50">

        {{-- Memanggil komponen navigasi/sidebar. Variabel notifikasi diteruskan ke sini jika diperlukan di sidebar.
        --}}
        @include('layouts.navigation-mahasiswa', ['notifications' => $notifications, 'unreadCount' =>
        $unreadNotificationsCount])

        {{-- Konten Utama --}}
        <div class="flex-1 flex flex-col overflow-hidden transition-margin"
            :class="{'lg:ml-64': !sidebarMinimized, 'lg:ml-20': sidebarMinimized}">

            {{-- Header --}}
            <header class="bg-white shadow-sm flex items-center justify-between h-16 px-6 z-10 shrink-0">
                {{-- Bagian Kiri Header (Tombol Toggle) --}}
                <div class="flex items-center">
                    {{-- Tombol Hamburger untuk Mobile --}}
                    <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11Z" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    {{-- Tombol Minimize untuk Desktop --}}
                    <button @click.stop="sidebarMinimized = !sidebarMinimized"
                        class="text-gray-500 focus:outline-none hidden lg:block p-1 rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                </div>

                {{-- Bagian Kanan Header (Notifikasi & User) --}}
                <div class="flex items-center gap-4">

                    {{-- [!!!] KOMPONEN NOTIFIKASI YANG DIPERBARUI [!!!] --}}
                    <x-notification-dropdown :notifications="$notifications"
                        :unread-count="$unreadNotificationsCount" />

                    {{-- Dropdown User Profile --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                            style="display: none;">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Log Out
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Slot untuk konten halaman dinamis --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="container mx-auto px-6 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>