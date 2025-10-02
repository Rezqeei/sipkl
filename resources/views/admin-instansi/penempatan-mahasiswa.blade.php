<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Penempatan Mahasiswa PKL
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="font-bold text-xl mb-4 text-gray-900">Daftar Mahasiswa Untuk Penempatan Bidang</h3>

                <!-- Tabel Daftar Mahasiswa -->
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 px-6">No</th>
                                <th scope="col" class="py-3 px-6">Nama Mahasiswa</th>
                                <th scope="col" class="py-3 px-6">Nim</th>
                                <th scope="col" class="py-3 px-6">Jurusan</th>
                                <th scope="col" class="py-3 px-6">Kampus</th>
                                <th scope="col" class="py-3 px-6">Status Dokumen</th>
                                <th scope="col" class="py-3 px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contoh Data 1 (Status Valid/Siap Ditempatkan) -->
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6">1</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">Andi</td>
                                <td class="py-4 px-6">2270001</td>
                                <td class="py-4 px-6">TI</td>
                                <td class="py-4 px-6">Unv</td>
                                <td class="py-4 px-6 text-green-600 font-semibold">Valid</td>
                                <td class="py-4 px-6">
                                    <a href="#" id="openPenempatanModal" class="font-medium text-blue-600 hover:underline">[Penempatan]</a>
                                </td>
                            </tr>
                            <!-- Contoh Data 2 (Status Valid/Siap Ditempatkan) -->
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="py-4 px-6">2</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">Siti</td>
                                <td class="py-4 px-6">23000003</td>
                                <td class="py-4 px-6">Statistik</td>
                                <td class="py-4 px-6">Unv A</td>
                                <td class="py-4 px-6 text-green-600 font-semibold">Valid</td>
                                <td class="py-4 px-6">
                                     <a href="#" class="font-medium text-blue-600 hover:underline">[Penempatan]</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                
                <!-- Modal Detail Penempatan -->
                <div id="penempatanModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 1000;">
                    <div class="relative top-10 mx-auto p-5 border w-full max-w-sm sm:max-w-md shadow-lg rounded-xl bg-white">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-xl leading-6 font-bold text-gray-900">Detail Penempatan</h3>
                            <button id="closePenempatanModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <div class="mt-2 text-sm text-gray-600 space-y-2">
                            <!-- Informasi Mahasiswa -->
                            <p><span class="font-bold text-gray-800">Nama Lengkap:</span> Muhammad Andi</p>
                            <p><span class="font-bold text-gray-800">Jurusan:</span> Teknik Informatika</p>
                            <p><span class="font-bold text-gray-800">Kampus:</span> Univ</p>
                            <p><span class="font-bold text-gray-800">No HP:</span> 08123456789</p>
                            <p><span class="font-bold text-gray-800">Email:</span> example@gmail.com</p>
                            <p><span class="font-bold text-gray-800">Status Dokumen:</span> <span class="text-green-600 font-semibold">Valid</span></p>
                            
                            <!-- Section Penempatan (Form) -->
                            <div class="pt-3 border-t mt-3 space-y-3">
                                <p class="font-bold text-gray-800 text-lg">[ Penempatan ]</p>

                                <!-- Bidang/Unit Kerja Dropdown -->
                                <div>
                                    <label for="bidang" class="block text-sm font-medium text-gray-700">Bidang / Unit Kerja</label>
                                    <select id="bidang" name="bidang" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
                                        <option>-- Pilih Bidang --</option>
                                        <option>Aplikasi</option>
                                        <option>Infrastruktur & Jaringan</option>
                                        <option>Statistik</option>
                                    </select>
                                </div>
                                
                                <!-- Tanggal Mulai dan Berakhir (ReadOnly Info) -->
                                <p><span class="font-bold text-gray-800">Tanggal Mulai:</span> 24 September 2025</p>
                                <p><span class="font-bold text-gray-800">Tanggal Berakhir:</span> 25 Desember 2025</p>

                                <!-- Nama Pembimbing Input -->
                                <div>
                                    <label for="pembimbing" class="block text-sm font-medium text-gray-700">Nama Pembimbing</label>
                                    <input type="text" id="pembimbing" name="pembimbing" placeholder="Misal: Budi Santoso" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-6 flex justify-end">
                            <button class="w-full px-4 py-2 bg-blue-600 text-white text-base font-bold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Simpan
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
            const openPenempatanModalBtns = document.querySelectorAll('[id^="openPenempatanModal"]');
            const closePenempatanModalBtn = document.getElementById('closePenempatanModal');
            const penempatanModal = document.getElementById('penempatanModal');

            // Fungsi untuk membuka modal
            openPenempatanModalBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    penempatanModal.classList.remove('hidden');
                });
            });

            // Menutup modal
            if (closePenempatanModalBtn) {
                closePenempatanModalBtn.addEventListener('click', function() {
                    penempatanModal.classList.add('hidden');
                });
            }

            // Tutup modal ketika klik di luar area modal
            if (penempatanModal) {
                penempatanModal.addEventListener('click', function(e) {
                    if (e.target === penempatanModal) {
                        penempatanModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    @endpush

</x-admin-layout>
