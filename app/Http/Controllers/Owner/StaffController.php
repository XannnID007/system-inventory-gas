<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::where('role', 'staff')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('owner.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('owner.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telepon' => $request->telepon,
            'role' => 'staff',
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('profile', 'public');
        }

        User::create($data);

        return redirect()->route('owner.staff.index')
            ->with('success', 'Staff berhasil ditambahkan!');
    }

    public function edit(User $staff)
    {
        // Pastikan yang diedit adalah staff, bukan owner
        if ($staff->isOwner()) {
            abort(403, 'Tidak dapat mengedit data owner');
        }

        return view('owner.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        // Pastikan yang diupdate adalah staff, bukan owner
        if ($staff->isOwner()) {
            abort(403, 'Tidak dapat mengubah data owner');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($staff->id)],
            'password' => 'nullable|min:8|confirmed',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            if ($staff->foto) {
                Storage::disk('public')->delete($staff->foto);
            }
            $data['foto'] = $request->file('foto')->store('profile', 'public');
        }

        $staff->update($data);

        return redirect()->route('owner.staff.index')
            ->with('success', 'Data staff berhasil diperbarui!');
    }

    public function destroy(User $staff)
    {
        // Pastikan yang dihapus adalah staff, bukan owner
        if ($staff->isOwner()) {
            abort(403, 'Tidak dapat menghapus data owner');
        }

        // Hapus foto jika ada
        if ($staff->foto) {
            Storage::disk('public')->delete($staff->foto);
        }

        $staff->delete();

        return redirect()->route('owner.staff.index')
            ->with('success', 'Staff berhasil dihapus!');
    }
}
