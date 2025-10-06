<x-mahasiswa-layout>
    {{-- Slot Header untuk menampilkan judul di Topbar --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Beranda
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tampilkan pesan jika user baru dan $antrian KOSONG --}}
            @if(!$antrian)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-center">
                    <h2 class="text-xl font-bold text-gray-800">Selamat Datang di SIPKL!</h2>
                    <p class="text-gray-600 mt-2">Sepertinya Anda belum memiliki riwayat pengajuan PKL. Mari mulai
                        langkah pertama Anda.</p>
                    <a href="{{ route('mahasiswa.pengajuan.antrian') }}"
                        class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg shadow-md transition">
                        Ajukan PKL Sekarang
                    </a>
                </div>
            </div>

            {{-- JIKA USER SUDAH PUNYA DATA, TAMPILKAN SEMUA STATUS --}}
            @else
            {{-- Kita gunakan Grid System: 2 kolom di layar medium, 1 kolom di layar kecil --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Kartu Status Antrian PKL -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-4">Status Antrian PKL</h3>
                    <div class="flex items-center space-x-2">
                        <span
                            class="px-3 py-1 text-sm font-semibold rounded-full {{ $antrian->status_antrian == 'Diterima' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">✓
                            Diterima</span>
                        <span
                            class="px-3 py-1 text-sm font-semibold rounded-full {{ $antrian->status_antrian == 'Menunggu Verifikasi' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-200 text-gray-600' }}">⏳
                            Menunggu</span>
                        <span
                            class="px-3 py-1 text-sm font-semibold rounded-full {{ $antrian->status_antrian == 'Ditolak' ? 'bg-red-100 text-red-800' : 'bg-gray-200 text-gray-600' }}">✗
                            Ditolak</span>
                    </div>
                </div>

                <!-- Kartu Status Dokumen -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-4">Status Dokumen</h3>
                    <div class="flex items-center space-x-2">
                        <span
                            class="px-3 py-1 text-sm font-semibold rounded-full {{ optional($antrian->dokumen)->status_verifikasi == 'Diterima' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">✓
                            Diterima</span>
                        <span
                            class="px-3 py-1 text-sm font-semibold rounded-full {{ optional($antrian->dokumen)->status_verifikasi == 'Menunggu Verifikasi' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-200 text-gray-600' }}">⏳
                            Menunggu</span>
                        <span
                            class="px-3 py-1 text-sm font-semibold rounded-full {{ optional($antrian->dokumen)->status_verifikasi == 'Revisi' ? 'bg-red-100 text-red-800' : 'bg-gray-200 text-gray-600' }}">✗
                            Revisi</span>
                    </div>
                </div>

                <!-- Kartu Status Penempatan Bidang (memakan 2 kolom) -->
                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-4">Status Penempatan Bidang</h3>
                    @if($antrian->penempatan)
                    <div class="space-y-2 text-gray-700">
                        <p><strong class="w-32 inline-block">Bidang:</strong> {{
                            optional($antrian->penempatan->bidang)->nama_bidang }}</p>
                        <p><strong class="w-32 inline-block">Pembimbing:</strong> {{
                            optional($antrian->penempatan->pembimbing)->nama_pembimbing ?? 'Belum Ditentukan' }}</p>
                        <p><strong class="w-32 inline-block">Periode PKL:</strong> {{
                            \Carbon\Carbon::parse($antrian->tgl_mulai)->format('d M Y') }} - {{
                            \Carbon\Carbon::parse($antrian->tgl_berakhir)->format('d M Y') }}</p>
                    </div>
                    @else
                    <p class="text-gray-500">Anda belum ditempatkan pada bidang manapun.</p>
                    @endif
                </div>

                <!-- Kartu Status Progress Laporan (memakan 2 kolom) -->
                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-4">Status Progress Laporan</h3>
                    @if($antrian->penempatan)
                    <div class="space-y-2 text-gray-700">
                        <p><strong class="w-48 inline-block">Laporan Mingguan Diunggah:</strong> {{
                            $antrian->penempatan->laporanMingguan->count() }} Laporan</p>
                        <p><strong class="w-48 inline-block">Status Laporan Terakhir:</strong> <span
                                class="font-semibold">{{
                                optional($antrian->penempatan->laporanMingguan->last())->status_verifikasi ?? 'Belum
                                Mengunggah' }}</span></p>
                        <hr class="my-3">
                        <p><strong class="w-48 inline-block">Laporan Akhir:</strong> <span
                                class="font-bold {{ $antrian->penempatan->laporanAkhir ? 'text-green-600' : 'text-red-600' }}">{{
                                $antrian->penempatan->laporanAkhir ? 'Sudah Diunggah' : 'Belum Diunggah' }}</span></p>
                        <p><strong class="w-48 inline-block">Status Laporan Akhir:</strong> <span
                                class="font-semibold">{{ optional($antrian->penempatan->laporanAkhir)->status_verifikasi
                                ?? '-' }}</span></p>
                    </div>
                    @else
                    <p class="text-gray-500">Belum bisa membuat laporan.</p>
                    @endif
                </div>

            </div>
            @endif
        </div>
    </div>
</x-mahasiswa-layout>