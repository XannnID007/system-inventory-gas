<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

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

        // Top 5 Staff Performer
        $topStaff = Transaksi::with('user')
            ->whereBetween('tanggal_transaksi', [$periodeAwal, $periodeAkhir])
            ->selectRaw('user_id, COUNT(*) as total_transaksi, SUM(jumlah) as total_qty, SUM(total) as total_penjualan')
            ->groupBy('user_id')
            ->orderByDesc('total_penjualan')
            ->limit(5)
            ->get();

        return view('owner.laporan.index', compact(
            'periodeAwal',
            'periodeAkhir',
            'penjualan',
            'stokMasuk',
            'keuntungan',
            'grafikPenjualan',
            'metodeBayar',
            'topStaff'
        ));
    }

    public function exportPdf(Request $request)
    {
        $periodeAwal = $request->input('tanggal_awal', now()->startOfMonth()->format('Y-m-d'));
        $periodeAkhir = $request->input('tanggal_akhir', now()->format('Y-m-d'));

        // Get data
        $penjualan = Transaksi::whereBetween('tanggal_transaksi', [$periodeAwal, $periodeAkhir])
            ->selectRaw('
                COUNT(*) as total_transaksi,
                SUM(jumlah) as total_qty,
                SUM(total) as total_pendapatan,
                AVG(total) as rata_rata_transaksi
            ')
            ->first();

        $stokMasuk = StokMasuk::whereBetween('tanggal_beli', [$periodeAwal, $periodeAkhir])
            ->selectRaw('SUM(jumlah) as total_qty, SUM(total_modal) as total_modal')
            ->first();

        $keuntungan = ($penjualan->total_pendapatan ?? 0) - ($stokMasuk->total_modal ?? 0);

        $metodeBayar = Transaksi::whereBetween('tanggal_transaksi', [$periodeAwal, $periodeAkhir])
            ->selectRaw('metode_bayar, COUNT(*) as jumlah, SUM(total) as total')
            ->groupBy('metode_bayar')
            ->get();

        $topStaff = Transaksi::with('user')
            ->whereBetween('tanggal_transaksi', [$periodeAwal, $periodeAkhir])
            ->selectRaw('user_id, COUNT(*) as total_transaksi, SUM(jumlah) as total_qty, SUM(total) as total_penjualan')
            ->groupBy('user_id')
            ->orderByDesc('total_penjualan')
            ->limit(5)
            ->get();

        $detailTransaksi = Transaksi::with('user')
            ->whereBetween('tanggal_transaksi', [$periodeAwal, $periodeAkhir])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $pengaturan = \App\Models\Pengaturan::first();

        $pdf = Pdf::loadView('owner.laporan.pdf', compact(
            'periodeAwal',
            'periodeAkhir',
            'penjualan',
            'stokMasuk',
            'keuntungan',
            'metodeBayar',
            'topStaff',
            'detailTransaksi',
            'pengaturan'
        ));

        $pdf->setPaper('a4', 'portrait');

        $filename = 'Laporan_' . date('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $periodeAwal = $request->input('tanggal_awal', now()->startOfMonth()->format('Y-m-d'));
        $periodeAkhir = $request->input('tanggal_akhir', now()->format('Y-m-d'));

        $filename = 'Laporan_' . date('Ymd_His') . '.xlsx';

        return Excel::download(new LaporanExport($periodeAwal, $periodeAkhir), $filename);
    }
}
