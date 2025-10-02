<x-admin-bidang-layout>
    <div class="p-6 md:p-10" x-data="{ showModal: false, selectedLaporan: null }">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Verifikasi Laporan Akhir</h1>

        <div class="bg-white p-8 rounded-xl shadow-lg border">
            <h2 class="text-xl font-semibold mb-4">Daftar Laporan Akhir Masuk</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 text-left">Nama Mahasiswa</th>
                            <th class="py-3 px-6 text-left">Judul Laporan</th>
                            <th class="py-3 px-6 text-left">File</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarLaporan as $laporan)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-6">{{ $laporan->penempatan->antrian->nama_lengkap }}</td>
                                <td class="py-4 px-6">{{ $laporan->judul ?? 'Tidak ada judul' }}</td>
                                <td class="py-4 px-6">
                                    <a href="{{ asset('storage/' . $laporan->file_laporan) }}" target="_blank" class="text-blue-600 hover:underline">
                                        Lihat/Unduh File
                                    </a>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex justify-center gap-2">
                                        <form method="POST" action="{{ route('admin-bidang.laporan-akhir.update', $laporan) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="setuju">
                                            <button type="submit" class="bg-green-500 text-white font-semibold py-1 px-3 rounded-lg text-sm">Setuju</button>
                                        </form>
                                        <button @click="showModal = true; selectedLaporan = {{ $laporan }};" class="bg-yellow-500 text-white font-semibold py-1 px-3 rounded-lg text-sm">Revisi</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-4 px-6 text-center text-gray-500">Tidak ada laporan akhir yang perlu diverifikasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal untuk Catatan Revisi -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
            <div @click.away="showModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">Catatan Revisi Laporan Akhir</h3>
                <form :action="`/admin-bidang/laporan-akhir/${selectedLaporan ? selectedLaporan.id_laporan_akhir : ''}`" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="revisi">
                    <div>
                        <label class="block mb-1">Tuliskan feedback untuk revisi:</label>
                        <textarea name="feedback" rows="4" class="w-full p-2 border rounded-lg" required></textarea>
                    </div>
                    <div class="mt-6 flex justify-end gap-4">
                        <button type="button" @click="showModal = false" class="bg-gray-200 py-2 px-4 rounded-lg">Batal</button>
                        <button type="submit" class="bg-yellow-500 text-white py-2 px-4 rounded-lg">Kirim Revisi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-bidang-layout>