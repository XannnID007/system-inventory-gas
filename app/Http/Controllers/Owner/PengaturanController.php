<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();
        $user = auth()->user();

        return view('owner.pengaturan.index', compact('pengaturan', 'user'));
    }

    public function updateToko(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat_toko' => 'nullable|string',
            'telepon_toko' => 'nullable|string|max:20',
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'notifikasi_stok' => 'boolean',
            'logo_toko' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pengaturan = Pengaturan::firstOrCreate(['id' => 1]);

        $data = $request->only([
            'nama_toko',
            'alamat_toko',
            'telepon_toko',
            'harga_modal',
            'harga_jual',
            'stok_minimum',
        ]);

        $data['notifikasi_stok'] = $request->has('notifikasi_stok');

        if ($request->hasFile('logo_toko')) {
            // Hapus logo lama
            if ($pengaturan->logo_toko) {
                Storage::disk('public')->delete($pengaturan->logo_toko);
            }
            $data['logo_toko'] = $request->file('logo_toko')->store('logo', 'public');
        }

        $pengaturan->update($data);

        return back()->with('success', 'Pengaturan toko berhasil diperbarui');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        $data = $request->only(['nama', 'email', 'telepon']);

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('profile', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai');
        }

        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }
}
