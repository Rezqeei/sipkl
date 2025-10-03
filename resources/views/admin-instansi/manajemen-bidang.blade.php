<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Bidang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Session Messages -->
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Form Tambah Bidang -->
                    <div class="mb-6 p-4 border rounded-md">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Bidang Baru</h3>
                        <form action="{{ route('admin-instansi.manajemen-bidang.store') }}" method="POST">
                            @csrf
                            <div>
                                <x-input-label for="nama_bidang" :value="__('Nama Bidang')" />
                                <x-text-input id="nama_bidang" class="block mt-1 w-full" type="text" name="nama_bidang" :value="old('nama_bidang')" required autofocus />
                                <x-input-error :messages="$errors->get('nama_bidang')" class="mt-2" />
                            </div>
                            <div class="flex items-center mt-4">
                                <x-primary-button>
                                    {{ __('Simpan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Daftar Bidang -->
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Bidang</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Bidang</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" x-data="{ openEdit: false, openDelete: false, selectedBidang: {}, deleteUrl: '' }">
                                @forelse ($bidangs as $index => $bidang)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $bidang->nama_bidang }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button @click="openEdit = true; selectedBidang = {{ $bidang }}" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <button @click="openDelete = true; deleteUrl = '{{ route('admin-instansi.manajemen-bidang.destroy', $bidang->id) }}'" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data bidang.</td>
                                </tr>
                                @endforelse

                                <!-- Modal Edit -->
                                <template x-if="openEdit">
                                    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" @click.self="openEdit = false">
                                        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full" @click.away="openEdit = false">
                                            <h3 class="text-lg font-medium mb-4">Edit Bidang</h3>
                                            <form :action="'{{ url('admin-instansi/manajemen-bidang') }}/' + selectedBidang.id" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div>
                                                    <x-input-label for="edit_nama_bidang" :value="__('Nama Bidang')" />
                                                    <x-text-input id="edit_nama_bidang" class="block mt-1 w-full" type="text" name="nama_bidang" x-model="selectedBidang.nama_bidang" required />
                                                </div>
                                                <div class="mt-6 flex justify-end">
                                                    <x-secondary-button @click="openEdit = false">Batal</x-secondary-button>
                                                    <x-primary-button class="ml-3">Update</x-primary-button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </template>

                                <!-- Modal Delete -->
                                <template x-if="openDelete">
                                    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" @click.self="openDelete = false">
                                        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full" @click.away="openDelete = false">
                                            <h3 class="text-lg font-medium">Konfirmasi Hapus</h3>
                                            <p class="mt-1 text-sm text-gray-600">Apakah Anda yakin ingin menghapus bidang ini? Tindakan ini tidak dapat dibatalkan.</p>
                                            <form :action="deleteUrl" method="POST" class="mt-6 flex justify-end">
                                                @csrf
                                                @method('DELETE')
                                                <x-secondary-button @click="openDelete = false">Batal</x-secondary-button>
                                                <x-danger-button class="ml-3">Hapus</x-danger-button>
                                            </form>
                                        </div>
                                    </div>
                                </template>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>