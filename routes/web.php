<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\PengaturanController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
});

// Auth routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/create', [TransaksiController::class, 'create'])->name('create');
        Route::post('/', [TransaksiController::class, 'store'])->name('store');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
        Route::delete('/{transaksi}', [TransaksiController::class, 'destroy'])->name('destroy');
    });

    // Stok
    Route::prefix('stok')->name('stok.')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('index');
        Route::post('/stok-masuk', [StokController::class, 'storeStokMasuk'])->name('stok-masuk.store');
        Route::delete('/stok-masuk/{stokMasuk}', [StokController::class, 'destroyStokMasuk'])->name('stok-masuk.destroy');
        Route::post('/penyesuaian', [StokController::class, 'storePenyesuaian'])->name('penyesuaian.store');
    });

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    // Pengaturan
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/', [PengaturanController::class, 'index'])->name('index');
        Route::put('/toko', [PengaturanController::class, 'updateToko'])->name('toko.update');
        Route::put('/profile', [PengaturanController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [PengaturanController::class, 'updatePassword'])->name('password.update');
    });

    // Logout
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});
