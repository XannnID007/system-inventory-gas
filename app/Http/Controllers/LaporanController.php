<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\StokMasuk;
use App\Models\StokSekarang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periodeAwal = $request->input('tanggal_awal', now()->startOfMonth()->format('Y-m-d'));
        $periodeAkhir = $request->input('tanggal_akhir', now()->format('Y-m-d'));

        // Laporan Penjualan
        $penjualan = Transaksi::whereBetween('tanggal_transaksi', [$periodeAwal, $periodeAkhir])
            ->selectRaw('
                COUNT(*) as total_transaksi,
                SUM(jumlah) as total_qty,
                SUM(total) as total_pendapatan,
                AVG(total) as rata_rata_transaksi
            ')
            ->first();

        // Laporan Stok Masuk
        $stokMasuk = StokMasuk::whereBetween('tanggal_beli', [$periodeAwal, $periodeAkhir])
            ->selectRaw('
                SUM(jumlah) as total_qty,
                SUM(total_modal) as total_modal
            ')
            ->first();

        // Keuntungan Kotor
        $keuntungan = ($penjualan->total_pendapatan ?? 0) - ($stokMasuk->total_modal ?? 0);

        // Grafik Penjualan per hari
        $grafikPenjualan = Transaksi::whereBetween('tanggal_transaksi', [$periodeAwal, $periodeAkhir])
            ->selectRaw('DATE(tanggal_transaksi) as tanggal, SUM(jumlah) as qty, SUM(total) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Metode Pembayaran
        $metodeBayar = Transaksi::whereBetween('tanggal_transaksi', [$periodeAwal, $periodeAkhir])
            ->selectRaw('metode_bayar, COUNT(*) as jumlah, SUM(total) as total')
            ->groupBy('metode_bayar')
            ->get();

        return view('laporan.index', compact(
            'periodeAwal',
            'periodeAkhir',
            'penjualan',
            'stokMasuk',
            'keuntungan',
            'grafikPenjualan',
            'metodeBayar'
        ));
    }
}
