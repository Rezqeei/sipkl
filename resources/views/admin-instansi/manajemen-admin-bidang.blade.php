<x-admin-layout>
    <!-- Slot Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Admin & Bidang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Notifikasi -->
            @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
            @endif

            @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 8000)"
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
                <span @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Terjadi Kesalahan!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Card 1: Manajemen Bidang -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    <header class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            Manajemen Bidang
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Tambah, edit, atau hapus bidang yang tersedia di instansi.
                        </p>
                    </header>

                    <!-- Form Tambah Bidang -->
                    <form method="POST" action="{{ route('admin-instansi.manajemen-bidang.store') }}" class="mb-6">
                        @csrf
                        <div class="flex items-end gap-4">
                            <div class="flex-grow">
                                <x-input-label for="nama_bidang" :value="__('Nama Bidang Baru')" />
                                <x-text-input id="nama_bidang" name="nama_bidang" type="text" class="mt-1 block w-full"
                                    required autofocus autocomplete="off" />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_bidang')" />
                            </div>
                            <x-primary-button>
                                {{ __('Tambah Bidang') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Tabel Daftar Bidang -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Bidang
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Admin yang Menangani
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($bidangs as $bidang)
                                <tr x-data="{ isEdit: false, isDelete: false }">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $bidang->nama_bidang }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $bidang->adminBidang->name ?? 'Belum ada' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <!-- Tombol Edit -->
                                        <button @click="isEdit = true"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <!-- Tombol Hapus -->
                                        <button @click="isDelete = true"
                                            class="text-red-600 hover:text-red-900">Hapus</button>

                                        <!-- Modal Edit Bidang -->
                                        <div x-show="isEdit"
                                            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50"
                                            x-cloak>
                                            <div @click.away="isEdit = false"
                                                class="relative mx-auto p-6 border w-full max-w-md shadow-lg rounded-md bg-white">
                                                <h3 class="text-lg font-medium text-gray-900 text-left mb-4">
                                                    Edit Nama Bidang
                                                </h3>
                                                <form
                                                    action="{{ route('admin-instansi.manajemen-bidang.update', $bidang->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <x-text-input name="nama_bidang" class="w-full text-left"
                                                        value="{{ $bidang->nama_bidang }}" required />
                                                    <div class="mt-6 flex justify-end gap-2">
                                                        <x-secondary-button @click="isEdit = false">
                                                            Batal
                                                        </x-secondary-button>
                                                        <x-primary-button>
                                                            Simpan Perubahan
                                                        </x-primary-button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus Bidang -->
                                        <div x-show="isDelete"
                                            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50"
                                            x-cloak>
                                            <div @click.away="isDelete = false"
                                                class="relative mx-auto p-6 border w-full max-w-md shadow-lg rounded-md bg-white text-left">
                                                <h3 class="text-lg font-medium text-gray-900">
                                                    Konfirmasi Penghapusan
                                                </h3>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    Anda yakin ingin menghapus bidang
                                                    "<strong>{{ $bidang->nama_bidang }}</strong>"? Tindakan ini
                                                    tidak dapat dibatalkan.
                                                </p>
                                                <form
                                                    action="{{ route('admin-instansi.manajemen-bidang.destroy', $bidang->id) }}"
                                                    method="POST" class="mt-6 flex justify-end gap-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-secondary-button @click="isDelete = false">
                                                        Batal
                                                    </x-secondary-button>
                                                    <x-danger-button>
                                                        Ya, Hapus
                                                    </x-danger-button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada data bidang.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card 2: Manajemen Akun Admin Bidang -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full"
                    x-data="{ isAddAdmin: false, isEditAdmin: false, isDeleteAdmin: false, selectedAdmin: null, selectedBidangId: '' }">
                    <header class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">
                                Akun Admin Bidang
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Tambah, edit, atau hapus akun untuk admin bidang.
                            </p>
                        </div>
                        <x-primary-button @click="isAddAdmin = true">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Akun
                        </x-primary-button>
                    </header>

                    <!-- Tabel Akun Admin Bidang -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bidang Dikelola
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($adminBidangList as $admin)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $admin->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $admin->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $admin->bidangDikelola->nama_bidang ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($admin->status_aktif)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                        @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Tidak Aktif
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <!-- Tombol Edit Akun -->
                                        <button
                                            @click="isEditAdmin = true; selectedAdmin = {{ json_encode($admin) }}; selectedBidangId = '{{ $admin->bidangDikelola->id ?? '' }}'"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <!-- Tombol Hapus Akun -->
                                        <button @click="isDeleteAdmin = true; selectedAdmin = {{ json_encode($admin) }}"
                                            class="text-red-600 hover:text-red-900">Hapus</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada akun admin bidang.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal Tambah Akun Admin -->
                    <div x-show="isAddAdmin"
                        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50"
                        x-cloak>
                        <form method="POST" action="{{ route('admin-instansi.manajemen-admin-bidang.store') }}"
                            @click.away="isAddAdmin = false"
                            class="relative mx-auto p-6 border w-full max-w-lg shadow-lg rounded-md bg-white">
                            @csrf
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Akun Admin Bidang Baru</h3>

                            <!-- Nama -->
                            <div>
                                <x-input-label for="add_name" value="Nama" />
                                <x-text-input id="add_name" name="name" type="text" class="mt-1 block w-full"
                                    :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="mt-4">
                                <x-input-label for="add_email" value="Email" />
                                <x-text-input id="add_email" name="email" type="email" class="mt-1 block w-full"
                                    :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Bidang -->
                            <div class="mt-4">
                                <x-input-label for="add_id_bidang" value="Tugaskan ke Bidang (Opsional)" />
                                <select id="add_id_bidang" name="id_bidang"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- Pilih Bidang --</option>
                                    @foreach ($allBidangsForModal as $bidang)
                                    <option value="{{ $bidang->id }}" @if ($bidang->id_admin_bidang) disabled @endif>
                                        {{ $bidang->nama_bidang }} @if ($bidang->id_admin_bidang)
                                        (Sudah ada admin)
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="add_password" value="Password" />
                                <x-text-input id="add_password" name="password" type="password"
                                    class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mt-4">
                                <x-input-label for="add_password_confirmation" value="Konfirmasi Password" />
                                <x-text-input id="add_password_confirmation" name="password_confirmation"
                                    type="password" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="mt-6 flex justify-end gap-2">
                                <x-secondary-button @click="isAddAdmin = false" type="button">
                                    Batal
                                </x-secondary-button>
                                <x-primary-button>
                                    Simpan
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Edit Akun Admin -->
                    <div x-show="isEditAdmin"
                        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50"
                        x-cloak>
                        <form x-show="isEditAdmin" method="POST"
                            :action="`{{ url('admin-instansi/manajemen-admin-bidang') }}/${selectedAdmin ? selectedAdmin.id : ''}`"
                            @click.away="isEditAdmin = false"
                            class="relative mx-auto p-6 border w-full max-w-lg shadow-lg rounded-md bg-white">
                            @csrf
                            @method('PUT')
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Akun Admin Bidang</h3>

                            <!-- Nama -->
                            <div>
                                <x-input-label for="edit_name" value="Nama" />
                                <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full"
                                    x-model="selectedAdmin.name" required />
                            </div>

                            <!-- Email -->
                            <div class="mt-4">
                                <x-input-label for="edit_email" value="Email" />
                                <x-text-input id="edit_email" name="email" type="email" class="mt-1 block w-full"
                                    x-model="selectedAdmin.email" required />
                            </div>

                            <!-- Bidang -->
                            <div class="mt-4">
                                <x-input-label for="edit_id_bidang" value="Tugaskan ke Bidang" />
                                <select id="edit_id_bidang" name="id_bidang" x-model="selectedBidangId"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- Tidak ada bidang --</option>
                                    @foreach ($allBidangsForModal as $bidang)
                                    <option value="{{ $bidang->id }}"
                                        :disabled="{{ $bidang->id_admin_bidang }} && {{ $bidang->id_admin_bidang }} != selectedAdmin.id">
                                        {{ $bidang->nama_bidang }}
                                        @if ($bidang->id_admin_bidang)
                                        (Dipegang oleh: {{ $bidang->adminBidang->name ?? '' }})
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="mt-4">
                                <x-input-label for="edit_status" value="Status Akun" />
                                <select id="edit_status" name="status_aktif"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    x-model="selectedAdmin.status_aktif">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="edit_password" value="Password Baru (Opsional)" />
                                <x-text-input id="edit_password" name="password" type="password"
                                    class="mt-1 block w-full" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="edit_password_confirmation" value="Konfirmasi Password Baru" />
                                <x-text-input id="edit_password_confirmation" name="password_confirmation"
                                    type="password" class="mt-1 block w-full" />
                            </div>

                            <div class="mt-6 flex justify-end gap-2">
                                <x-secondary-button @click="isEditAdmin = false" type="button">
                                    Batal
                                </x-secondary-button>
                                <x-primary-button>
                                    Simpan Perubahan
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Hapus Akun Admin -->
                    <div x-show="isDeleteAdmin"
                        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50"
                        x-cloak>
                        <div @click.away="isDeleteAdmin = false"
                            class="relative mx-auto p-6 border w-full max-w-md shadow-lg rounded-md bg-white">
                            <h3 class="text-lg font-medium text-gray-900">Konfirmasi Penghapusan</h3>
                            <p class="mt-2 text-sm text-gray-600">
                                Anda yakin ingin menghapus akun
                                <strong x-text="selectedAdmin ? selectedAdmin.name : ''"></strong>? Tindakan ini akan
                                menghapus akun secara permanen.
                            </p>
                            <form method="POST"
                                :action="`{{ url('admin-instansi/manajemen-admin-bidang') }}/${selectedAdmin ? selectedAdmin.id : ''}`"
                                class="mt-6 flex justify-end gap-2">
                                @csrf
                                @method('DELETE')
                                <x-secondary-button @click="isDeleteAdmin = false">Batal</x-secondary-button>
                                <x-danger-button>Ya, Hapus</x-danger-button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-admin-layout>