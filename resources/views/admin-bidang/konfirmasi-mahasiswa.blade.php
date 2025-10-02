<x-admin-bidang-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Konfirmasi Mahasiswa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="font-bold text-xl mb-4 text-gray-900">Daftar Mahasiswa Dari Admin Instansi</h3>

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
                            <!-- Contoh Data 1 (Nanti akan diisi oleh Looping PHP dari Controller) -->
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6">1</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">Andi</td>
                                <td class="py-4 px-6">2270001</td>
                                <td class="py-4 px-6">TI</td>
                                <td class="py-4 px-6">Unv</td>
                                <td class="py-4 px-6 text-green-600 font-semibold">Valid</td>
                                <td class="py-4 px-6">
                                    <a href="#" id="openKonfirmasiModal" class="font-medium text-blue-600 hover:underline">[Detail]</a>
                                </td>
                            </tr>
                            <!-- Contoh Data 2 -->
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="py-4 px-6">2</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">Siti</td>
                                <td class="py-4 px-6">23000003</td>
                                <td class="py-4 px-6">Statistik</td>
                                <td class="py-4 px-6">Unv B</td>
                                <td class="py-4 px-6 text-green-600 font-semibold">Valid</td>
                                <td class="py-4 px-6">
                                     <a href="#" class="font-medium text-blue-600 hover:underline">[Detail]</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                
                <!-- Modal Detail Konfirmasi Mahasiswa -->
                <div id="konfirmasiModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 1000;">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Mahasiswa</h3>
                            <button id="closeKonfirmasiModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="mt-2 text-sm text-gray-500 space-y-1">
                            
                            <!-- Detail Mahasiswa -->
                            <p><span class="font-semibold text-gray-700">Nama Lengkap:</span> Muhammad Andi</p>
                            <p><span class="font-semibold text-gray-700">Nim:</span> 2270001</p>
                            <p><span class="font-semibold text-gray-700">Jurusan:</span> Teknik Informatika</p>
                            <p><span class="font-semibold text-gray-700">Kampus:</span> Univ</p>
                            <p><span class="font-semibold text-gray-700">No HP:</span> 08123456789</p>
                            <p><span class="font-semibold text-gray-700">Email:</span> example@gmail.com</p>
                            <p><span class="font-semibold text-gray-700">Periode PKL:</span> 24 September - 25 September 2025</p>
                            <p class="mb-3"><span class="font-semibold text-gray-700">Status Dokumen:</span> <span class="text-green-600">Valid (Sudah diverifikasi Admin Instansi)</span></p>

                            <!-- Dokumen Download -->
                            <p class="font-semibold text-gray-700 pt-2 border-t border-gray-100">Dokumen Terkait:</p>
                            <p>Surat Pengantar Kampus <a href="#" class="text-blue-600 hover:text-blue-800 text-xs font-semibold ml-1">[Download]</a></p>
                            <p class="mb-3">Surat Berkesanggupan <a href="#" class="text-blue-600 hover:text-blue-800 text-xs font-semibold ml-1">[Download]</a></p>

                            <!-- Pilihan Konfirmasi (Radio Buttons) -->
                            <div class="space-y-2 py-3 border-t border-gray-100">
                                <label class="inline-flex items-center text-gray-700">
                                    <input type="radio" name="konfirmasi_status" value="terima" class="form-radio text-green-500 h-4 w-4">
                                    <span class="ml-2 font-semibold">Terima</span>
                                </label>
                                <label class="inline-flex items-center text-gray-700 ml-4">
                                    <input type="radio" name="konfirmasi_status" value="tolak" class="form-radio text-red-500 h-4 w-4">
                                    <span class="ml-2 font-semibold">Tolak</span>
                                </label>
                            </div>

                            <!-- Input Alasan Penolakan (Tersembunyi, nanti diatur via JS) -->
                            <div id="alasanPenolakan" class="hidden">
                                <label for="alasan" class="block text-sm font-semibold text-gray-700 mb-1">Alasan Penolakan:</label>
                                <textarea id="alasan" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-2" placeholder="Masukkan alasan penolakan konfirmasi..."></textarea>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-4 flex justify-end">
                            <button class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
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
            const konfirmasiModal = document.getElementById('konfirmasiModal');
            const closeKonfirmasiModalBtn = document.getElementById('closeKonfirmasiModal');
            const radioButtons = document.querySelectorAll('input[name="konfirmasi_status"]');
            const alasanPenolakanDiv = document.getElementById('alasanPenolakan');
            
            // Fungsi untuk membuka modal (kita memilih semua link detail)
            document.querySelectorAll('[id^="openKonfirmasiModal"]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    konfirmasiModal.classList.remove('hidden');
                });
            });

            // Menutup modal
            if (closeKonfirmasiModalBtn) {
                closeKonfirmasiModalBtn.addEventListener('click', function() {
                    konfirmasiModal.classList.add('hidden');
                });
            }

            // Logika menampilkan input Alasan Penolakan
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'tolak') {
                        alasanPenolakanDiv.classList.remove('hidden');
                    } else {
                        alasanPenolakanDiv.classList.add('hidden');
                    }
                });
            });

            // Tutup modal ketika klik di luar area modal
            if (konfirmasiModal) {
                konfirmasiModal.addEventListener('click', function(e) {
                    if (e.target === konfirmasiModal) {
                        konfirmasiModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    @endpush
</x-admin-bidang-layout>
