@props(['notifications'])

{{-- Modal Container --}}
<div x-data="{ show: false }" @open-notification-modal.window="show = true" x-show="show"
    x-on:keydown.escape.window="show = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">

    {{-- Modal Content --}}
    <div @click.away="show = false" x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
        class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
            <button @click="show = false" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Modal Body (Daftar Notifikasi) --}}
        <div class="p-2 max-h-96 overflow-y-auto">
            @forelse ($notifications as $notification)
            <a href="{{ route('notifications.read', $notification->id) }}"
                class="block p-3 rounded-lg hover:bg-gray-100 {{ $notification->read_at ? 'opacity-60' : '' }}">
                <p class="text-sm text-gray-700">{{ $notification->data['pesan'] }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
            </a>
            @empty
            <div class="text-center p-8 text-gray-500">
                <p>Tidak ada notifikasi untuk ditampilkan.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>