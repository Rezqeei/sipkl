<x-admin-bidang-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">Monitoring Laporan Akhir Mahasiswa</h1>

                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Nama Mahasiswa</th>
                                    <th scope="col" class="py-3 px-6">Judul Laporan</th>
                                    <th scope="col" class="py-3 px-6">Tanggal Unggah</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                    <th scope="col" class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporanAkhir as $laporan)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-4 px-6">{{ $laporan->penempatan->antrian->user->name }}</td>
                                    <td class="py-4 px-6">{{ $laporan->judul ?? 'Tidak ada judul' }}</td>
                                    <td class="py-4 px-6">{{ $laporan->created_at->format('d M Y, H:i') }}</td>
                                    <td class="py-4 px-6">
                                        @if ($laporan->status_verifikasi == 'Disetujui')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                        @elseif ($laporan->status_verifikasi == 'Ditolak')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu
                                            Verifikasi</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'detail-laporan-{{ $laporan->id_laporan_akhir }}')"
                                            class="font-medium text-blue-600 hover:underline">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-6 text-center text-gray-500">
                                        Belum ada laporan akhir yang diunggah.
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

    @foreach ($laporanAkhir as $laporan)
    <x-modal name="detail-laporan-{{ $laporan->id_laporan_akhir }}" focusable>
        <div x-data="{ action: '{{ $laporan->status_verifikasi == 'Ditolak' ? 'Ditolak' : 'Disetujui' }}' }">
            <form method="post"
                action="{{ route('admin-bidang.monitoring.laporan.akhir.verify', $laporan->id_laporan_akhir) }}"
                class="p-6">
                @csrf
                @method('PATCH')

                <h2 class="text-lg font-medium text-gray-900">
                    Detail Laporan Akhir
                </h2>

                <div class="mt-4 space-y-2 text-sm text-gray-600 border-t border-b py-4">
                    <p><strong>Nama Mahasiswa:</strong> {{ $laporan->penempatan->antrian->user->name }}</p>
                    <p><strong>NIM:</strong> {{ $laporan->penempatan->antrian->nim }}</p>
                    <p><strong>Judul Laporan:</strong> {{ $laporan->judul }}</p>
                    <p><strong>Deskripsi:</strong> {{ $laporan->deskripsi_singkat }}</p>
                    <p><strong>File:</strong>
                        <a href="{{ route('admin-bidang.monitoring.laporan.akhir.download', $laporan->id_laporan_akhir) }}"
                            target="_blank" class="text-blue-600 hover:underline">
                            Lihat/Unduh Laporan
                        </a>
                    </p>
                    @if($laporan->status_verifikasi == 'Ditolak' && $laporan->feedback)
                    <p class="text-red-600"><strong>Alasan Ditolak Sebelumnya:</strong> {{ $laporan->feedback }}</p>
                    @endif
                </div>

                <div class="mt-6">
                    <h3 class="font-medium text-gray-800">Aksi Verifikasi</h3>
                    <div class="mt-2 flex gap-6">
                        <label class="flex items-center">
                            <input type="radio" name="status_verifikasi" value="Disetujui" x-model="action"
                                class="form-radio text-green-600 h-4 w-4">
                            <span class="ml-2 text-sm text-gray-700">Setujui Laporan</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status_verifikasi" value="Ditolak" x-model="action"
                                class="form-radio text-red-600 h-4 w-4">
                            <span class="ml-2 text-sm text-gray-700">Tolak Laporan</span>
                        </label>
                    </div>

                    <div x-show="action === 'Ditolak'" class="mt-4" x-cloak>
                        <label for="feedback-{{ $laporan->id_laporan_akhir }}"
                            class="block text-sm font-medium text-gray-700">Alasan Penolakan (Wajib diisi jika
                            ditolak)</label>
                        <textarea name="feedback" id="feedback-{{ $laporan->id_laporan_akhir }}" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :required="action === 'Ditolak'">{{ $laporan->feedback }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Batal
                    </x-secondary-button>

                    <button type="submit"
                        class="ml-3 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2"
                        :class="{ 'bg-green-600 hover:bg-green-700 focus:ring-green-500': action === 'Disetujui', 'bg-red-600 hover:bg-red-700 focus:ring-red-500': action === 'Ditolak' }">
                        Kirim Keputusan
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
    @endforeach
</x-admin-bidang-layout>