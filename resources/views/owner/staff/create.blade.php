@extends('layouts.app')

@section('title', 'Tambah Staff')
@section('page-title', 'Tambah Staff Baru')
@section('page-subtitle', 'Form tambah staff/pegawai')

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
            <form action="{{ route('owner.staff.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="p-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                    <label class="block text-gray-700 font-bold mb-4">Foto Profil (Opsional)</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200">
                    <p class="text-gray-500 text-sm mt-2">Format: JPG, PNG (Max: 2MB)</p>
                    @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                            placeholder="Nama lengkap staff">
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                            placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nomor Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                        placeholder="08xxx">
                    @error('telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-6 pt-4 border-t-2 border-gray-100">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required
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
                        Simpan Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
