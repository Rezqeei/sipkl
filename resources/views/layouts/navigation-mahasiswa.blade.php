{{-- Overlay untuk mobile saat sidebar terbuka --}}
<div x-show="sidebarOpen" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30" @click="sidebarOpen = false">
</div>

{{-- Komponen Sidebar --}}
<aside class="fixed inset-y-0 left-0 bg-white shadow-lg z-40 flex flex-col transition-all duration-300 ease-in-out"
    :class="{
        'w-64': !sidebarMinimized,
        'w-20': sidebarMinimized,
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'lg:translate-x-0': true
    }">

    {{-- Header Sidebar (Logo) --}}
    <div class="flex items-center px-6 h-16 border-b shrink-0 overflow-hidden"
        :class="sidebarMinimized ? 'justify-center' : 'justify-start'">
        <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="SIPKL Logo" class="w-11 h-11 shrink-0">
            <div x-show="!sidebarMinimized" class="transition-all duration-200">
                <span class="font-extrabold text-xl text-[#1a3760] tracking-wide whitespace-nowrap">SIPKL</span>
                <p class="text-xs text-gray-500 font-medium leading-tight whitespace-nowrap">Sistem Informasi PKL</p>
            </div>
        </a>
    </div>

    {{-- Menu Navigasi --}}
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-2">
            {{-- Menu Beranda --}}
            <li>
                <a href="{{ route('mahasiswa.dashboard') }}" title="Beranda"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition" :class="{
                        'bg-blue-100 text-blue-700 font-semibold': {{ request()->routeIs('mahasiswa.dashboard') ? 'true' : 'false' }},
                        'text-gray-600 hover:bg-gray-100': !{{ request()->routeIs('mahasiswa.dashboard') ? 'true' : 'false' }},
                        'justify-center': sidebarMinimized
                    }">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="!sidebarMinimized" class="whitespace-nowrap">Beranda</span>
                </a>
            </li>

            {{-- [!!!] MENU NOTIFIKASI BARU DITAMBAHKAN DI SINI [!!!] --}}
            <li>
                <div class="relative">
                    <a href="#" @click.prevent="$dispatch('open-notification-modal')" title="Notifikasi"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition text-gray-600 hover:bg-gray-100"
                        :class="{'justify-center': sidebarMinimized}">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span x-show="!sidebarMinimized" class="whitespace-nowrap">Notifikasi</span>
                    </a>
                    {{-- Badge Notifikasi --}}
                    @if($unreadCount > 0)
                    <span
                        class="absolute top-2 right-4 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full"
                        x-show="!sidebarMinimized">
                        {{ $unreadCount }}
                    </span>
                    <span class="absolute top-2 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"
                        x-show="sidebarMinimized"></span>
                    @endif
                </div>
            </li>

            {{-- Menu Identitas Dinas --}}
            <li>
                <a href="{{ route('mahasiswa.identitas.dinas') }}" title="Identitas Dinas"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition" :class="{
                        'bg-blue-100 text-blue-700 font-semibold': {{ request()->routeIs('mahasiswa.identitas.dinas') ? 'true' : 'false' }},
                        'text-gray-600 hover:bg-gray-100': !{{ request()->routeIs('mahasiswa.identitas.dinas') ? 'true' : 'false' }},
                        'justify-center': sidebarMinimized
                    }">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l-2 2m0 0l-2-2m2 2v-4.586a1 1 0 01.293-.707l5.414-5.414A1 1 0 0112.586 3H7a2 2 0 00-2 2v3m15 12V9a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2h7a2 2 0 002-2z">
                        </path>
                    </svg>
                    <span x-show="!sidebarMinimized" class="whitespace-nowrap">Identitas Dinas</span>
                </a>
            </li>

            {{-- Menu Dropdown Pengajuan PKL --}}
            <li
                x-data="{ open: {{ request()->routeIs('mahasiswa.pengajuan.*') || request()->routeIs('mahasiswa.unggah.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" title="Pengajuan PKL"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100"
                    :class="{'justify-center': sidebarMinimized}">
                    <span class="flex items-center gap-3">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span x-show="!sidebarMinimized" class="whitespace-nowrap">Pengajuan PKL</span>
                    </span>
                    <svg x-show="!sidebarMinimized" :class="{'rotate-180': open}" class="w-5 h-5 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open && !sidebarMinimized" x-collapse.duration.300ms class="pl-8 space-y-1 mt-1">
                    <li><a href="{{ route('mahasiswa.pengajuan.antrian') }}"
                            class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('mahasiswa.pengajuan.antrian') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">Pengajuan
                            Antrian</a></li>
                    <li><a href="{{ route('mahasiswa.unggah.dokumen') }}"
                            class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('mahasiswa.unggah.dokumen') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">Unggah
                            Dokumen</a></li>
                </ul>
            </li>

            {{-- Menu Dropdown Laporan PKL --}}
            <li x-data="{ open: {{ request()->routeIs('mahasiswa.laporan.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" title="Laporan PKL"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100"
                    :class="{'justify-center': sidebarMinimized}">
                    <span class="flex items-center gap-3">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7v8a2 2 0 002 2h4M8 7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2h-4a2 2 0 01-2-2V7z">
                            </path>
                        </svg>
                        <span x-show="!sidebarMinimized" class="whitespace-nowrap">Laporan PKL</span>
                    </span>
                    <svg x-show="!sidebarMinimized" :class="{'rotate-180': open}" class="w-5 h-5 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open && !sidebarMinimized" x-collapse.duration.300ms class="pl-8 space-y-1 mt-1">
                    <li><a href="{{ route('mahasiswa.laporan.mingguan') }}"
                            class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('mahasiswa.laporan.mingguan') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">Laporan
                            Mingguan</a></li>
                    <li><a href="{{ route('mahasiswa.laporan.akhir') }}"
                            class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('mahasiswa.laporan.akhir') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">Laporan
                            Akhir</a></li>
                </ul>
            </li>

            {{-- Menu Download SK PKL --}}
            <li>
                <a href="{{ route('mahasiswa.download.sk') }}" title="Download SK PKL"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition" :class="{
                        'bg-blue-100 text-blue-700 font-semibold': {{ request()->routeIs('mahasiswa.download.sk') ? 'true' : 'false' }},
                        'text-gray-600 hover:bg-gray-100': !{{ request()->routeIs('mahasiswa.download.sk') ? 'true' : 'false' }},
                        'justify-center': sidebarMinimized
                    }">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span x-show="!sidebarMinimized" class="whitespace-nowrap">Download SK PKL</span>
                </a>
            </li>

            {{-- Menu Pengaturan --}}
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