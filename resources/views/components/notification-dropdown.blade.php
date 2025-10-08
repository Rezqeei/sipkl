@props(['notifications', 'unreadCount'])

<div class="relative" x-data="{ open: false }">
    <!-- Tombol Ikon Lonceng -->
    <button @click="open = !open"
        class="relative z-10 block p-2 text-gray-700 bg-white border border-transparent rounded-md dark:text-white focus:border-blue-500 focus:ring-opacity-40 dark:focus:ring-opacity-40 focus:ring-blue-300 dark:focus:ring-blue-400 focus:ring dark:bg-gray-800 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path
                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
        </svg>
        <!-- Badge Jumlah Notifikasi -->
        @if($unreadCount > 0)
        <span
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{
            $unreadCount }}</span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" @click.away="open = false"
        class="absolute right-0 z-20 w-80 mt-2 overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95"
        style="display: none;">
        <div class="py-2">
            @forelse ($notifications as $notification)
            <a href="{{ route('notifications.read', $notification->id) }}"
                class="flex items-center px-4 py-3 -mx-2 border-b hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-700 {{ $notification->read_at ? 'opacity-60' : '' }}">
                <div class="mx-3">
                    <p class="text-sm text-gray-600 dark:text-gray-200">{{ $notification->data['pesan'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
            </a>
            @empty
            <p class="px-4 py-3 text-sm text-center text-gray-600 dark:text-gray-200">Tidak ada notifikasi baru.</p>
            @endforelse
        </div>
    </div>
</div>