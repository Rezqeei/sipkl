<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Admin Bidang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-xl text-gray-900">Daftar Admin Bidang</h3>
                    <!-- Tombol Tambah di Pojok Kanan Atas Tabel -->
                    <button id="openFormModalBtn" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-md hover:bg-blue-700 transition duration-150">
                        Tambah Admin Bidang
                    </button>
                </div>

                <!-- Tabel Daftar Admin Bidang -->
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 px-6">No</th>
                                <th scope="col" class="py-3 px-6">Nama Admin Bidang</th>
                                <th scope="col" class="py-3 px-6">Email</th>
                                <th scope="col" class="py-3 px-6">Bidang</th>
                                <th scope="col" class="py-3 px-6">Status</th>
                                <th scope="col" class="py-3 px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contoh Data 1 -->
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6">1</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">Andi</td>
                                <td class="py-4 px-6">andi@example.com</td>
                                <td class="py-4 px-6">TI</td>
                                <td class="py-4 px-6 text-green-600 font-semibold">Aktif</td>
                                <td class="py-4 px-6 space-x-2 whitespace-nowrap">
                                    <a href="#" class="font-medium text-blue-600 hover:underline edit-btn">[Edit]</a>
                                    <a href="#" class="font-medium text-red-600 hover:underline delete-btn">[Hapus]</a>
                                </td>
                            </tr>
                             <!-- Contoh Data 2 -->
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="py-4 px-6">2</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">Siti</td>
                                <td class="py-4 px-6">siti@example.com</td>
                                <td class="py-4 px-6">Statistik</td>
                                <td class="py-4 px-6 text-green-600 font-semibold">Aktif</td>
                                <td class="py-4 px-6 space-x-2 whitespace-nowrap">
                                    <a href="#" class="font-medium text-blue-600 hover:underline edit-btn">[Edit]</a>
                                    <a href="#" class="font-medium text-red-600 hover:underline delete-btn">[Hapus]</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                
                <!-- Modal Form Tambah / Edit Admin Bidang -->
                <div id="formModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 1000;">
                    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-xl bg-white">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 id="modalTitle" class="text-xl leading-6 font-bold text-gray-900">Form Tambah / Edit Admin Bidang</h3>
                            <button id="closeFormModalBtn" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <form id="adminBidangForm" class="mt-4 space-y-4">
                            <!-- Nama Lengkap -->
                            <div>
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Admin Bidang" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" placeholder="Email" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2">
                            </div>
                            
                            <!-- Kata Sandi -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                                <input type="password" id="password" name="password" placeholder="Kata Sandi (Isi jika ingin mengubah)" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2">
                            </div>

                            <!-- Bidang/Unit Kerja Dropdown -->
                            <div>
                                <label for="bidang" class="block text-sm font-medium text-gray-700">Bidang / Unit Kerja</label>
                                <select id="bidang" name="bidang" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
                                    <option value="">-- Pilih Bidang --</option>
                                    <option value="Aplikasi">Aplikasi</option>
                                    <option value="Infrastruktur">Infrastruktur & Jaringan</option>
                                    <option value="Statistik">Statistik</option>
                                    <!-- Data ini nanti bisa diambil dari database -->
                                </select>
                            </div>
                            
                            <!-- Tombol Simpan -->
                            <div class="mt-6 pt-4 border-t">
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-base font-bold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formModal = document.getElementById('formModal');
            const modalTitle = document.getElementById('modalTitle');
            const openFormModalBtn = document.getElementById('openFormModalBtn');
            const closeFormModalBtn = document.getElementById('closeFormModalBtn');
            const editBtns = document.querySelectorAll('.edit-btn');
            const adminBidangForm = document.getElementById('adminBidangForm');

            // 1. Fungsi Umum untuk Membuka Modal
            function openModal(isEdit = false) {
                if (isEdit) {
                    modalTitle.textContent = 'Form Edit Admin Bidang';
                    // Di sini nanti bisa ditambahkan logic untuk mengisi data form
                } else {
                    modalTitle.textContent = 'Form Tambah Admin Bidang';
                    adminBidangForm.reset(); // Kosongkan form saat mode tambah
                }
                formModal.classList.remove('hidden');
            }

            // 2. Event Listener untuk Tombol "Tambah Admin Bidang"
            openFormModalBtn.addEventListener('click', function() {
                openModal(false);
            });

            // 3. Event Listener untuk Tombol "Edit"
            editBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    openModal(true);
                });
            });

            // 4. Fungsi Menutup Modal
            closeFormModalBtn.addEventListener('click', function() {
                formModal.classList.add('hidden');
            });

            // 5. Tutup modal ketika klik di luar area modal
            formModal.addEventListener('click', function(e) {
                if (e.target === formModal) {
                    formModal.classList.add('hidden');
                }
            });

            // 6. Event Listener untuk Tombol "Hapus" (Hanya notifikasi, butuh konfirmasi)
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Implementasi custom modal konfirmasi di sini
                    console.log('Log: Logic untuk konfirmasi hapus akan diimplementasikan di sini.');
                    alert('Log: Ini harusnya adalah modal konfirmasi Hapus, bukan alert().'); 
                });
            });
        });
    </script>
    @endpush

</x-admin-layout>
