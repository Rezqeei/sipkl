<x-admin-bidang-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">Monitoring Laporan Akhir Mahasiswa</h1>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Nama Mahasiswa
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Judul Laporan
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        File Laporan
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Tanggal Unggah
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- --- PROBLEM SOLVING LOGIC --- --}}
                                {{-- 1. Mengganti variabel $daftarLaporan menjadi $laporanAkhir agar sesuai dengan controller. --}}
                                {{-- 2. Menyederhanakan cara pemanggilan nama mahasiswa menjadi $laporan->user->name. --}}
                                {{-- 3. Menggunakan helper route() untuk link download yang lebih aman. --}}
                                @forelse ($laporanAkhir as $laporan)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-4 px-6">{{ $laporan->user->name }}</td>
                                        <td class="py-4 px-6">{{ $laporan->judul ?? 'Tidak ada judul' }}</td>
                                        <td class="py-4 px-6">
                                            <a href="{{ route('admin-bidang.monitoring-laporan.download', $laporan->id) }}" target="_blank" class="text-blue-600 hover:underline">
                                                Lihat/Unduh File
                                            </a>
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $laporan->created_at->format('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 px-6 text-center text-gray-500">
                                            Belum ada laporan akhir yang diunggah oleh mahasiswa di bidang ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-bidang-layout>
