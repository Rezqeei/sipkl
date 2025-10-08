{{-- Logika untuk menentukan menu dropdown mana yang aktif --}}
@php
$isManajemenPengajuanOpen = request()->routeIs('admin-instansi.verifikasi-pengajuan.index') ||
request()->routeIs('admin-instansi.verifikasi-dokumen.index');
$isPenempatanOpen = request()->routeIs('admin-instansi.penempatan.index');
@endphp

{{-- Awal dari komponen navigasi --}}
<div x-data="{ sidebarOpen: window.innerWidth > 1024 }">
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden" x-cloak></div>

    <aside
        class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-lg transform transition-transform duration-300 lg:translate-x-0"
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

        <div class="flex items-center gap-3 px-6 py-5 border-b">
            <img src="{{ asset('images/logo.png') }}" alt="SIPKL Logo" class="w-10 h-10">
            <div>
                <span class="font-extrabold text-xl text-gray-800 tracking-wide">SIPKL</span>
                <p class="text-xs text-gray-500 font-medium">ADMIN INSTANSI</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('admin-instansi.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin-instansi.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span>Beranda</span>
            </a>

            <div x-data="{ open: {{ $isManajemenPengajuanOpen ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100">
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span>Manajemen Pengajuan</span>
                    </span>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open" x-collapse class="pl-8 space-y-1 mt-1">
                    <li><a href="{{ route('admin-instansi.verifikasi-pengajuan.index') }}"
                            class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin-instansi.verifikasi-pengajuan.index') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">Verifikasi
                            Antrian</a></li>
                    <li><a href="{{ route('admin-instansi.verifikasi-dokumen.index') }}"
                            class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin-instansi.verifikasi-dokumen.index') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">Verifikasi
                            Dokumen</a></li>
                </ul>
            </div>

            <div x-data="{ open: {{ $isPenempatanOpen ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100">
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        <span>Penempatan Mahasiswa</span>
                    </span>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open" x-collapse class="pl-8 space-y-1 mt-1">
                    <li><a href="{{ route('admin-instansi.penempatan.index') }}"
                            class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin-instansi.penempatan.index') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">Penempatan</a>
                    </li>
                </ul>
            </div>

            {{-- --- PERBAIKAN DI SINI --- --}}
            <a href="{{ route('admin-instansi.manajemen-admin-bidang.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin-instansi.manajemen-admin-bidang.index') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-1a6 6 0 00-5.176-5.97m8.352 5.97h.001">
                    </path>
                </svg>
                <span>Manajemen Admin & Bidang</span>
            </a>

            <a href="{{ route('admin-instansi.arsip-pkl.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin-instansi.arsip-pkl.index') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                    </path>
                </svg>
                <span>Arsip PKL</span>
            </a>

            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('profile.edit') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Pengaturan</span>
            </a>
        </nav>
    </aside>

    <header
        class="fixed top-0 left-0 lg:left-64 right-0 z-30 flex items-center justify-between px-6 py-2 bg-white border-b h-16">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </svg>
        </button>

        <div class="flex-1"></div>

        <div class="flex items-center gap-4">
            {{-- Ikon Notifikasi --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="relative text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    @if($unreadNotifications->count() > 0)
                    <span
                        class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                        {{ $unreadNotifications->count() }}
                    </span>
                    @endif
                </button>

                {{-- Dropdown Notifikasi --}}
                <div x-show="open" @click.outside="open = false"
                    class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-50 border border-gray-200"
                    x-cloak>
                    <div class="py-2 px-4 font-bold text-sm text-gray-700 border-b">Notifikasi Terbaru</div>
                    <div class="py-2">
                        @forelse($unreadNotifications as $notification)
                        <a href="{{ $notification->data['url'] }}?read={{ $notification->id }}"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                            <span class="font-bold mr-2">🔔</span>
                            <span>{{ $notification->data['pesan'] }}</span>
                        </a>
                        @empty
                        <div class="flex items-center px-4 py-3 text-sm text-gray-700">
                            <span class="mr-3">📭</span>
                            <span>Tidak ada notifikasi baru.</span>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            {{-- Dropdown Profil --}}
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" x-cloak>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Keluar
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </header>
</div>