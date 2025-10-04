<?php
// Mendefinisikan variabel PHP di awal untuk digunakan di Blade
// $isMonitoringActive diperlukan di li class di line 44 dan di x-data line 43
$isMonitoringActive = 
    request()->routeIs('admin_bidang.laporan-mingguan') || 
    request()->routeIs('admin_bidang.laporan-akhir');
?>
<div x-data="{ open: false, isManajemenActive: {{ request()->routeIs('admin_bidang.manajemen-admin-bidang') ? 'true' : 'false' }} }">
    <!-- Overlay for Mobile -->
    <div x-show="open" x-transition.opacity @click="open = false" 
         class="fixed inset-0 bg-gray-900 bg-opacity-75 z-40 lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="{'translate-x-0': open, '-translate-x-full': !open}" 
           class="bg-white w-64 min-h-screen shadow-xl flex flex-col fixed h-full z-50 
                  transform transition-transform duration-300 ease-in-out lg:translate-x-0">
        
        <!-- Header Logo -->
        <div class="flex items-center gap-2 px-6 py-6 border-b">
            <img src="{{ asset('images/logo.png') }}" alt="SIPKL Logo" class="w-10 h-10">
            <div>
                <span class="font-extrabold text-xl text-[#1a3760] tracking-wide">SIPKL</span>
                <div class="text-xs text-gray-500 font-medium">Admin Bidang</div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <ul class="space-y-1">
                <!-- Beranda -->
                <li>
                    <a href="{{ route('admin-bidang.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                        {{ request()->routeIs('admin_bidang.dashboard') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-medium' }}">
                        <span class="text-lg">🏠</span>
                        <span class="sidebar-label">Beranda</span>
                    </a>
                </li>
                
                <!-- Konfirmasi Mahasiswa -->
                <li>
                    <a href="{{ route('admin-bidang.konfirmasi-mahasiswa') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                        {{ request()->routeIs('admin_bidang.konfirmasi-mahasiswa') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-medium' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="sidebar-label">Konfirmasi Mahasiswa</span>
                    </a>
                </li>
                
                <!-- Dropdown: Monitoring Laporan -->
                <li x-data="{ open: {{ $isMonitoringActive ? 'true' : 'false' }} }" 
                    class="{{ $isMonitoringActive ? 'bg-blue-50 rounded-lg' : '' }}">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-medium transition {{ $isMonitoringActive ? 'text-blue-700' : '' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="sidebar-label">Monitoring Laporan</span>
                        </span>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <ul x-show="open" x-collapse.duration.300ms class="pl-8 space-y-1 mt-1">
                        <li>
                            <a href="{{ route('admin-bidang.laporan-mingguan') }}"
                                class="block px-4 py-2 rounded-lg transition
                                {{ request()->routeIs('admin_bidang.laporan-mingguan') ? 'bg-blue-100 text-blue-700 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-medium' }}">
                                Laporan Mingguan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-bidang.laporan-akhir') }}"
                                class="block px-4 py-2 rounded-lg transition
                                {{ request()->routeIs('admin_bidang.laporan-akhir') ? 'bg-blue-100 text-blue-700 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-medium' }}">
                                Laporan Akhir
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Kuota Bidang -->
                <li>
                    <a href="{{ route('admin-bidang.kuota-bidang') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                        {{ request()->routeIs('admin_bidang.kuota-bidang') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-medium' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7-4h14m-12 4h10m-8 4h6"></path></svg>
                        <span class="sidebar-label">Kuota Bidang</span>
                    </a>
                </li>

                <!-- Pengaturan -->
                <li>
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                        {{ request()->routeIs('admin_bidang.pengaturan') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-medium' }}">
                        <span class="text-lg">⚙️</span>
                        <span class="sidebar-label">Pengaturan</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    
    <!-- Topbar (Fixed) -->
    <header class="bg-white shadow flex items-center justify-end px-8 py-3 fixed top-0 left-0 lg:left-64 right-0 z-30 h-16">
        <div class="flex items-center gap-4">
            <!-- Mobile Menu Button -->
            <button @click="open = true" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none p-2 rounded-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
            
            <!-- Notifikasi Icon -->
            <div x-data="{ open: false }" class="relative hidden sm:block">
                <button @click="open = !open" class="relative focus:outline-none p-2 rounded-full hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-gray-500 hover:text-blue-700 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" /></svg>
                    {{-- Badge notifikasi (contoh) --}}
                    <span class="absolute top-1 right-1 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                
                {{-- Dropdown Notifikasi (Dummy) --}}
                <div x-show="open" @click.outside="open = false" 
                    class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-xl overflow-hidden z-40 border border-gray-200" 
                    x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" 
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">
                    <div class="py-2 px-4 font-bold text-sm text-gray-700 border-b">Notifikasi Terbaru</div>
                    <div class="py-2">
                        <div class="flex items-center px-4 py-2 text-sm text-gray-700">
                            <span class="text-blue-500 mr-3">🔔</span>Tidak ada notifikasi baru.
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Dropdown (Admin Bidang) -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-full text-gray-700 bg-white hover:text-blue-700 focus:outline-none transition ease-in-out duration-150 shadow-sm hover:shadow-md">
                        <!-- User Icon (Avatar Placeholder) -->
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        
                        <div>{{ Auth::user()->name ?? 'Admin Bidang' }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </div>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </header>
</div>
