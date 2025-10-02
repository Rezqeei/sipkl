<x-admin-layout>
     <div class="p-6 md:p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Arsip Mahasiswa PKL</h1>

        <div class="bg-white p-8 rounded-xl shadow-lg border">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 text-left">Nama Mahasiswa</th>
                            <th class="py-3 px-6 text-left">Asal Kampus</th>
                            <th class="py-3 px-6 text-left">Bidang</th>
                            <th class="py-3 px-6 text-left">Periode Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($arsipMahasiswa as $arsip)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-6">{{ $arsip->antrian->nama_lengkap }}</td>
                                <td class="py-4 px-6">{{ $arsip->antrian->nama_kampus }}</td>
                                <td class="py-4 px-6">{{ $arsip->bidang->nama_bidang }}</td>
                                <td class="py-4 px-6">{{ $arsip->updated_at->format('d F Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 px-6 text-center text-gray-500">
                                    Belum ada data mahasiswa yang diarsip.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
