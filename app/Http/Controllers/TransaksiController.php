<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\StokSekarang;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('user')
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(20);

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $stok = StokSekarang::getStok();
        $pengaturan = Pengaturan::first();

        return view('transaksi.create', compact('stok', 'pengaturan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'metode_bayar' => 'required|in:tunai,transfer,qris',
            'nama_pelanggan' => 'nullable|string|max:255',
            'telepon_pelanggan' => 'nullable|string|max:20',
            'catatan' => 'nullable|string',
        ]);

        // Cek stok
        $stokSekarang = StokSekarang::getStok();
        if ($stokSekarang < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $stokSekarang);
        }

        DB::beginTransaction();
        try {
            // Simpan transaksi
            $transaksi = Transaksi::create([
                'jumlah' => $request->jumlah,
                'harga_satuan' => $request->harga_satuan,
                'diskon' => $request->diskon ?? 0,
                'metode_bayar' => $request->metode_bayar,
                'nama_pelanggan' => $request->nama_pelanggan,
                'telepon_pelanggan' => $request->telepon_pelanggan,
                'catatan' => $request->catatan,
                'user_id' => auth()->id(),
            ]);

            // Kurangi stok
            StokSekarang::kurangiStok($request->jumlah);

            DB::commit();

            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi berhasil! Invoice: ' . $transaksi->no_invoice);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('user');
        return view('transaksi.show', compact('transaksi'));
    }

    public function destroy(Transaksi $transaksi)
    {
        DB::beginTransaction();
        try {
            // Kembalikan stok
            StokSekarang::tambahStok($transaksi->jumlah);

            $transaksi->delete();

            DB::commit();

            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
