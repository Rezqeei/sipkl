<x-dynamic-component :component="$layout">

    {{-- Bagian ini untuk menampilkan judul "Profil" di header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    {{-- Kodenmu yang lain sudah bagus, kita pakai lagi --}}
    <div class="py-12">
        <div class="max-w-3xl mx-auto space-y-6">
            <div class="bg-white shadow rounded-xl p-8">
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-2">Informasi Akun</h3>
                    <p class="text-gray-600 text-sm">Update data profil Anda di bawah ini.</p>
                </div>
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white shadow rounded-xl p-8">
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-2">Update Password</h3>
                    <p class="text-gray-600 text-sm">Ganti password akun Anda secara berkala untuk keamanan.</p>
                </div>
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-white shadow rounded-xl p-8">
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-2">Hapus Akun</h3>
                    <p class="text-gray-600 text-sm">Akun dan data Anda akan dihapus permanen jika melanjutkan.</p>
                </div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
    
</x-dynamic-component>