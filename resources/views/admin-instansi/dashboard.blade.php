<x-admin-layout>
    {{-- Menampilkan Kartu Statistik --}}
    <div class="grid grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h4 class="text-gray-500">Pengajuan Baru</h4>
            <p class="text-3xl font-bold">{{ $jumlahPengajuanBaru }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h4 class="text-gray-500">Dokumen Menunggu</h4>
            <p class="text-3xl font-bold">{{ $jumlahDokumenMenunggu }}</p>
        </div>
        {{-- ... kartu lainnya ... --}}
    </div>

    {{-- Menampilkan Daftar Tugas Terbaru --}}
    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h4 class="font-semibold mb-4">Tugas Terbaru</h4>
        <ul>
            @forelse ($tugasTerbaru as $tugas)
                <li class="border-b py-2 flex justify-between items-center">
                    <span>
                        <strong>{{ $tugas->nama_lengkap }}</strong> 
                        <small class="text-gray-500">
                            @if($tugas->status_antrian == 'Menunggu Verifikasi')
                                perlu verifikasi antrian.
                            @else
                                perlu verifikasi dokumen.
                            @endif
                        </small>
                    </span>
                    <a href="#" class="bg-blue-500 text-white text-sm py-1 px-3 rounded-full">Lihat Detail</a>
                </li>
            @empty
                <p class="text-gray-500">Tidak ada tugas baru saat ini.</p>
            @endforelse
        </ul>
    </div>
</x-admin-layout>