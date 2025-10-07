<x-admin-layout>
    <div class="p-6 md:p-10" x-data="{ showModal: false, selectedAntrian: null }">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Penempatan Mahasiswa PKL</h1>

        <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border">
            <h3 class="font-bold text-xl mb-4 text-gray-900">Daftar Mahasiswa Untuk Penempatan Bidang</h3>

            @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm">
                {{ session('error') }}
            </div>
            @endif

            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">No</th>
                            <th scope="col" class="py-3 px-6">Nama Mahasiswa</th>
                            <th scope="col" class="py-3 px-6">NIM</th>
                            <th scope="col" class="py-3 px-6">Jurusan</th>
                            <th scope="col" class="py-3 px-6">Kampus</th>
                            <th scope="col" class="py-3 px-6">Status Dokumen</th>
                            <th scope="col" class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswaSiap as $index => $mhs)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ $mhs->user->name }}
                            </td>
                            <td class="py-4 px-6">{{ $mhs->nim }}</td>
                            <td class="py-4 px-6">{{ $mhs->jurusan }}</td>
                            <td class="py-4 px-6">{{ $mhs->nama_kampus }}</td>
                            <td class="py-4 px-6 text-green-600 font-semibold">Dokumen Lengkap</td>
                            <td class="py-4 px-6 text-center">
                                <button @click="showModal = true; selectedAntrian = {{ $mhs->load('user')->toJson() }}"
                                    class="font-medium text-blue-600 hover:underline">[Penempatan]</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada mahasiswa yang siap untuk
                                ditempatkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Detail Penempatan -->
        <div x-show="showModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full"
            style="z-index: 1000;">
            <div @click.away="showModal = false"
                class="relative top-10 mx-auto p-5 border w-full max-w-md shadow-lg rounded-xl bg-white">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-xl leading-6 font-bold text-gray-900">Detail Penempatan</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin-instansi.penempatan.store') }}" x-show="selectedAntrian">
                    @csrf
                    <input type="hidden" name="antrian_id" :value="selectedAntrian.id_antrian">

                    <div class="mt-2 text-sm text-gray-600 space-y-2">
                        <p><span class="font-bold text-gray-800">Nama Lengkap:</span> <span
                                x-text="selectedAntrian.user.name"></span></p>
                        <p><span class="font-bold text-gray-800">Jurusan:</span> <span
                                x-text="selectedAntrian.jurusan"></span></p>
                        <p><span class="font-bold text-gray-800">Kampus:</span> <span
                                x-text="selectedAntrian.nama_kampus"></span></p>
                        <p><span class="font-bold text-gray-800">No HP:</span> <span
                                x-text="selectedAntrian.kontak_aktif || '-'"></span></p>
                        <p><span class="font-bold text-gray-800">Email:</span> <span
                                x-text="selectedAntrian.user.email"></span></p>

                        <div class="pt-3 border-t mt-3 space-y-3">
                            <p class="font-bold text-gray-800 text-lg">[ Penempatan ]</p>
                            <div>
                                <label for="id_bidang" class="block text-sm font-medium text-gray-700">Bidang / Unit
                                    Kerja</label>
                                <select id="id_bidang" name="id_bidang"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm"
                                    required>
                                    <option value="">-- Pilih Bidang --</option>
                                    @foreach($daftarBidang as $bidang)
                                    <option value="{{ $bidang->id }}">{{ $bidang->nama_bidang }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <p><span class="font-bold text-gray-800">Tanggal Mulai:</span> <span
                                    x-text="new Date(selectedAntrian.tgl_mulai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span>
                            </p>
                            <p><span class="font-bold text-gray-800">Tanggal Berakhir:</span> <span
                                    x-text="new Date(selectedAntrian.tgl_berakhir).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span>
                            </p>

                            {{-- PERBAIKAN: Input nama pembimbing sudah dihapus dari sini --}}

                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-blue-600 text-white text-base font-bold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>