<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\StokMasuk;
use App\Models\PenyesuaianStok;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $tipe = $request->input('tipe', 'penjualan');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $userId = auth()->id();

        if ($tipe === 'penjualan') {
            // Staff hanya lihat transaksi sendiri
            $query = Transaksi::where('user_id', $userId)
                ->orderBy('tanggal_transaksi', 'desc');

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal_transaksi', [$tanggalAwal, $tanggalAkhir]);
            }

            $data = $query->paginate(20);
        } elseif ($tipe === 'stok_masuk') {
            // Staff hanya lihat stok masuk yang dia input
            $query = StokMasuk::where('user_id', $userId)
                ->orderBy('tanggal_beli', 'desc');

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal_beli', [$tanggalAwal, $tanggalAkhir]);
            }

            $data = $query->paginate(20);
        } else {
            // Staff hanya lihat penyesuaian yang dia buat
            $query = PenyesuaianStok::where('user_id', $userId)
                ->orderBy('created_at', 'desc');

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
            }

            $data = $query->paginate(20);
        }

        return view('staff.riwayat.index', compact('data', 'tipe', 'tanggalAwal', 'tanggalAkhir'));
    }
}
