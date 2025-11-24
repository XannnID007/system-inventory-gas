<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\StokMasuk;
use App\Models\PenyesuaianStok;
use App\Models\StokSekarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $tipe = $request->input('tipe', 'penjualan');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if ($tipe === 'penjualan') {
            // Owner bisa lihat semua transaksi
            $query = Transaksi::with('user')->orderBy('tanggal_transaksi', 'desc');

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal_transaksi', [$tanggalAwal, $tanggalAkhir]);
            }

            $data = $query->paginate(20);
        } elseif ($tipe === 'stok_masuk') {
            // Owner bisa lihat semua stok masuk
            $query = StokMasuk::with('user')->orderBy('tanggal_beli', 'desc');

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal_beli', [$tanggalAwal, $tanggalAkhir]);
            }

            $data = $query->paginate(20);
        } else {
            // Owner bisa lihat semua penyesuaian
            $query = PenyesuaianStok::with('user')->orderBy('created_at', 'desc');

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
            }

            $data = $query->paginate(20);
        }

        return view('owner.riwayat.index', compact('data', 'tipe', 'tanggalAwal', 'tanggalAkhir'));
    }

    public function destroyTransaksi(Transaksi $transaksi)
    {
        DB::beginTransaction();
        try {
            // Kembalikan stok
            StokSekarang::tambahStok($transaksi->jumlah);
            $transaksi->delete();

            DB::commit();

            return back()->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroyStokMasuk(StokMasuk $stokMasuk)
    {
        DB::beginTransaction();
        try {
            // Kurangi stok
            StokSekarang::kurangiStok($stokMasuk->jumlah);

            // Hapus foto jika ada
            if ($stokMasuk->foto_bukti) {
                Storage::disk('public')->delete($stokMasuk->foto_bukti);
            }

            $stokMasuk->delete();

            DB::commit();

            return back()->with('success', 'Data stok masuk berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
