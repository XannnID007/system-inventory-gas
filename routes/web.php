<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\LaporanController;
use App\Http\Controllers\Owner\RiwayatController as OwnerRiwayatController;
use App\Http\Controllers\Owner\StaffController;
use App\Http\Controllers\Owner\PengaturanController as OwnerPengaturanController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\TransaksiController;
use App\Http\Controllers\Staff\StokController;
use App\Http\Controllers\Staff\RiwayatController as StaffRiwayatController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    // Root redirect based on role
    Route::get('/', function () {
        if (auth()->user()->isOwner()) {
            return redirect()->route('owner.dashboard');
        }
        return redirect()->route('staff.dashboard');
    })->name('dashboard');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'owner'])->prefix('owner')->name('owner.')->group(function () {

    // Dashboard Owner
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
        Route::get('/create', [StaffController::class, 'create'])->name('create');
        Route::post('/', [StaffController::class, 'store'])->name('store');
        Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('edit');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('update');
        Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export-excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
    });

    Route::prefix('riwayat')->name('riwayat.')->group(function () {
        Route::get('/', [OwnerRiwayatController::class, 'index'])->name('index');
        Route::delete('/transaksi/{transaksi}', [OwnerRiwayatController::class, 'destroyTransaksi'])->name('transaksi.destroy');
        Route::delete('/stok-masuk/{stokMasuk}', [OwnerRiwayatController::class, 'destroyStokMasuk'])->name('stok-masuk.destroy');
    });

    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/', [OwnerPengaturanController::class, 'index'])->name('index');
        Route::put('/toko', [OwnerPengaturanController::class, 'updateToko'])->name('toko.update');
    });
});

Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {

    // Dashboard Staff
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/create', [TransaksiController::class, 'create'])->name('create');
        Route::post('/', [TransaksiController::class, 'store'])->name('store');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
        Route::get('/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('edit');
        Route::put('/{transaksi}', [TransaksiController::class, 'update'])->name('update');
        Route::delete('/{transaksi}', [TransaksiController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('stok')->name('stok.')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('index');
        Route::post('/stok-masuk', [StokController::class, 'storeStokMasuk'])->name('stok-masuk.store');
        Route::post('/penyesuaian', [StokController::class, 'storePenyesuaian'])->name('penyesuaian.store');
    });

    Route::get('/riwayat', [StaffRiwayatController::class, 'index'])->name('riwayat.index');
});

Route::middleware('auth')->prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('index');
    Route::put('/update', [ProfilController::class, 'update'])->name('update');
    Route::put('/password', [ProfilController::class, 'updatePassword'])->name('password.update');
});
