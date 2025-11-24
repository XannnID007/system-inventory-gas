<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\StokSekarang;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        // Staff hanya bisa lihat transaksi yang dia buat sendiri
        $transaksi = Transaksi::where('user_id', auth()->id())
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(20);

        return view('staff.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $stok = StokSekarang::getStok();
        $pengaturan = Pengaturan::first();

        return view('staff.transaksi.create', compact('stok', 'pengaturan'));
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

            return redirect()->route('staff.transaksi.index')
                ->with('success', 'Transaksi berhasil! Invoice: ' . $transaksi->no_invoice);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Transaksi $transaksi)
    {
        // Staff hanya bisa lihat transaksi sendiri
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini');
        }

        return view('staff.transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        // Staff hanya bisa edit transaksi sendiri yang dibuat hari ini
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini');
        }

        if (!$transaksi->tanggal_transaksi->isToday()) {
            return back()->with('error', 'Transaksi hanya bisa diedit pada hari yang sama');
        }

        $stok = StokSekarang::getStok();
        $pengaturan = Pengaturan::first();

        return view('staff.transaksi.edit', compact('transaksi', 'stok', 'pengaturan'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        // Staff hanya bisa edit transaksi sendiri yang dibuat hari ini
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini');
        }

        if (!$transaksi->tanggal_transaksi->isToday()) {
            return back()->with('error', 'Transaksi hanya bisa diedit pada hari yang sama');
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'metode_bayar' => 'required|in:tunai,transfer,qris',
            'nama_pelanggan' => 'nullable|string|max:255',
            'telepon_pelanggan' => 'nullable|string|max:20',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $selisihStok = $request->jumlah - $transaksi->jumlah;

            if ($selisihStok > 0) {
                // Perlu tambah stok keluar
                $stokSekarang = StokSekarang::getStok();
                if ($stokSekarang < $selisihStok) {
                    return back()->with('error', 'Stok tidak mencukupi untuk update ini!');
                }
                StokSekarang::kurangiStok($selisihStok);
            } elseif ($selisihStok < 0) {
                // Kembalikan stok
                StokSekarang::tambahStok(abs($selisihStok));
            }

            $transaksi->update([
                'jumlah' => $request->jumlah,
                'harga_satuan' => $request->harga_satuan,
                'subtotal' => $request->jumlah * $request->harga_satuan,
                'diskon' => $request->diskon ?? 0,
                'total' => ($request->jumlah * $request->harga_satuan) - ($request->diskon ?? 0),
                'metode_bayar' => $request->metode_bayar,
                'nama_pelanggan' => $request->nama_pelanggan,
                'telepon_pelanggan' => $request->telepon_pelanggan,
                'catatan' => $request->catatan,
            ]);

            DB::commit();

            return redirect()->route('staff.transaksi.index')
                ->with('success', 'Transaksi berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Transaksi $transaksi)
    {
        // Staff hanya bisa hapus transaksi sendiri yang dibuat hari ini
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini');
        }

        if (!$transaksi->tanggal_transaksi->isToday()) {
            return back()->with('error', 'Transaksi hanya bisa dihapus pada hari yang sama');
        }

        DB::beginTransaction();
        try {
            // Kembalikan stok
            StokSekarang::tambahStok($transaksi->jumlah);
            $transaksi->delete();

            DB::commit();

            return redirect()->route('staff.transaksi.index')
                ->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
