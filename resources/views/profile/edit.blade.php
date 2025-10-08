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
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white shadow rounded-xl p-8">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-white shadow rounded-xl p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
    
</x-dynamic-component>