<x-admin-bidang-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Laporan Mingguan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Daftar Laporan Mingguan Mahasiswa</h3>

                    {{-- Notifikasi untuk pesan sukses atau error --}}
                    @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg">
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- Tabel Laporan --}}
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No
                                    </th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama
                                        Mahasiswa</th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Asal
                                        Instansi</th>
                                    <th class="py-3 px-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                        Minggu Ke-</th>
                                    <th class="py-3 px-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                        Status</th>
                                    <th class="py-3 px-4 text-center text-xs font-semibold text-gray-600 uppercase">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($laporans as $laporan)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $loop->iteration }}</td>

                                    {{-- INI BAGIAN PALING PENTING: MENAMPILKAN NAMA MAHASISWA --}}
                                    <td class="py-3 px-4 text-sm font-medium text-gray-900">{{
                                        $laporan->penempatan->mahasiswa->name ?? 'Data Mahasiswa Tidak Ditemukan' }}
                                    </td>

                                    <td class="py-3 px-4 text-sm text-gray-600">{{
                                        $laporan->penempatan->antrian->nama_kampus ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 text-sm text-center text-gray-600">{{ $laporan->minggu_ke }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        {{-- Badge Status dengan Warna --}}
                                        @if ($laporan->status_verifikasi == 'Disetujui')
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Disetujui</span>
                                        @elseif ($laporan->status_verifikasi == 'Ditolak')
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Ditolak</span>
                                        @else
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            {{-- Tombol Unduh --}}
                                            <a href="{{ route('admin-bidang.monitoring.laporan.mingguan.download', $laporan->id_laporan_mingguan) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition"
                                                title="Unduh">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                    </path>
                                                </svg>
                                            </a>
                                            {{-- Tombol Setujui --}}
                                            <form
                                                action="{{ route('admin-bidang.monitoring.laporan.mingguan.verify', $laporan->id_laporan_mingguan) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status_verifikasi" value="Disetujui">
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full hover:bg-green-200 transition"
                                                    title="Setujui">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            {{-- Tombol Tolak --}}
                                            <form
                                                action="{{ route('admin-bidang.monitoring.laporan.mingguan.verify', $laporan->id_laporan_mingguan) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status_verifikasi" value="Ditolak">
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 rounded-full hover:bg-red-200 transition"
                                                    title="Tolak">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-6 px-4 text-center text-gray-500">
                                        Belum ada laporan mingguan dari mahasiswa di bidang Anda.
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