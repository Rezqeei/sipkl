<x-admin-bidang-layout>
    <div class="container mx-auto px-6 py-8">
        {{-- --- PROBLEM SOLVING LOGIC --- --}}
        {{-- Kita akan memeriksa terlebih dahulu apakah variabel $bidang memiliki data atau tidak. --}}
        @if ($bidang)
            {{-- Jika $bidang tidak null (ada isinya), tampilkan dashboard seperti biasa. --}}
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Bidang: {{ $bidang->nama_bidang }}</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Mahasiswa Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-700">Total Mahasiswa</h2>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalMahasiswa }}</p>
                </div>

                <!-- Total Antrian Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-700">Total Antrian</h2>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAntrian }}</p>
                </div>

                <!-- Kuota Tersedia Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-700">Kuota Tersedia</h2>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $kuotaTersedia }}</p>
                </div>
            </div>
            
        @else
            {{-- Jika $bidang bernilai null, tampilkan pesan peringatan. --}}
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang, Admin Bidang</h1>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mt-6" role="alert">
                <p class="font-bold">Perhatian</p>
                <p>Akun Anda saat ini belum terhubung ke bidang manapun. Silakan hubungi Admin Instansi untuk menetapkan bidang yang akan Anda kelola.</p>
            </div>
        @endif
    </div>
</x-admin-bidang-layout>
