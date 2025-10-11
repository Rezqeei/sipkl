<x-admin-bidang-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Beranda
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (!$bidang)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p class="font-bold">Perhatian</p>
                <p>Akun Anda saat ini belum terhubung ke bidang manapun. Silakan hubungi Admin Instansi.</p>
            </div>
            @else
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Bidang: {{ $bidang->nama_bidang }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Mahasiswa Aktif</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $mahasiswaAktifCount }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Sisa Kuota</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $sisaKuota }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-bidang-layout>