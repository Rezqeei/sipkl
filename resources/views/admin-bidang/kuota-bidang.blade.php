<x-admin-bidang-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kuota Bidang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Error!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($bidang)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-6 rounded-lg shadow">
                            <h3 class="font-semibold text-lg mb-2">Informasi Bidang</h3>
                            <p><strong>Nama Bidang:</strong> {{ $bidang->nama_bidang }}</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg shadow">
                            <h3 class="font-semibold text-lg mb-2">Informasi Kuota</h3>
                            <p><strong>Kuota Maksimal:</strong> {{ $bidang->kuota }}</p>
                            <p><strong>Mahasiswa Aktif:</strong> {{ $mahasiswaAktifCount }}</p>
                            <p><strong>Sisa Kuota:</strong> {{ $sisaKuota }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-2">Update Kuota</h3>
                        <form action="{{ route('admin-bidang.kuota-bidang.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center">
                                <x-text-input id="kuota" name="kuota" type="number" class="mt-1 block w-full md:w-1/4"
                                    :value="$bidang->kuota" required />
                                <x-primary-button class="ml-3">
                                    {{ __('Update') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <h3 class="font-semibold text-lg mb-4">Daftar Mahasiswa PKL Aktif</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="w-1/12 py-3 px-4 uppercase font-semibold text-sm text-left">No</th>
                                        <th class="w-4/12 py-3 px-4 uppercase font-semibold text-sm text-left">Nama
                                            Mahasiswa</th>
                                        <th class="w-4/12 py-3 px-4 uppercase font-semibold text-sm text-left">Asal
                                            Kampus</th>
                                        <th class="w-3/12 py-3 px-4 uppercase font-semibold text-sm text-left">Periode
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    @forelse($mahasiswaAktif as $index => $penempatan)
                                    <tr>
                                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4">{{ $penempatan->mahasiswa->name }}</td>
                                        <td class="py-3 px-4">{{ $penempatan->antrian->nama_kampus }}</td>
                                        <td class="py-3 px-4">{{
                                            \Carbon\Carbon::parse($penempatan->antrian->tgl_mulai)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($penempatan->antrian->tgl_berakhir)->format('d M
                                            Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">Tidak ada mahasiswa aktif saat ini.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <p>Informasi bidang untuk akun Anda tidak ditemukan. Harap hubungi Admin Instansi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-bidang-layout>