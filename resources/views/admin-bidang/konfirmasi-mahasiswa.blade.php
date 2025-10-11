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

                @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    <p class="font-bold">Oops! Ada beberapa masalah:</p>
                    <ul class="list-disc pl-5 mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 px-6">No</th>
                                <th scope="col" class="py-3 px-6">Nama Mahasiswa</th>
                                <th scope="col" class="py-3 px-6">NIM</th>
                                <th scope="col" class="py-3 px-6">Jurusan</th>
                                <th scope="col" class="py-3 px-6">Kampus</th>
                                <th scope="col" class="py-3 px-6">Status Dokumen</th>
                                <th scope="col" class="py-3 px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($daftarPengajuan as $index => $pengajuan)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6">{{ $index + 1 }}</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $pengajuan->antrian->user->name }}
                                </td>
                                <td class="py-4 px-6">{{ $pengajuan->antrian->nim }}</td>
                                <td class="py-4 px-6">{{ $pengajuan->antrian->jurusan }}</td>
                                <td class="py-4 px-6">{{ $pengajuan->antrian->nama_kampus }}</td>
                                <td class="py-4 px-6 text-green-600 font-semibold">
                                    {{ $pengajuan->antrian->dokumen->status_verifikasi ?? 'Dokumen Lengkap' }}
                                </td>
                                <td class="py-4 px-6">
                                    <a href="#" class="font-medium text-blue-600 hover:underline" x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'konfirmasi-mahasiswa-{{ $pengajuan->id_penempatan }}')">[Detail]</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-4 px-6 text-center text-gray-500">
                                    Tidak ada mahasiswa yang menunggu konfirmasi di bidang Anda.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @foreach ($daftarPengajuan as $pengajuan)
                <x-modal name="konfirmasi-mahasiswa-{{ $pengajuan->id_penempatan }}" focusable>
                    <form method="post"
                        action="{{ route('admin-bidang.konfirmasi-mahasiswa.konfirmasi', $pengajuan->id_penempatan) }}"
                        class="p-6" x-data="{ action: 'terima' }">
                        @csrf
                        @method('put')

                        <h2 class="text-lg font-medium text-gray-900">
                            Detail Mahasiswa
                        </h2>

                        <div class="mt-4 space-y-2 text-sm text-gray-600">
                            <p><span class="font-semibold text-gray-800">Nama Lengkap:</span> {{
                                $pengajuan->antrian->user->name }}</p>
                            <p><span class="font-semibold text-gray-800">NIM:</span> {{ $pengajuan->antrian->nim }}</p>
                            <p><span class="font-semibold text-gray-800">Jurusan:</span> {{ $pengajuan->antrian->jurusan
                                }}</p>
                            <p><span class="font-semibold text-gray-800">Kampus:</span> {{
                                $pengajuan->antrian->nama_kampus }}</p>
                            <p><span class="font-semibold text-gray-800">Periode PKL:</span> {{
                                \Carbon\Carbon::parse($pengajuan->antrian->tgl_mulai)->format('d M Y') }} - {{
                                \Carbon\Carbon::parse($pengajuan->antrian->tgl_berakhir)->format('d M Y') }}</p>

                            <div class="pt-4 border-t">
                                <div class="space-y-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="action" value="terima" class="form-radio"
                                            x-model="action" checked>
                                        <span class="ml-2">Terima</span>
                                    </label>
                                    <label class="inline-flex items-center ml-4">
                                        <input type="radio" name="action" value="tolak" class="form-radio"
                                            x-model="action">
                                        <span class="ml-2">Tolak</span>
                                    </label>
                                </div>

                                <div x-show="action === 'terima'" class="mt-4">
                                    <label for="nama_pembimbing-{{$pengajuan->id_penempatan}}"
                                        class="text-sm font-medium">Nama Pembimbing</label>
                                    <input type="text" name="nama_pembimbing"
                                        id="nama_pembimbing-{{$pengajuan->id_penempatan}}"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Ketik nama pembimbing di sini..."
                                        value="{{ old('nama_pembimbing') }}">
                                </div>
                                
                                <div x-show="action === 'tolak'" class="mt-2">
                                    <label for="alasan_penolakan-{{$pengajuan->id_penempatan}}"
                                        class="text-sm font-medium">Alasan Penolakan</label>
                                    <textarea name="alasan_penolakan"
                                        id="alasan_penolakan-{{$pengajuan->id_penempatan}}" rows="2"
                                        class="w-full border-gray-300 rounded-md shadow-sm">{{ old('alasan_penolakan') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Batal') }}
                            </x-secondary-button>

                            <x-primary-button class="ml-3">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>
                @endforeach

            </div>
        </div>
    </div>
</x-admin-bidang-layout>