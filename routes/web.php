<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// === KUMPULKAN SEMUA CONTROLLER DI SINI AGAR RAPI ===

// Controller Global
use App\Http\Controllers\ProfileController;

// Controller untuk Mahasiswa
use App\Http\Controllers\Mahasiswa\DashboardMahasiswaController;
use App\Http\Controllers\Mahasiswa\PengajuanPKLController;
use App\Http\Controllers\Mahasiswa\DokumenController;
use App\Http\Controllers\Mahasiswa\LaporanPKLController;
use App\Http\Controllers\Mahasiswa\SKController;

// Controller untuk Admin Instansi
use App\Http\Controllers\AdminInstansi\DashboardController as AdminInstansiDashboardController;
use App\Http\Controllers\AdminInstansi\VerifikasiPengajuanController;
use App\Http\Controllers\AdminInstansi\VerifikasiDokumenController;
use App\Http\Controllers\AdminInstansi\PenempatanController;
use App\Http\Controllers\AdminInstansi\ManajemenAdminBidangController;
use App\Http\Controllers\AdminInstansi\ArsipPKLController;

// Controller untuk Admin Bidang
use App\Http\Controllers\AdminBidang\DashboardController as AdminBidangDashboardController;
use App\Http\Controllers\AdminBidang\MonitoringLaporanController;
use App\Http\Controllers\AdminBidang\KuotaBidangController;
use App\Http\Controllers\DokumenController as ControllersDokumenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK & GLOBAL ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    $user = $request->user();
    $redirectRoute = match ($user->role) {
        'admin_instansi' => 'admin-instansi.dashboard',
        'admin_bidang'   => 'admin-bidang.dashboard',
        default          => 'mahasiswa.dashboard',
    };
    return redirect()->route($redirectRoute);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ===================================================================
// GRUP RUTE UNTUK MAHASISWA
// ===================================================================
Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.') // <-- PENTING: Menambahkan prefix nama 'mahasiswa.'
    ->group(function () {

        Route::get('/dashboard', [DashboardMahasiswaController::class, 'index'])->name('dashboard');
        Route::get('/identitas-dinas', [DashboardMahasiswaController::class, 'identitasDinas'])->name('identitas.dinas');

        Route::get('/pengajuan-antrian', [PengajuanPKLController::class, 'create'])->name('pengajuan.antrian');
        Route::post('/pengajuan-antrian', [PengajuanPKLController::class, 'store'])->name('pengajuan.store');

        Route::get('/unggah-dokumen', [DokumenController::class, 'create'])->name('unggah.dokumen');
        Route::post('/unggah-dokumen', [DokumenController::class, 'store'])->name('unggah.dokumen.store');

        Route::get('/laporan-mingguan', [LaporanPKLController::class, 'createMingguan'])->name('laporan.mingguan');
        Route::post('/laporan-mingguan', [LaporanPKLController::class, 'storeMingguan'])->name('laporan.mingguan.store');

        Route::get('/laporan-akhir', [LaporanPKLController::class, 'createAkhir'])->name('laporan.akhir');
        Route::post('/laporan-akhir', [LaporanPKLController::class, 'storeAkhir'])->name('laporan.akhir.store');

        Route::get('/download-sk', [SKController::class, 'index'])->name('download.sk');
        Route::get('/download-sk/{surat}', [SKController::class, 'download'])->name('download.sk.process');
    });

Route::middleware(['auth', 'role:admin_instansi'])
    ->prefix('admin-instansi')
    ->name('admin-instansi.') // <-- PENTING: Menambahkan titik di akhir
    ->group(function () {

        Route::get('/dashboard', [AdminInstansiDashboardController::class, 'index'])->name('dashboard');

        Route::get('/verifikasi-pengajuan', [VerifikasiPengajuanController::class, 'index'])->name('verifikasi-pengajuan.index');
        Route::post('/verifikasi-pengajuan/{antrian}', [VerifikasiPengajuanController::class, 'update'])->name('verifikasi-pengajuan.update');

        Route::get('/verifikasi-dokumen', [VerifikasiDokumenController::class, 'index'])->name('verifikasi-dokumen.index');
        Route::post('/verifikasi-dokumen/{dokumen}', [VerifikasiDokumenController::class, 'update'])->name('verifikasi-dokumen.update');

        Route::get('/penempatan-mahasiswa', [PenempatanController::class, 'index'])->name('penempatan.index');
        Route::post('/penempatan-mahasiswa', [PenempatanController::class, 'store'])->name('penempatan.store');

        Route::resource('/manajemen-admin-bidang', ManajemenAdminBidangController::class);

        Route::get('/arsip-pkl', [ArsipPKLController::class, 'index'])->name('arsip-pkl.index');
    });

Route::middleware(['auth', 'role:admin_bidang'])
    ->prefix('admin-bidang')
    ->name('admin-bidang.') 
    ->group(function () {
        Route::get('/dashboard', [AdminBidangDashboardController::class, 'index'])->name('dashboard');
        Route::get('/laporan-mingguan', [MonitoringLaporanController::class, 'indexMingguan'])->name('laporan-mingguan.index');
        Route::post('/laporan-mingguan/{laporan}', [MonitoringLaporanController::class, 'updateMingguan'])->name('laporan-mingguan.update');

        Route::get('/laporan-akhir', [MonitoringLaporanController::class, 'indexAkhir'])->name('laporan-akhir.index');
        Route::post('/laporan-akhir/{laporan_akhir}', [MonitoringLaporanController::class, 'updateAkhir'])->name('laporan-akhir.update');
        Route::get('/kuota-bidang', [KuotaBidangController::class, 'index'])->name('kuota-bidang.index');
        Route::post('/kuota-bidang', [KuotaBidangController::class, 'update'])->name('kuota-bidang.update');
    });


require __DIR__ . '/auth.php';
