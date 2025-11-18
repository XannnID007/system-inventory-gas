<?php

namespace App\Http\Controllers;

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

        if ($tipe === 'penjualan') {
            $query = Transaksi::with('user')->orderBy('tanggal_transaksi', 'desc');

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal_transaksi', [$tanggalAwal, $tanggalAkhir]);
            }

            $data = $query->paginate(20);
        } elseif ($tipe === 'stok_masuk') {
            $query = StokMasuk::with('user')->orderBy('tanggal_beli', 'desc');

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal_beli', [$tanggalAwal, $tanggalAkhir]);
            }

            $data = $query->paginate(20);
        } else {
            $query = PenyesuaianStok::with('user')->orderBy('created_at', 'desc');

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
            }

            $data = $query->paginate(20);
        }

        return view('riwayat.index', compact('data', 'tipe', 'tanggalAwal', 'tanggalAkhir'));
    }
}
