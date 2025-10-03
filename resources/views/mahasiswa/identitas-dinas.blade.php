<x-mahasiswa-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Identitas Dinas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Informasi Dinas -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        Informasi Dinas
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Berikut adalah informasi mengenai instansi tempat pelaksanaan PKL.
                    </p>
                    <div class="mt-6 space-y-4">
                        <div>
                            <span class="font-bold text-gray-700">Nama Instansi:</span>
                            <p class="text-gray-800">Dinas Komunikasi dan Informatika Kabupaten Garut</p>
                        </div>
                        <div>
                            <span class="font-bold text-gray-700">Alamat:</span>
                            <p class="text-gray-800">Jl. Pembangunan No.182, Sukagalih, Kec. Tarogong Kidul, Kabupaten Garut, Jawa Barat 44151</p>
                        </div>
                        <div>
                            <span class="font-bold text-gray-700">Email:</span>
                            <p class="text-gray-800">diskominfo@garutkab.go.id</p>
                        </div>
                        <div>
                            <span class="font-bold text-gray-700">Website:</span>
                            <a href="https://diskominfo.garutkab.go.id/" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                https://diskominfo.garutkab.go.id/
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Bidang -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900">
                    Daftar Bidang yang Tersedia
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Berikut adalah daftar bidang atau unit kerja yang tersedia untuk kegiatan PKL.
                </p>
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Bidang
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($bidangs as $index => $bidang)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bidang->nama_bidang }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada data bidang yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-mahasiswa-layout>