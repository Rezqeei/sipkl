<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SIPKL' }} - Admin Instansi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Menambahkan transisi yang mulus untuk margin */
        .transition-margin {
            transition: margin-left 0.3s ease-in-out;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    {{-- Komponen Alpine.js untuk state management sidebar --}}
    <div x-data="{ sidebarOpen: false, sidebarMinimized: false }" @keydown.escape.window="sidebarOpen = false"
        class="h-screen flex overflow-hidden">

        {{-- Memanggil komponen navigasi/sidebar --}}
        @include('layouts.navigation-instansi')

        {{-- Konten Utama --}}
        <div class="flex-1 flex flex-col overflow-hidden transition-margin"
            :class="{'lg:ml-64': !sidebarMinimized, 'lg:ml-20': sidebarMinimized}">

            {{-- Header/Navbar --}}
            <header class="bg-white shadow-sm flex items-center justify-between h-16 px-6 z-20 shrink-0">
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
                <div class="flex items-center gap-5">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="relative text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            {{-- Ganti Auth::user()->unreadNotifications dengan variabel notifikasi Anda --}}
                            @if(Auth::user()->unreadNotifications->count() > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                            @endif
                        </button>
                        {{-- Dropdown Notifikasi --}}
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-50 border border-gray-200"
                            x-cloak>
                            <div class="py-2 px-4 font-bold text-sm text-gray-700 border-b">Notifikasi Terbaru</div>
                            <div class="py-2 max-h-96 overflow-y-auto">
                                @forelse(Auth::user()->unreadNotifications as $notification)
                                <a href="{{ $notification->data['url'] ?? '#' }}?read={{ $notification->id }}"
                                    class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                    <span class="font-bold mr-3">🔔</span>
                                    <span>{{ $notification->data['pesan'] }}</span>
                                </a>
                                @empty
                                <div class="flex items-center px-4 py-3 text-sm text-gray-700"><span
                                        class="mr-3">📭</span><span>Tidak ada notifikasi baru.</span></div>
                                @endforelse
                            </div>
                        </div>
                    </div>

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
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border" x-cloak>
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Keluar
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