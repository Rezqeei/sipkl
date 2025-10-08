@php
$isMonitoringActive = request()->routeIs('admin-bidang.monitoring.laporan.mingguan') ||
request()->routeIs('admin-bidang.monitoring.laporan.akhir');
@endphp

<div x-show="sidebarOpen" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30" @click="sidebarOpen = false"
    x-cloak></div>

<aside class="fixed inset-y-0 left-0 bg-white shadow-lg z-40 flex flex-col transition-all duration-300 ease-in-out"
    :class="{
        'w-64': !sidebarMinimized,
        'w-20': sidebarMinimized,
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'lg:translate-x-0': true
    }">

    <div class="flex items-center px-6 h-16 border-b shrink-0 overflow-hidden"
        :class="sidebarMinimized ? 'justify-center' : 'justify-start'">
        <a href="{{ route('admin-bidang.dashboard') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="SIPKL Logo" class="w-10 h-10 shrink-0">
            <div x-show="!sidebarMinimized" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <span class="font-extrabold text-xl text-[#1a3760] tracking-wide whitespace-nowrap">SIPKL</span>
                <p class="text-xs text-gray-500 font-medium whitespace-nowrap">Admin Bidang</p>
            </div>
        </a>
    </div>

    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin-bidang.dashboard') }}" title="Beranda"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition" :class="{
                       'bg-blue-100 text-blue-700 font-semibold': {{ request()->routeIs('admin-bidang.dashboard') ? 'true' : 'false' }},
                       'text-gray-600 hover:bg-gray-100': !{{ request()->routeIs('admin-bidang.dashboard') ? 'true' : 'false' }},
                       'justify-center': sidebarMinimized
                   }">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="!sidebarMinimized" class="whitespace-nowrap">Beranda</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin-bidang.konfirmasi-mahasiswa') }}" title="Konfirmasi Mahasiswa"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition" :class="{
                       'bg-blue-100 text-blue-700 font-semibold': {{ request()->routeIs('admin-bidang.konfirmasi-mahasiswa') ? 'true' : 'false' }},
                       'text-gray-600 hover:bg-gray-100': !{{ request()->routeIs('admin-bidang.konfirmasi-mahasiswa') ? 'true' : 'false' }},
                       'justify-center': sidebarMinimized
                   }">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                    <span x-show="!sidebarMinimized" class="whitespace-nowrap">Konfirmasi Mahasiswa</span>
                </a>
            </li>

            <li x-data="{ open: {{ $isMonitoringActive ? 'true' : 'false' }} }" class="relative">
                <button @click="open = !open" title="Monitoring Laporan"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100"
                    :class="{'justify-center': sidebarMinimized}">
                    <span class="flex items-center gap-3">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span x-show="!sidebarMinimized" class="whitespace-nowrap">Monitoring Laporan</span>
                    </span>
                    <svg x-show="!sidebarMinimized" :class="{'rotate-180': open}" class="w-5 h-5 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open && !sidebarMinimized" x-collapse.duration.300ms class="pl-8 space-y-1 mt-1" x-cloak>
                    <li><a href="{{ route('admin-bidang.monitoring.laporan.mingguan') }}"
                            class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin-bidang.monitoring.laporan.mingguan') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">Laporan
                            Mingguan</a></li>
                    <li><a href="{{ route('admin-bidang.monitoring.laporan.akhir') }}"
                            class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin-bidang.monitoring.laporan.akhir') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">Laporan
                            Akhir</a></li>
                </ul>
                <div x-show="open && sidebarMinimized" @click.away="open = false"
                    class="absolute left-full top-0 ml-2 w-52 bg-white rounded-md shadow-lg py-1 z-50 border" x-cloak>
                    <a href="{{ route('admin-bidang.monitoring.laporan.mingguan') }}"
                        class="block px-4 py-2 text-sm {{ request()->routeIs('admin-bidang.monitoring.laporan.mingguan') ? 'text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Laporan
                        Mingguan</a>
                    <a href="{{ route('admin-bidang.monitoring.laporan.akhir') }}"
                        class="block px-4 py-2 text-sm {{ request()->routeIs('admin-bidang.monitoring.laporan.akhir') ? 'text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">Laporan
                        Akhir</a>
                </div>
            </li>

            <li>
                <a href="{{ route('admin-bidang.kuota-bidang') }}" title="Kuota Bidang"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition" :class="{
                       'bg-blue-100 text-blue-700 font-semibold': {{ request()->routeIs('admin-bidang.kuota-bidang') ? 'true' : 'false' }},
                       'text-gray-600 hover:bg-gray-100': !{{ request()->routeIs('admin-bidang.kuota-bidang') ? 'true' : 'false' }},
                       'justify-center': sidebarMinimized
                   }">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M3 14h18m-9-4v8m-7-4h14m-12 4h10m-8 4h6"></path>
                    </svg>
                    <span x-show="!sidebarMinimized" class="whitespace-nowrap">Kuota Bidang</span>
                </a>
            </li>

            <li>
                <a href="{{ route('profile.edit') }}" title="Pengaturan"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition" :class="{
                       'bg-blue-100 text-blue-700 font-semibold': {{ request()->routeIs('profile.edit') ? 'true' : 'false' }},
                       'text-gray-600 hover:bg-gray-100': !{{ request()->routeIs('profile.edit') ? 'true' : 'false' }},
                       'justify-center': sidebarMinimized
                   }">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span x-show="!sidebarMinimized" class="whitespace-nowrap">Pengaturan</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>