<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin Instansi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as Admin Instansi!") }}
                </div>
            </div>

            <!-- Bagian Statistik -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Pengajuan PKL Baru -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Pengajuan PKL Baru
                                </dt>
                                <dd class="text-3xl font-semibold text-gray-900">
                                    {{ $jumlahPengajuanBaru ?? 0 }}
                                </dd>
                            </div>
                        </div>
                        <div class="mt-4">
                             <a href="{{ route('admin-instansi.verifikasi-pengajuan.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Lihat Detail &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Dokumen Menunggu Verifikasi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Dokumen Menunggu Verifikasi
                                </dt>
                                <dd class="text-3xl font-semibold text-gray-900">
                                    {{ $jumlahDokumenMenunggu ?? 0 }}
                                </dd>
                            </div>
                        </div>
                         <div class="mt-4">
                             <a href="{{ route('admin-instansi.verifikasi-dokumen.index') }}" class="text-sm text-green-600 hover:text-green-900">Lihat Detail &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Total Mahasiswa Aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Mahasiswa Aktif
                                </dt>
                                <dd class="text-3xl font-semibold text-gray-900">
                                    {{ $totalMahasiswaAktif ?? 0 }}
                                </dd>
                            </div>
                        </div>
                         <div class="mt-4">
                             <a href="{{ route('admin-instansi.penempatan.index') }}" class="text-sm text-yellow-600 hover:text-yellow-900">Lihat Detail &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Total Bidang Tersedia -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                               <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Bidang Tersedia
                                </dt>
                                <dd class="text-3xl font-semibold text-gray-900">
                                    {{ $totalBidangTersedia ?? 0 }}
                                </dd>
                            </div>
                        </div>
                         <div class="mt-4">
                             <a href="{{ route('admin-instansi.manajemen-bidang.index') }}" class="text-sm text-blue-600 hover:text-blue-900">Lihat Detail &rarr;</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
