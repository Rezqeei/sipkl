<x-mahasiswa-layout>
    <div class="space-y-8 p-6 md:p-10">

        <!-- Header Halaman -->
        <h1 class="text-3xl font-bold text-gray-800">Identitas Dinas</h1>

        <!-- Bagian 1: Informasi Dinas (Card) -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Informasi Dinas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
                
                {{-- Data Dinas (Contoh Dummy Data, ganti dengan data dinas yang sebenarnya) --}}
                @php
                    $dinas = [
                        'nama' => 'Dinas Komunikasi dan Informatika',
                        'alamat' => 'Jl. Pembangunan, No. 123',
                        'kontak' => '(021) 123456',
                        'email' => 'diskominfo@gmail.go.id',
                    ];
                @endphp

                <div>
                    <span class="font-bold text-blue-700">Nama Dinas:</span>
                    <p>{{ $dinas['nama'] }}</p>
                </div>
                <div>
                    <span class="font-bold text-blue-700">Alamat:</span>
                    <p>{{ $dinas['alamat'] }}</p>
                </div>
                <div>
                    <span class="font-bold text-blue-700">Kontak:</span>
                    <p>{{ $dinas['kontak'] }}</p>
                </div>
                <div>
                    <span class="font-bold text-blue-700">Email:</span>
                    <p>{{ $dinas['email'] }}</p>
                </div>
                
            </div>
        </div>

        <!-- Pemisah Visual -->
        <div class="h-px bg-gray-200"></div>

        <!-- Bagian 2: Daftar Bidang (Tabel) -->
        <div>
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Daftar Bidang</h2>
            <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-1/12 rounded-tl-xl">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider rounded-tr-xl">
                                Nama Bidang
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        
                        {{-- Data Bidang (Contoh Dummy Data, ganti dengan loop data bidang yang sebenarnya) --}}
                        @php
                            $bidangs = [
                                ['nama' => 'Sistem & Aplikasi Informatika'],
                                ['nama' => 'Pengolahan Data & Statistik'],
                                ['nama' => 'Kehumasan dan Protokol'],
                            ];
                        @endphp
                        
                        @foreach ($bidangs as $index => $bidang)
                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-blue-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/12">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $bidang['nama'] }}
                                </td>
                            </tr>
                        @endforeach

                        @if (empty($bidangs))
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada data bidang yang tersedia.
                                </td>
                            </tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-mahasiswa-layout>
