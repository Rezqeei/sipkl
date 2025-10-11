<x-admin-layout>
    <div class="p-6 md:p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Arsip Mahasiswa PKL</h1>

        @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white p-8 rounded-xl shadow-lg border">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 text-left">Nama Mahasiswa</th>
                            <th class="py-3 px-6 text-left">Asal Kampus</th>
                            <th class="py-3 px-6 text-left">Bidang</th>
                            <th class="py-3 px-6 text-left">Periode Selesai</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($arsipMahasiswa as $arsip)
                        <tr class="border-b hover:bg-gray-50" x-data="{ showModal: false }">
                            <td class="py-4 px-6">{{ $arsip->antrian->user->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $arsip->antrian->nama_kampus }}</td>
                            <td class="py-4 px-6">{{ $arsip->bidang->nama_bidang }}</td>
                            <td class="py-4 px-6">{{ \Carbon\Carbon::parse($arsip->antrian->tgl_berakhir)->format('d F
                                Y') }}</td>
                            <td class="py-4 px-6 text-center">
                                <button @click="showModal = true"
                                    class="bg-blue-500 text-white font-semibold py-1 px-3 rounded-lg text-sm">
                                    Kirim SK
                                </button>

                                <div x-show="showModal"
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                    x-cloak>
                                    <div @click.away="showModal = false"
                                        class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                                        <h3 class="text-lg font-bold mb-4">Unggah Surat Keterangan</h3>
                                        <p class="mb-4 text-sm">Anda akan mengirim SK untuk: <strong
                                                class="font-semibold">{{ $arsip->antrian->user->name ?? 'N/A'
                                                }}</strong></p>

                                        <form
                                            action="{{ route('admin-instansi.arsip-pkl.store-sk', $arsip->id_penempatan) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div>
                                                <label for="file_sk_{{ $arsip->id_penempatan }}"
                                                    class="block mb-1 text-sm font-medium">Pilih File SK
                                                    (PDF/DOCX)</label>
                                                <input type="file" name="file_sk"
                                                    id="file_sk_{{ $arsip->id_penempatan }}"
                                                    class="w-full p-2 border rounded-lg" required>
                                            </div>
                                            <div class="mt-6 flex justify-end gap-4">
                                                <button type="button" @click="showModal = false"
                                                    class="bg-gray-200 py-2 px-4 rounded-lg">Batal</button>
                                                <button type="submit"
                                                    class="bg-green-500 text-white py-2 px-4 rounded-lg">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 px-6 text-center text-gray-500">
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