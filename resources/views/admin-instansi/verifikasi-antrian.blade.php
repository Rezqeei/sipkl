<x-admin-layout>
    <div class="p-6 md:p-10" x-data="{ showModal: false, selectedAntrian: null }">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Verifikasi Antrian Mahasiswa</h1>

        <div class="bg-white p-8 rounded-xl shadow-lg border">
            <h2 class="text-xl font-semibold mb-4">Daftar Pengajuan Antrian</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">Nama Mahasiswa</th>
                            <th class="py-3 px-6 text-left">NIM</th>
                            <th class="py-3 px-6 text-left">Kampus</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarPengajuan as $index => $antrian)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-4 px-6">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ $antrian->user->name }}
                            </td>
                            <td class="py-4 px-6">{{ $antrian->nim }}</td>
                            <td class="py-4 px-6">{{ $antrian->nama_kampus }}</td>
                            <td class="py-4 px-6">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $antrian->status_antrian }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button @click="showModal = true; selectedAntrian = {{ $antrian }}"
                                    class="bg-blue-500 text-white font-semibold py-1 px-3 rounded-lg text-sm">Detail</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 px-6 text-center text-gray-500">
                                Tidak ada pengajuan antrian baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            x-cloak>
            <div @click.away="showModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">Detail Pengajuan Antrian</h3>
                <div x-show="selectedAntrian" class="space-y-2 text-sm">
                    <p><strong>Nama:</strong> <span x-text="selectedAntrian.user.name"></span></p>
                    <p><strong>NIM:</strong> <span x-text="selectedAntrian.nim"></span></p>
                    <p><strong>Jurusan:</strong> <span x-text="selectedAntrian.jurusan"></span></p>
                    <p><strong>Kampus:</strong> <span x-text="selectedAntrian.nama_kampus"></span></p>
                    <p><strong>Alamat:</strong> <span x-text="selectedAntrian.alamat"></span></p>
                    <p><strong>Jumlah Orang:</strong> <span x-text="selectedAntrian.jumlah_orang"></span></p>
                    <p><strong>Periode:</strong> <span
                            x-text="new Date(selectedAntrian.tgl_mulai).toLocaleDateString('id-ID') + ' - ' + new Date(selectedAntrian.tgl_berakhir).toLocaleDateString('id-ID')"></span>
                    </p>
                </div>
                <div class="mt-6 flex justify-end gap-4">
                    <button @click="showModal = false" class="bg-gray-200 py-2 px-4 rounded-lg">Batal</button>
                    <form :action="'/admin-instansi/verifikasi-pengajuan/' + selectedAntrian.id_antrian" method="POST"
                        onsubmit="return confirm('Tolak pengajuan ini?')">
                        @csrf
                        <input type="hidden" name="action" value="tolak">
                        <input type="hidden" name="alasan_penolakan" value="Kuota Penuh">
                        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-lg">Tolak</button>
                    </form>
                    <form :action="'/admin-instansi/verifikasi-pengajuan/' + selectedAntrian.id_antrian" method="POST"
                        onsubmit="return confirm('Terima pengajuan ini?')">
                        @csrf
                        <input type="hidden" name="action" value="terima">
                        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-lg">Terima</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>