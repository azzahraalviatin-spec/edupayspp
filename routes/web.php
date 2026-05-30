<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\SettingSppController;
use App\Http\Controllers\Siswa\NotificationController;

use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
// Petugas routes
use App\Http\Controllers\Petugas\TagihanController as PetugasTagihan;
use App\Http\Controllers\Petugas\VerifikasiController;
use App\Http\Controllers\Petugas\RiwayatController;
use App\Http\Controllers\Petugas\PotonganController as PetugasPotongan;
use App\Http\Controllers\Petugas\ProfilController as PetugasProfil;
use App\Http\Controllers\Admin\MetodePembayaranController;
// Siswa routes
use App\Http\Controllers\Siswa\TagihanController as SiswaTagihan;
use App\Http\Controllers\Siswa\RiwayatController as SiswaRiwayat;
use App\Http\Controllers\Siswa\ProfilController as SiswaProfil;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Pastikan baris ini ada dan tidak terkomentar/terhapus!
Route::resource('pembayaran', MetodePembayaranController::class);
    
});

// Redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
require __DIR__.'/auth.php';
Route::get('admin/laporan/download-pdf', [App\Http\Controllers\Admin\LaporanController::class, 'downloadPdf'])->name('admin.laporan.pdf');
// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('siswa', SiswaController::class);
 
    // PERBAIKAN DI SINI: Dimasukkan langsung ke dalam grup admin menggantikan baris yang lama
    Route::resource('kelas', KelasController::class)->parameters([
        'kelas' => 'kelas'
    ]);
    
    Route::resource('tahun-ajaran', TahunAjaranController::class);
    Route::resource('setting-spp', SettingSppController::class);

    Route::resource('user', UserController::class);
    Route::post('/user/{user}/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {

Route::get('/potongan/tambah/{jenis}',          [PetugasPotongan::class, 'tambah'])->name('potongan.tambah');
Route::post('/potongan/store',                   [PetugasPotongan::class, 'store'])->name('potongan.store');
Route::get('/potongan/detail/{siswaId}/{potId}', [PetugasPotongan::class, 'detail'])->name('potongan.detail');
Route::get('/potongan/edit/{siswaId}/{potId}',   [PetugasPotongan::class, 'editPotongan'])->name('potongan.edit');
Route::put('/potongan/update/{siswaId}/{potId}', [PetugasPotongan::class, 'updatePotongan'])->name('potongan.update');
Route::delete('/potongan/hapus/{siswaId}/{potId}',[PetugasPotongan::class, 'hapus'])->name('potongan.hapus');
 

    Route::post('/bayar-tunai/{id}', [PetugasTagihan::class, 'bayarTunai'])
        ->name('bayar.tunai');
Route::get('tagihan/bayar/{id}', [PetugasTagihan::class, 'showBayar'])->name('bayar.page');
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');

Route::get('tagihan/struk/{id}', [PetugasTagihan::class, 'struk'])->name('struk');

    Route::get('/tagihan/generate', [PetugasTagihan::class, 'index'])->name('tagihan.generate');

    Route::post('/tagihan/generate', [PetugasTagihan::class, 'generate'])->name('tagihan.store');

 Route::get('/tunggakan', [PetugasTagihan::class, 'tunggakan'])->name('tunggakan');
Route::get('/tunggakan/detail/{id}', [PetugasTagihan::class, 'tunggakanDetail'])->name('tunggakan.detail'); // ← TAMBAH INI

    Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
Route::post('/verifikasi/konfirmasi-semua', [VerifikasiController::class, 'konfirmasiSemua'])->name('verifikasi.konfirmasi-semua');
    Route::post('/verifikasi/{pembayaran}/konfirmasi', [VerifikasiController::class, 'konfirmasi'])->name('verifikasi.konfirmasi');

    Route::post('/verifikasi/{pembayaran}/tolak', [VerifikasiController::class, 'tolak'])->name('verifikasi.tolak');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');

    Route::get('/potongan', [PetugasPotongan::class, 'index'])->name('potongan');

    Route::post('/potongan/assign', [PetugasPotongan::class, 'assign'])->name('potongan.assign');

    Route::get('/profil', [PetugasProfil::class, 'index'])->name('profil');

    Route::put('/profil', [PetugasProfil::class, 'update'])->name('profil.update');
});




Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/baca', [NotificationController::class, 'baca'])->name('notifications.baca');
    Route::post('/notifications/baca-semua', [NotificationController::class, 'bacaSemua'])->name('notifications.baca-semua');
    Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');
    Route::get('/tagihan', [SiswaTagihan::class, 'index'])->name('tagihan');
    Route::post('/tagihan/{tagihan}/upload', [SiswaTagihan::class, 'upload'])->name('tagihan.upload');
    Route::get('/tagihan/{tagihan}/kwitansi', [SiswaTagihan::class, 'kwitansi'])->name('tagihan.kwitansi');
    Route::get('/tagihan/{tagihan}/download-pdf', [SiswaTagihan::class, 'downloadPdf'])->name('tagihan.download-pdf'); // ← INI YANG KURANG
    Route::get('/riwayat', [SiswaRiwayat::class, 'index'])->name('riwayat');
    Route::get('/profil', [SiswaProfil::class, 'index'])->name('profil');
    Route::put('/profil', [SiswaProfil::class, 'update'])->name('profil.update');
// Route baru untuk alur ringkasan pembayaran dan upload berkas
    Route::get('/tagihan/{id}/bayar', [SiswaTagihan::class, 'prosesBayar'])->name('tagihan.bayar');
    Route::post('/tagihan/{id}/simpan-metode', [SiswaTagihan::class, 'simpanMetode'])->name('tagihan.simpan-metode');

    });
Route::get('/tagihan/{tagihan}/download-pdf', [SiswaTagihan::class, 'downloadPdf'])->name('tagihan.download-pdf');
Route::post('admin/notifikasi/baca/{id}', function ($id) {
    Illuminate\Support\Facades\DB::table('notifications')
        ->where('id', $id)
        ->update(['read_at' => now()]);
    return response()->json(['success' => true]);
})->name('admin.notif.baca');
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:petugas'])->group(function () {
 
    // ... route lain kamu ...
 
    // Verifikasi Pembayaran
    Route::get('/verifikasi', [App\Http\Controllers\Petugas\VerifikasiController::class, 'index'])
        ->name('verifikasi.index');
 
    Route::post('/verifikasi/{pembayaran}/konfirmasi', [App\Http\Controllers\Petugas\VerifikasiController::class, 'konfirmasi'])
        ->name('verifikasi.konfirmasi');
 
    Route::post('/verifikasi/{pembayaran}/tolak', [App\Http\Controllers\Petugas\VerifikasiController::class, 'tolak'])
        ->name('verifikasi.tolak');
 
    Route::post('/verifikasi/konfirmasi-semua', [App\Http\Controllers\Petugas\VerifikasiController::class, 'konfirmasiSemua'])
        ->name('verifikasi.konfirmasi-semua');
 
});