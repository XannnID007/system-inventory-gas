@extends('layouts.app')

@section('title', 'Edit Staff')
@section('page-title', 'Edit Data Staff')
@section('page-subtitle', 'Form edit staff/pegawai')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <div>
            <a href="{{ route('owner.staff.index') }}"
                class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="glass-white rounded-2xl p-8 shadow-xl">
            <form action="{{ route('owner.staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="p-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                    <label class="block text-gray-700 font-bold mb-4">Foto Profil</label>
                    <div class="flex items-center gap-6 mb-4">
                        @if ($staff->foto)
                            <img src="{{ asset('storage/' . $staff->foto) }}" alt="Foto"
                                class="w-24 h-24 rounded-full object-cover shadow-lg">
                        @else
                            <div
                                class="w-24 h-24 gradient-cyan rounded-full flex items-center justify-center text-white font-bold text-3xl shadow-lg">
                                {{ strtoupper(substr($staff->nama, 0, 2)) }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" name="foto" accept="image/*"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200">
                        </div>
                    </div>
                    @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $staff->nama) }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $staff->email) }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nomor Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $staff->telepon) }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                    @error('telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 bg-blue-50 border-2 border-blue-200 rounded-xl">
                    <p class="text-blue-800 font-semibold text-sm">💡 Kosongkan password jika tidak ingin mengubahnya</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Password Baru</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <div class="flex gap-4 pt-6 border-t-2 border-gray-100">
                    <a href="{{ route('owner.staff.index') }}"
                        class="flex-1 px-6 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 px-6 py-4 gradient-purple text-white font-bold rounded-xl hover:shadow-lg hover:shadow-purple-500/50 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
