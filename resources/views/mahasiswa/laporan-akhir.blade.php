<x-mahasiswa-layout>
    <div class="space-y-6 p-6 md:p-10">

        <!-- Header Halaman -->
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
            <!-- Ikon Buku/Dokumen -->
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.206 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.794 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.794 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.206 18 16.5 18s-3.332.477-4.5 1.253"></path></svg>
            Laporan Akhir
        </h1>

        <!-- Form Card -->
        <div class="bg-white p-6 md:p-10 rounded-xl shadow-lg border border-gray-100">
            <h2 class="text-xl font-semibold mb-8 text-center text-gray-700">Unggah Laporan Akhir Anda Dibawah Ini</h2>

            <!-- Formulir -->
            <form class="space-y-8 max-w-xl mx-auto" enctype="multipart/form-data">

                <!-- Input Judul Laporan Akhir -->
                <div>
                    <input type="text" name="judul_laporan" id="judul_laporan" placeholder="Judul Laporan Akhir" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 shadow-sm"
                        required>
                </div>

                <!-- Input Deskripsi Singkat -->
                <div>
                    <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="3" placeholder="Deskripsi Singkat"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 shadow-sm"
                        required></textarea>
                </div>

                <!-- Dokumen: Upload File Laporan -->
                <div class="space-y-3">
                    <label for="file_laporan" class="block text-lg font-medium text-gray-700">Upload File Laporan</label>
                    <div class="flex items-center space-x-4 border border-gray-300 rounded-lg shadow-sm bg-gray-50 p-3">
                        
                        <!-- Custom Input File (Trik Tailwind) -->
                        <label for="file_laporan_akhir_input"
                            class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 shadow-md focus:outline-none focus:ring-4 focus:ring-blue-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Pilih File
                        </label>
                        
                        <!-- Wrapper untuk Nama File & Tombol Batal -->
                        <div class="flex items-center justify-between flex-1 min-w-0">
                            <!-- Teks untuk menampilkan nama file yang dipilih -->
                            <span id="filename_akhir" class="text-gray-500 truncate max-w-xs">
                                Belum ada file yang dipilih (.pdf, .docx)
                            </span>
                            
                            <!-- Tombol Batal -->
                            <button type="button" onclick="resetFile('file_laporan_akhir_input', 'filename_akhir', 'Belum ada file yang dipilih (.pdf, .docx)')"
                                class="text-red-500 hover:text-red-700 transition focus:outline-none p-1 rounded-full hover:bg-red-100" title="Batalkan File">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Input File tersembunyi -->
                        <input type="file" name="file_laporan_akhir" id="file_laporan_akhir_input" accept=".pdf, .docx" class="hidden" required 
                            onchange="document.getElementById('filename_akhir').textContent = this.files[0].name">
                    </div>
                </div>
                
                <!-- Tombol Serahkan -->
                <div class="pt-6 flex justify-center">
                    <button type="button"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-purple-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Serahkan
                    </button>
                </div>
            </form>

        </div>
    </div>
    
    <!-- SCRIPT JAVASCRIPT UNTUK MERESET FILE INPUT -->
    <!-- Ini memastikan function resetFile() tersedia di halaman ini -->
    <script>
        function resetFile(fileInputId, filenameDisplayId, defaultText) {
            const oldInput = document.getElementById(fileInputId);
            
            // 1. Membuat duplikat elemen input file
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = oldInput.name;
            newInput.id = oldInput.id;
            newInput.accept = oldInput.accept;
            newInput.className = oldInput.className;
            newInput.required = oldInput.required;
            newInput.onchange = oldInput.onchange; // Menyalin fungsi onchange

            // 2. Mengganti elemen lama dengan elemen baru (Ini yang mereset file)
            oldInput.parentNode.replaceChild(newInput, oldInput);

            // 3. Mereset teks nama file
            document.getElementById(filenameDisplayId).textContent = defaultText;
        }
    </script>
</x-mahasiswa-layout>
