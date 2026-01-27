<x-mahasiswa-layout>
    <div class="space-y-8 p-6 md:p-10">
        <h1 class="text-3xl font-bold text-gray-800">Laporan Mingguan</h1>

        <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border">
            <h2 class="text-xl font-semibold mb-6 text-gray-700">Unggah Laporan Baru</h2>
            <form method="POST" action="{{ route('mahasiswa.laporan.mingguan.store') }}" enctype="multipart/form-data"
                class="space-y-4 max-w-lg mx-auto">
                @csrf
                <div>
                    <label for="minggu_ke" class="block font-medium">Minggu Ke</label>
                    <input type="number" name="minggu_ke" id="minggu_ke" class="w-full mt-1 p-2 border rounded-lg"
                        min="1" required>
                </div>
                <div>
                    <label for="file_laporan" class="block font-medium">File Laporan (PDF/DOCX, maks 5MB)</label>
                    <input type="file" name="file_laporan" id="file_laporan" class="w-full mt-1" required>
                </div>
                <div class="text-center pt-2">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg">Unggah</button>
                </div>
            </form>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border">
            <h2 class="text-xl font-semibold mb-6 text-gray-700">Riwayat Laporan Mingguan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left">Minggu Ke</th>
                            <th class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penempatan->laporanMingguan as $laporan)
                        <tr class="border-b">
                            <td class="py-4 px-4">{{ $laporan->minggu_ke }}</td>
                            <td class="py-4 px-4">{{ $laporan->status_verifikasi }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-4 px-4 text-center text-gray-500">Belum ada laporan yang diunggah.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-mahasiswa-layout>