<div class="flex h-screen bg-gray-100" x-data="{ sidebarOpen: true }">
    <aside
        :class="{'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen}"
        class="bg-white w-64 min-h-screen shadow flex flex-col fixed h-full z-40 transition-transform duration-300"
    >
        <div class="flex items-center gap-2 px-6 py-6 border-b">
            <img src="{{ asset('images/logo.png') }}" alt="SIPKL Logo" class="w-12 h-12">
            <div>
                <span class="font-extrabold text-xl text-[#1a3760] tracking-wide">SIPKL</span>
                <div class="text-xs text-gray-500 font-medium">Sistem Informasi Praktik Kerja Lapangan</div>
            </div>
        </div>
        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    {{-- Nama rute yang benar: mahasiswa.dashboard --}}
                    <a href="{{ route('mahasiswa.dashboard') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg transition {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                        <span class="text-xl">🏠</span>
                        <span>Beranda</span>
                    </a>
                </li>
                <li>
                    {{-- Nama rute yang benar: mahasiswa.identitas.dinas --}}
                    <a href="{{ route('mahasiswa.identitas.dinas') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg transition {{ request()->routeIs('mahasiswa.identitas.dinas') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                        <span class="text-xl">📝</span>
                        <span>Identitas Dinas</span>
                    </a>
                </li>
                
                <li x-data="{ open: {{ request()->routeIs('mahasiswa.pengajuan.*') || request()->routeIs('mahasiswa.unggah.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                        <span class="flex items-center gap-2"><span class="text-xl">📄</span><span>Pengajuan PKL</span></span>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <ul x-show="open" x-collapse class="pl-8 space-y-1 mt-1">
                        <li>
                            {{-- Nama rute yang benar: mahasiswa.pengajuan.antrian --}}
                            <a href="{{ route('mahasiswa.pengajuan.antrian') }}" class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('mahasiswa.pengajuan.antrian') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                                Pengajuan Antrian
                            </a>
                        </li>
                        <li>
                            {{-- Nama rute yang benar: mahasiswa.unggah.dokumen --}}
                            <a href="{{ route('mahasiswa.unggah.dokumen') }}" class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('mahasiswa.unggah.dokumen') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                                Unggah Dokumen
                            </a>
                        </li>
                    </ul>
                </li>

                <li x-data="{ open: {{ request()->routeIs('mahasiswa.laporan.*') ? 'true' : 'false' }} }">
                     <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                        <span class="flex items-center gap-2"><span class="text-xl">📑</span><span>Laporan PKL</span></span>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <ul x-show="open" x-collapse class="pl-8 space-y-1 mt-1">
                        <li>
                            {{-- Nama rute yang benar: mahasiswa.laporan.mingguan --}}
                            <a href="{{ route('mahasiswa.laporan.mingguan') }}" class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('mahasiswa.laporan.mingguan') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                                Laporan Mingguan
                            </a>
                        </li>
                        <li>
                            {{-- Nama rute yang benar: mahasiswa.laporan.akhir --}}
                            <a href="{{ route('mahasiswa.laporan.akhir') }}" class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('mahasiswa.laporan.akhir') ? 'bg-blue-100 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                                Laporan Akhir
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    {{-- Nama rute yang benar: mahasiswa.download.sk --}}
                    <a href="{{ route('mahasiswa.download.sk') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg transition {{ request()->routeIs('mahasiswa.download.sk') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                        <span class="text-xl">⬇️</span>
                        <span>Download SK PKL</span>
                    </a>
                </li>
                <li>
                    {{-- Rute profile.edit adalah global, jadi tidak perlu prefix --}}
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg transition {{ request()->routeIs('profile.edit') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                        <span class="text-xl">⚙️</span>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- Sisanya tidak perlu diubah --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- ... (kode header dan main content-mu) ... --}}
    </div>
</div>

