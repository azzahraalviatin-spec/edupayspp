<?php

use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\SettingSppController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\MetodePembayaranController;
use App\Http\Controllers\Admin\NotificationController as AdminNotification;

// Petugas Controllers
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Petugas\TagihanController as PetugasTagihan;
use App\Http\Controllers\Petugas\VerifikasiController;
use App\Http\Controllers\Petugas\RiwayatController;
use App\Http\Controllers\Petugas\PotonganController as PetugasPotongan;
use App\Http\Controllers\Petugas\ProfilController as PetugasProfil;

// Siswa Controllers
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\TagihanController as SiswaTagihan;
use App\Http\Controllers\Siswa\RiwayatController as SiswaRiwayat;
use App\Http\Controllers\Siswa\ProfilController as SiswaProfil;
use App\Http\Controllers\Siswa\NotificationController as SiswaNotification;

// ============================================================
// Redirect utama ke login
// ============================================================
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes (login, register, dll)
require __DIR__.'/auth.php';

// ============================================================
// ADMIN ROUTES
// ============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Data Master
    Route::resource('siswa', SiswaController::class);
    Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
    Route::resource('tahun-ajaran', TahunAjaranController::class);
    Route::resource('setting-spp', SettingSppController::class);

    // Keuangan
    Route::resource('pembayaran', MetodePembayaranController::class);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/download-pdf', [LaporanController::class, 'downloadPdf'])->name('laporan.pdf');

    // Akun
    Route::resource('user', UserController::class);
    Route::post('/user/{user}/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

    // Notifikasi Admin
    Route::post('/notifikasi/baca/{id}', [AdminNotification::class, 'baca'])->name('notif.baca');
    Route::post('/notifikasi/baca-semua', [AdminNotification::class, 'bacaSemua'])->name('notif.baca-semua');
});

// ============================================================
// PETUGAS ROUTES
// ============================================================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {

    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');

    // Tagihan
    Route::get('/tagihan/generate', [PetugasTagihan::class, 'index'])->name('tagihan.generate');
    Route::post('/tagihan/generate', [PetugasTagihan::class, 'generate'])->name('tagihan.store');
    Route::get('/tagihan/bayar/{id}', [PetugasTagihan::class, 'showBayar'])->name('bayar.page');
    Route::post('/bayar-tunai/{id}', [PetugasTagihan::class, 'bayarTunai'])->name('bayar.tunai');
    Route::get('/tagihan/struk/{id}', [PetugasTagihan::class, 'struk'])->name('struk');

    // Tunggakan
    Route::get('/tunggakan', [PetugasTagihan::class, 'tunggakan'])->name('tunggakan');
    Route::get('/tunggakan/detail/{id}', [PetugasTagihan::class, 'tunggakanDetail'])->name('tunggakan.detail');

    // Verifikasi
    Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::post('/verifikasi/{pembayaran}/konfirmasi', [VerifikasiController::class, 'konfirmasi'])->name('verifikasi.konfirmasi');
    Route::post('/verifikasi/{pembayaran}/tolak', [VerifikasiController::class, 'tolak'])->name('verifikasi.tolak');
    Route::post('/verifikasi/konfirmasi-semua', [VerifikasiController::class, 'konfirmasiSemua'])->name('verifikasi.konfirmasi-semua');

    // Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');

    // Potongan
    Route::get('/potongan', [PetugasPotongan::class, 'index'])->name('potongan');
    Route::post('/potongan/assign', [PetugasPotongan::class, 'assign'])->name('potongan.assign');
    Route::get('/potongan/tambah/{jenis}', [PetugasPotongan::class, 'tambah'])->name('potongan.tambah');
    Route::post('/potongan/store', [PetugasPotongan::class, 'store'])->name('potongan.store');
    Route::get('/potongan/detail/{siswaId}/{potId}', [PetugasPotongan::class, 'detail'])->name('potongan.detail');
    Route::get('/potongan/edit/{siswaId}/{potId}', [PetugasPotongan::class, 'editPotongan'])->name('potongan.edit');
    Route::put('/potongan/update/{siswaId}/{potId}', [PetugasPotongan::class, 'updatePotongan'])->name('potongan.update');
    Route::delete('/potongan/hapus/{siswaId}/{potId}', [PetugasPotongan::class, 'hapus'])->name('potongan.hapus');

    // Profil
    Route::get('/profil', [PetugasProfil::class, 'index'])->name('profil');
    Route::put('/profil', [PetugasProfil::class, 'update'])->name('profil.update');
});

// ============================================================
// SISWA ROUTES
// ============================================================
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');

    // Tagihan
    Route::get('/tagihan', [SiswaTagihan::class, 'index'])->name('tagihan');
    Route::post('/tagihan/{tagihan}/upload', [SiswaTagihan::class, 'upload'])->name('tagihan.upload');
    Route::get('/tagihan/{tagihan}/kwitansi', [SiswaTagihan::class, 'kwitansi'])->name('tagihan.kwitansi');
    Route::get('/tagihan/{tagihan}/download-pdf', [SiswaTagihan::class, 'downloadPdf'])->name('tagihan.download-pdf');
    Route::get('/tagihan/{id}/bayar', [SiswaTagihan::class, 'prosesBayar'])->name('tagihan.bayar');
    Route::post('/tagihan/{id}/simpan-metode', [SiswaTagihan::class, 'simpanMetode'])->name('tagihan.simpan-metode');

    // Riwayat
    Route::get('/riwayat', [SiswaRiwayat::class, 'index'])->name('riwayat');

    // Profil
    Route::get('/profil', [SiswaProfil::class, 'index'])->name('profil');
    Route::put('/profil', [SiswaProfil::class, 'update'])->name('profil.update');

    // Notifikasi Siswa
    Route::get('/notifications', [SiswaNotification::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/baca', [SiswaNotification::class, 'baca'])->name('notifications.baca');
    Route::post('/notifications/baca-semua', [SiswaNotification::class, 'bacaSemua'])->name('notifications.baca-semua');
});