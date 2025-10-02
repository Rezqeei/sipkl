<x-admin-bidang-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Beranda
        </h2>
    </x-slot>

   <div class="p-6 md:p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Bidang: {{ $bidang->nama_bidang }}</h1>

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-lg border">
                <h4 class="text-gray-500 font-semibold">Kuota Maksimal</h4>
                <p class="text-3xl font-bold text-blue-600">{{ $bidang->kuota_maksimal }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg border">
                <h4 class="text-gray-500 font-semibold">Mahasiswa Aktif</h4>
                <p class="text-3xl font-bold text-green-600">{{ $jumlahMahasiswaAktif }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg border">
                <h4 class="text-gray-500 font-semibold">Sisa Kuota</h4>
                <p class="text-3xl font-bold text-yellow-600">{{ $bidang->sisa_kuota }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg border">
                <h4 class="text-gray-500 font-semibold">Mahasiswa Selesai</h4>
                <p class="text-3xl font-bold text-gray-800">{{ $jumlahMahasiswaSelesai }}</p>
            </div>
        </div>

        <!-- Daftar Tugas Terbaru -->
        <div class="mt-8 bg-white p-8 rounded-xl shadow-lg border">
            <h2 class="text-xl font-semibold mb-4">Notifikasi Terbaru</h2>
            <div class="space-y-4">
                @forelse ($laporanBaru as $laporan)
                    <div class="p-4 border rounded-lg flex justify-between items-center hover:bg-gray-50">
                        <div>
                            <p>
                                Laporan Mingguan ke-<strong>{{ $laporan->minggu_ke }}</strong> dari 
                                <strong>{{ $laporan->penempatan->antrian->nama_lengkap }}</strong> perlu diverifikasi.
                            </p>
                            <small class="text-gray-500">Dikirim pada: {{ $laporan->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        <a href="#" class="bg-blue-500 text-white text-sm font-semibold py-2 px-4 rounded-lg">
                            Tindak Lanjut
                        </a>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-gray-500">Tidak ada notifikasi atau tugas baru saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-bidang-layout>
