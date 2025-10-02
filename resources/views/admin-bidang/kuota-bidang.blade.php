<x-admin-bidang-layout>
    <div class="p-6 md:p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Informasi Kuota Bidang</h1>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @elseif(!$bidang)
            {{-- Tampilan jika admin belum terhubung ke bidang --}}
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Perhatian!</strong>
                <span class="block sm:inline">Akun Anda belum terhubung dengan Bidang manapun. Silakan hubungi Admin Instansi.</span>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kolom Informasi & Form -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Informasi Bidang -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Informasi Bidang</h2>
                        <div class="space-y-3 text-gray-600">
                            <p><strong>Nama Bidang:</strong><br> {{ $bidang->nama_bidang }}</p>
                            <p><strong>Kuota Maksimal:</strong><br> <span class="text-2xl font-bold text-blue-600">{{ $bidang->kuota_maksimal }} Orang</span></p>
                            <p><strong>Mahasiswa Aktif:</strong><br> <span class="text-2xl font-bold text-green-600">{{ $bidang->penempatan->sum('antrian.jumlah_orang') }} Orang</span></p>
                            <p><strong>Sisa Kuota:</strong><br> <span class="text-2xl font-bold text-yellow-600">{{ $bidang->sisa_kuota }} Orang</span></p>
                        </div>
                    </div>
                    <!-- Form Edit Kuota -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Form Edit Kuota</h2>
                        <form method="POST" action="{{ route('admin-bidang.kuota-bidang.update') }}">
                            @csrf
                            <div>
                                <label for="kuota_maksimal" class="block font-medium">Kuota Maksimal Baru</label>
                                <input type="number" name="kuota_maksimal" id="kuota_maksimal" value="{{ $bidang->kuota_maksimal }}" class="w-full mt-1 p-2 border rounded-lg" min="0" required>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Kolom Daftar Mahasiswa Aktif -->
                <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg border">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Daftar Mahasiswa Aktif di Bidang Ini</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4 text-left">Nama Mahasiswa</th>
                                    <th class="py-3 px-4 text-left">Asal Kampus</th>
                                    <th class="py-3 px-4 text-left">Periode PKL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bidang->penempatan as $penempatan)
                                    <tr class="border-b">
                                        <td class="py-4 px-4">{{ $penempatan->antrian->nama_lengkap }}</td>
                                        <td class="py-4 px-4">{{ $penempatan->antrian->nama_kampus }}</td>
                                        <td class="py-4 px-4">{{ \Carbon\Carbon::parse($penempatan->antrian->tgl_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($penempatan->antrian->tgl_berakhir)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="py-4 px-4 text-center text-gray-500">Tidak ada mahasiswa aktif.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-admin-bidang-layout>