<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\StokMasuk;
use App\Models\StokSekarang;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
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

        // Keuntungan bulan ini (estimasi)
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

        // Check stok minimum
        $alertStok = false;
        if ($pengaturan && $pengaturan->notifikasi_stok) {
            $alertStok = $stok <= $pengaturan->stok_minimum;
        }

        return view('dashboard.index', compact(
            'stok',
            'penjualanHariIni',
            'penjualanBulanIni',
            'keuntunganBulanIni',
            'grafikPenjualan',
            'transaksiTerakhir',
            'alertStok',
            'pengaturan'
        ));
    }
}
