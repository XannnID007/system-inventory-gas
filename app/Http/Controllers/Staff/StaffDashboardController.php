<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\StokSekarang;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $stok = StokSekarang::getStok();
        $pengaturan = Pengaturan::first();
        $userId = auth()->id();

        // Transaksi saya hari ini
        $transaksiHariIni = Transaksi::where('user_id', $userId)
            ->whereDate('tanggal_transaksi', today())
            ->selectRaw('COUNT(*) as total_transaksi, SUM(jumlah) as total_qty, SUM(total) as total_rupiah')
            ->first();

        // Transaksi saya bulan ini
        $transaksiBulanIni = Transaksi::where('user_id', $userId)
            ->whereMonth('tanggal_transaksi', now()->month)
            ->whereYear('tanggal_transaksi', now()->year)
            ->selectRaw('COUNT(*) as total_transaksi, SUM(jumlah) as total_qty, SUM(total) as total_rupiah')
            ->first();

        // Total penjualan hari ini (semua staff)
        $penjualanTokoHariIni = Transaksi::whereDate('tanggal_transaksi', today())
            ->sum('total');

        // Grafik transaksi saya 7 hari terakhir
        $grafikTransaksi = Transaksi::where('user_id', $userId)
            ->whereBetween('tanggal_transaksi', [
                now()->subDays(6)->startOfDay(),
                now()->endOfDay()
            ])
            ->selectRaw('DATE(tanggal_transaksi) as tanggal, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Transaksi terakhir saya
        $transaksiTerakhir = Transaksi::where('user_id', $userId)
            ->orderBy('tanggal_transaksi', 'desc')
            ->limit(5)
            ->get();

        // Check stok minimum
        $alertStok = false;
        if ($pengaturan && $pengaturan->notifikasi_stok) {
            $alertStok = $stok <= $pengaturan->stok_minimum;
        }

        return view('staff.dashboard', compact(
            'stok',
            'transaksiHariIni',
            'transaksiBulanIni',
            'penjualanTokoHariIni',
            'grafikTransaksi',
            'transaksiTerakhir',
            'alertStok',
            'pengaturan'
        ));
    }
}
