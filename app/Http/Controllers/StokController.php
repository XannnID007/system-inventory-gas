<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\PenyesuaianStok;
use App\Models\StokSekarang;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StokController extends Controller
{
    public function index()
    {
        $stokSekarang = StokSekarang::getStok();
        $stokMasuk = StokMasuk::with('user')->orderBy('created_at', 'desc')->paginate(15);
        $penyesuaian = PenyesuaianStok::with('user')->orderBy('created_at', 'desc')->paginate(15);

        return view('stok.index', compact('stokSekarang', 'stokMasuk', 'penyesuaian'));
    }

    public function storeStokMasuk(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
            'tanggal_beli' => 'required|date',
            'supplier' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['jumlah', 'harga_beli', 'tanggal_beli', 'supplier', 'catatan']);
            $data['user_id'] = auth()->id();

            // Upload foto bukti jika ada
            if ($request->hasFile('foto_bukti')) {
                $data['foto_bukti'] = $request->file('foto_bukti')->store('bukti-stok', 'public');
            }

            $stokMasuk = StokMasuk::create($data);

            // Tambah stok
            StokSekarang::tambahStok($request->jumlah);

            DB::commit();

            return back()->with('success', 'Stok berhasil ditambahkan! Kode: ' . $stokMasuk->kode);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storePenyesuaian(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'tipe' => 'required|in:penambahan,pengurangan',
            'alasan' => 'required|in:rusak,hilang,ditemukan,koreksi,lainnya',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['jumlah', 'tipe', 'alasan', 'catatan']);
            $data['user_id'] = auth()->id();

            $penyesuaian = PenyesuaianStok::create($data);

            // Update stok
            if ($request->tipe === 'penambahan') {
                StokSekarang::tambahStok($request->jumlah);
            } else {
                StokSekarang::kurangiStok($request->jumlah);
            }

            DB::commit();

            return back()->with('success', 'Penyesuaian stok berhasil! Kode: ' . $penyesuaian->kode);
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
