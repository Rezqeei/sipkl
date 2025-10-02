<x-mahasiswa-layout>
    <div class="space-y-6 p-6 md:p-10">

        <!-- Header Halaman -->
        <h1 class="text-3xl font-bold text-gray-800">Pengajuan Antrian PKL</h1>

        <!-- Form Card -->
        <div class="bg-white p-6 md:p-10 rounded-xl shadow-lg border border-gray-100">
            <h2 class="text-xl font-semibold mb-8 text-center text-gray-700">Isi Form Pengajuan Antrian Dibawah Ini</h2>

            {{-- Formulir yang sudah terhubung ke backend --}}
            <form method="POST" action="{{ route('mahasiswa.pengajuan.store') }}" class="space-y-6 max-w-2xl mx-auto">
                {{-- Token Keamanan Wajib Laravel --}}
                @csrf

                <!-- Input Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block mb-1 text-sm font-medium text-gray-600">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan nama lengkap Anda"
                           value="{{ old('nama_lengkap') }}"
                           class="w-full px-4 py-3 border rounded-lg shadow-sm @error('nama_lengkap') border-red-500 @enderror" required>
                    @error('nama_lengkap')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input NIM -->
                <div>
                    <label for="nim" class="block mb-1 text-sm font-medium text-gray-600">NIM</label>
                    <input type="text" name="nim" id="nim" placeholder="Masukkan NIM Anda"
                           value="{{ old('nim') }}"
                           class="w-full px-4 py-3 border rounded-lg shadow-sm @error('nim') border-red-500 @enderror" required>
                    @error('nim')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Jurusan -->
                <div>
                    <label for="jurusan" class="block mb-1 text-sm font-medium text-gray-600">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" placeholder="Masukkan jurusan Anda"
                           value="{{ old('jurusan') }}"
                           class="w-full px-4 py-3 border rounded-lg shadow-sm @error('jurusan') border-red-500 @enderror" required>
                    @error('jurusan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Nama Kampus -->
                <div>
                    <label for="nama_kampus" class="block mb-1 text-sm font-medium text-gray-600">Nama Kampus</label>
                    <input type="text" name="nama_kampus" id="nama_kampus" placeholder="Masukkan nama kampus Anda"
                           value="{{ old('nama_kampus') }}"
                           class="w-full px-4 py-3 border rounded-lg shadow-sm @error('nama_kampus') border-red-500 @enderror" required>
                    @error('nama_kampus')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Alamat -->
                <div>
                    <label for="alamat" class="block mb-1 text-sm font-medium text-gray-600">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda"
                              class="w-full px-4 py-3 border rounded-lg shadow-sm @error('alamat') border-red-500 @enderror" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Tanggal Mulai -->
                <div>
                    <label for="tgl_mulai" class="block mb-1 text-sm font-medium text-gray-600">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" id="tgl_mulai"
                           value="{{ old('tgl_mulai') }}"
                           class="w-full px-4 py-3 border rounded-lg shadow-sm @error('tgl_mulai') border-red-500 @enderror" required>
                    @error('tgl_mulai')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Tanggal Berakhir -->
                <div>
                     <label for="tgl_berakhir" class="block mb-1 text-sm font-medium text-gray-600">Tanggal Berakhir</label>
                    <input type="date" name="tgl_berakhir" id="tgl_berakhir"
                           value="{{ old('tgl_berakhir') }}"
                           class="w-full px-4 py-3 border rounded-lg shadow-sm @error('tgl_berakhir') border-red-500 @enderror" required>
                     @error('tgl_berakhir')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Jumlah Orang -->
                <div>
                    <label for="jumlah_orang" class="block mb-1 text-sm font-medium text-gray-600">Jumlah Orang</label>
                    <input type="number" name="jumlah_orang" id="jumlah_orang" placeholder="Contoh: 3"
                           value="{{ old('jumlah_orang') }}"
                           class="w-full px-4 py-3 border rounded-lg shadow-sm @error('jumlah_orang') border-red-500 @enderror" min="1" required>
                    @error('jumlah_orang')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Serahkan -->
                <div class="pt-4 flex justify-center">
                    <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 shadow-md">
                        Serahkan Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-mahasiswa-layout>

