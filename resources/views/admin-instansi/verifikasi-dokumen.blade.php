<x-admin-instansi-layout>
    <div class="p-6 md:p-10" x-data="{ showModal: false, selectedDokumen: null, selectedAntrian: null }">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Verifikasi Dokumen Mahasiswa</h1>

        <div class="bg-white p-8 rounded-xl shadow-lg border">
            <h2 class="text-xl font-semibold mb-4">Daftar Dokumen Masuk</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 text-left">Nama Mahasiswa</th>
                            <th class="py-3 px-6 text-left">Dokumen</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarDokumen as $antrian)
                            <tr class="border-b">
                                <td class="py-4 px-6">{{ $antrian->nama_lengkap }}</td>
                                <td class="py-4 px-6">
                                    @if($antrian->dokumen)
                                        <div class="flex flex-col space-y-1">
                                            <a href="{{ asset('storage/' . $antrian->dokumen->file_surat_pengantar) }}" target="_blank" class="text-blue-600 hover:underline text-sm">Lihat Surat Pengantar</a>
                                            <a href="{{ asset('storage/' . $antrian->dokumen->file_surat_bankesbangpol) }}" target="_blank" class="text-blue-600 hover:underline text-sm">Lihat Surat Bankesbangpol</a>
                                        </div>
                                    @else
                                        <span class="text-red-500 text-sm">Data Dokumen Error</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($antrian->dokumen)
                                    <div class="flex justify-center gap-2">
                                        <!-- Tombol Terima -->
                                        <form method="POST" action="{{ route('admin-instansi.verifikasi-dokumen.update', $antrian->dokumen) }}" onsubmit="return confirm('Anda yakin dokumen ini sudah lengkap?');">
                                            @csrf
                                            <input type="hidden" name="action" value="terima">
                                            <button type="submit" class="bg-green-500 text-white font-semibold py-1 px-3 rounded-lg text-sm">Terima</button>
                                        </form>

                                        <!-- Tombol Revisi -->
                                        <button @click="showModal = true; selectedDokumen = {{ $antrian->dokumen }}; selectedAntrian = {{ $antrian }}" class="bg-yellow-500 text-white font-semibold py-1 px-3 rounded-lg text-sm">Revisi</button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 px-6 text-center text-gray-500">
                                    Tidak ada dokumen yang perlu diverifikasi saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal untuk Catatan Revisi -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
            <div @click.away="showModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">Catatan Revisi</h3>
                <p class="mb-4 text-sm">Anda meminta revisi untuk dokumen milik <strong x-text="selectedAntrian ? selectedAntrian.nama_lengkap : ''"></strong>.</p>
                <form :action="`/admin-instansi/verifikasi-dokumen/${selectedDokumen ? selectedDokumen.id_dokumen : ''}`" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="revisi">
                    <div>
                        <label for="catatan_revisi" class="block mb-1">Tuliskan apa yang perlu diperbaiki:</label>
                        <textarea name="catatan_revisi" rows="4" class="w-full p-2 border rounded-lg" required></textarea>
                    </div>
                    <div class="mt-6 flex justify-end gap-4">
                        <button type="button" @click="showModal = false" class="bg-gray-200 py-2 px-4 rounded-lg">Batal</button>
                        <button type="submit" class="bg-yellow-500 text-white py-2 px-4 rounded-lg">Kirim Revisi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-instansi-layout>