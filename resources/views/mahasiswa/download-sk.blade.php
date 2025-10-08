<x-mahasiswa-layout>
    <div class="p-6 md:p-10 text-center">
        <h1 class="text-3xl font-bold text-gray-800">Download Surat Keterangan PKL</h1>

        <div class="mt-8 bg-white max-w-lg mx-auto p-8 rounded-xl shadow-lg border">
            {{-- Pastikan mengecek 'file_surat' --}}
            @if($surat && $surat->file_surat)
            <h2 class="text-xl font-semibold text-gray-700">SK Anda Telah Terbit!</h2>
            <p class="mt-2 text-gray-500">Silakan unduh Surat Keterangan Selesai PKL Anda melalui tombol di bawah ini.
            </p>
            <a href="{{ route('mahasiswa.download.sk.process', $surat->id_surat) }}"
                class="mt-6 inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg">
                Unduh SK Sekarang
            </a>
            @else
            <h2 class="text-xl font-semibold text-gray-700">SK Belum Tersedia</h2>
            <p class="mt-2 text-gray-500">Surat Keterangan Selesai PKL Anda belum diterbitkan oleh admin. Silakan cek
                kembali nanti.</p>
            @endif
        </div>
    </div>
</x-mahasiswa-layout>