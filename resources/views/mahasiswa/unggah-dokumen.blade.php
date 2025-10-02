<x-mahasiswa-layout>
    <div class="space-y-6 p-6 md:p-10">
        <!-- Header Halaman -->
        <h1 class="text-3xl font-bold text-gray-800">Unggah Dokumen</h1>

        <!-- Form Card -->
        <div class="bg-white p-6 md:p-10 rounded-xl shadow-lg border border-gray-100">
            <h2 class="text-xl font-semibold mb-8 text-center text-gray-700">Unggah Dokumen Anda Dibawah Ini</h2>

            <form method="POST" action="{{ route('mahasiswa.unggah.dokumen.store') }}" class="space-y-8 max-w-xl mx-auto" enctype="multipart/form-data">
                @csrf
                {{-- Kirim ID Antrian secara tersembunyi --}}
                <input type="hidden" name="antrian_id" value="{{ $antrian->id_antrian }}">

                <!-- Dokumen 1: Surat Pengantar -->
                <div class="space-y-3">
                    <label class="block text-lg font-medium text-gray-700">Surat Pengantar</label>
                    <div class="flex items-center space-x-4 border rounded-lg p-3 @error('surat_pengantar') border-red-500 @enderror">
                        <label for="surat_pengantar" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                            Pilih File
                        </label>
                        <div class="flex items-center justify-between flex-1 min-w-0">
                            <span id="filename_pengantar" class="text-gray-500 truncate">Belum ada file (.pdf, .docx)</span>
                            <button type="button" onclick="resetFile('surat_pengantar', 'filename_pengantar')" class="text-red-500 hover:text-red-700 p-1">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <input type="file" name="surat_pengantar" id="surat_pengantar" class="hidden" required onchange="updateFilename('surat_pengantar', 'filename_pengantar')">
                    </div>
                    @error('surat_pengantar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Dokumen 2: Surat Bankesbangpol -->
                <div class="space-y-3">
                    <label class="block text-lg font-medium text-gray-700">Surat Balasan Bankesbangpol</label>
                     <div class="flex items-center space-x-4 border rounded-lg p-3 @error('surat_bankesbangpol') border-red-500 @enderror">
                        <label for="surat_bankesbangpol" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                            Pilih File
                        </label>
                        <div class="flex items-center justify-between flex-1 min-w-0">
                            <span id="filename_bankesbangpol" class="text-gray-500 truncate">Belum ada file (.pdf, .docx)</span>
                             <button type="button" onclick="resetFile('surat_bankesbangpol', 'filename_bankesbangpol')" class="text-red-500 hover:text-red-700 p-1">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <input type="file" name="surat_bankesbangpol" id="surat_bankesbangpol" class="hidden" required onchange="updateFilename('surat_bankesbangpol', 'filename_bankesbangpol')">
                    </div>
                    @error('surat_bankesbangpol')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <!-- Tombol Serahkan -->
                <div class="pt-6 flex justify-center">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-lg">
                        Serahkan Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script JavaScript untuk interaksi form -->
    <script>
        function updateFilename(inputId, displayId) {
            const input = document.getElementById(inputId);
            const display = document.getElementById(displayId);
            if (input.files.length > 0) {
                display.textContent = input.files[0].name;
            } else {
                display.textContent = 'Belum ada file (.pdf, .docx)';
            }
        }

        function resetFile(inputId, displayId) {
            document.getElementById(inputId).value = '';
            updateFilename(inputId, displayId);
        }
    </script>
</x-mahasiswa-layout>
