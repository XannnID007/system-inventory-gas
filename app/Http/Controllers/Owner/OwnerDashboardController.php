<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\StokMasuk;
use App\Models\StokSekarang;
use App\Models\Pengaturan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $stok = StokSekarang::getStok();
        $pengaturan = Pengaturan::first();

        // Penjualan hari ini
        $penjualanHariIni = Transaksi::whereDate('tanggal_transaksi', today())
            ->selectRaw('SUM(jumlah) as total_qty, SUM(total) as total_rupiah')
            ->first();

        // Penjualan bulan ini
        $penjualanBulanIni = Transaksi::whereMonth('tanggal_transaksi', now()->month)
            ->whereYear('tanggal_transaksi', now()->year)
            ->selectRaw('SUM(jumlah) as total_qty, SUM(total) as total_rupiah')
            ->first();

        // Modal bulan ini
        $modalBulanIni = StokMasuk::whereMonth('tanggal_beli', now()->month)
            ->whereYear('tanggal_beli', now()->year)
            ->sum('total_modal');

        // Keuntungan bulan ini
        $keuntunganBulanIni = ($penjualanBulanIni->total_rupiah ?? 0) - $modalBulanIni;

        // Grafik penjualan 7 hari terakhir
        $grafikPenjualan = Transaksi::whereBetween('tanggal_transaksi', [
            now()->subDays(6)->startOfDay(),
            now()->endOfDay()
        ])
            ->selectRaw('DATE(tanggal_transaksi) as tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Transaksi terakhir
        $transaksiTerakhir = Transaksi::with('user')
            ->orderBy('tanggal_transaksi', 'desc')
            ->limit(5)
            ->get();

        // Statistik Staff
        $totalStaff = User::where('role', 'staff')->count();
        $staffAktif = User::where('role', 'staff')
            ->whereHas('transaksi', function ($q) {
                $q->whereDate('tanggal_transaksi', today());
            })
            ->count();

        // Check stok minimum
        $alertStok = false;
        if ($pengaturan && $pengaturan->notifikasi_stok) {
            $alertStok = $stok <= $pengaturan->stok_minimum;
        }

        return view('owner.dashboard', compact(
            'stok',
            'penjualanHariIni',
            'penjualanBulanIni',
            'keuntunganBulanIni',
            'modalBulanIni',
            'grafikPenjualan',
            'transaksiTerakhir',
            'totalStaff',
            'staffAktif',
            'alertStok',
            'pengaturan'
        ));
    }
}
