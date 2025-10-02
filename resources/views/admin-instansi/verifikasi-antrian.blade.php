<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verifikasi Antrian Mahasiswa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="font-bold text-xl mb-4 text-gray-900">Daftar Pengajuan Antrian</h3>

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 px-6">No</th>
                                <th scope="col" class="py-3 px-6">Nama Mahasiswa</th>
                                <th scope="col" class="py-3 px-6">Nim</th>
                                <th scope="col" class="py-3 px-6">Jurusan</th>
                                <th scope="col" class="py-3 px-6">Kampus</th>
                                <th scope="col" class="py-3 px-6">Status</th>
                                <th scope="col" class="py-3 px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6">1</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">Andi</td>
                                <td class="py-4 px-6">2270001</td>
                                <td class="py-4 px-6">TI</td>
                                <td class="py-4 px-6">Unv</td>
                                <td class="py-4 px-6">Menunggu</td>
                                <td class="py-4 px-6">
                                    <a href="#" id="openDetailModal" class="font-medium text-blue-600 hover:underline">[Detail]</a>
                                </td>
                            </tr>
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="py-4 px-6">2</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">Siti</td>
                                <td class="py-4 px-6">23000003</td>
                                <td class="py-4 px-6">Statistik</td>
                                <td class="py-4 px-6">Unv A</td>
                                <td class="py-4 px-6">Menunggu</td>
                                <td class="py-4 px-6">
                                     <a href="#" class="font-medium text-blue-600 hover:underline">[Detail]</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 1000;">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Pengajuan Antrian</h3>
                            <button id="closeDetailModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="mt-2 text-sm text-gray-500">
                            <p><span class="font-semibold text-gray-700">Nama Lengkap:</span> Muhammad Andi</p>
                            <p><span class="font-semibold text-gray-700">Nim:</span> 2270001</p>
                            <p><span class="font-semibold text-gray-700">Jurusan:</span> Teknik Informatika</p>
                            <p><span class="font-semibold text-gray-700">Kampus:</span> Universitas ABC</p>
                            <p><span class="font-semibold text-gray-700">No HP:</span> 08123456789</p>
                            <p><span class="font-semibold text-gray-700">Email:</span> muhammad@email.com</p>
                            <p><span class="font-semibold text-gray-700">Alamat:</span> Jl. Kenangan Indah No. 123</p>
                            <p><span class="font-semibold text-gray-700">Tanggal Mulai:</span> 24 September 2023</p>
                            <p><span class="font-semibold text-gray-700">Tanggal Berakhir:</span> 25 September 2023</p>
                            <p><span class="font-semibold text-gray-700">Jumlah Orang:</span> 1 Orang</p>
                            <p class="mt-3"><span class="font-semibold text-gray-700">Catatan untuk mahasiswa:</span> -</p>
                        </div>
                        <div class="mt-4 flex justify-end space-x-3">
                            <button class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                Tolak
                            </button>
                            <button class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                                Terima
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openDetailModalBtn = document.getElementById('openDetailModal');
            const closeDetailModalBtn = document.getElementById('closeDetailModal');
            const detailModal = document.getElementById('detailModal');

            if (openDetailModalBtn) {
                openDetailModalBtn.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah link lompat ke atas
                    detailModal.classList.remove('hidden');
                });
            }

            if (closeDetailModalBtn) {
                closeDetailModalBtn.addEventListener('click', function() {
                    detailModal.classList.add('hidden');
                });
            }

            // Opsional: Tutup modal ketika klik di luar area modal
            if (detailModal) {
                detailModal.addEventListener('click', function(e) {
                    if (e.target === detailModal) {
                        detailModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    @endpush

</x-admin-layout>