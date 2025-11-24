@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi profil dan keamanan akun')

@section('content')
    <div class="space-y-6" x-data="{ activeTab: 'profil' }">

        <!-- Tabs -->
        <div class="glass-white rounded-2xl p-2 shadow-lg">
            <div class="flex gap-2">
                <button @click="activeTab = 'profil'"
                    :class="activeTab === 'profil' ? 'gradient-cyan text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100'"
                    class="flex-1 px-6 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Edit Profil
                </button>

                <button @click="activeTab = 'password'"
                    :class="activeTab === 'password' ? 'gradient-orange text-white shadow-lg' :
                        'text-gray-600 hover:bg-gray-100'"
                    class="flex-1 px-6 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Ubah Password
                </button>
            </div>
        </div>

        <!-- Tab: Edit Profil -->
        <div x-show="activeTab === 'profil'" x-transition class="glass-white rounded-2xl p-8 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 gradient-cyan rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Informasi Profil</h3>
                    <p class="text-gray-600 text-sm">Update informasi profil Anda</p>
                </div>
            </div>

            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Role Badge -->
                <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border-2 border-purple-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 gradient-purple rounded-xl flex items-center justify-center">
                            @if (auth()->user()->isOwner())
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Role Anda</p>
                            <p class="text-xl font-bold text-purple-700">{{ auth()->user()->role_label }}</p>
                        </div>
                    </div>
                </div>

                <!-- Foto Profil -->
                <div class="p-6 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-xl">
                    <label class="block text-gray-700 font-bold mb-4">Foto Profil</label>
                    <div class="flex items-center gap-6">
                        @if ($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto"
                                class="w-24 h-24 rounded-full object-cover shadow-lg border-4 border-white">
                        @else
                            <div
                                class="w-24 h-24 gradient-cyan rounded-full flex items-center justify-center text-white font-bold text-3xl shadow-lg">
                                {{ strtoupper(substr($user->nama, 0, 2)) }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" name="foto" accept="image/*"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-cyan-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-cyan-100 file:text-cyan-700 hover:file:bg-cyan-200">
                            <p class="text-gray-500 text-sm mt-2">Format: JPG, PNG (Max: 2MB)</p>
                            @error('foto')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100 transition-all"
                            placeholder="Nama lengkap">
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100 transition-all"
                            placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nomor Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $user->telepon) }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100 transition-all"
                        placeholder="08xxx">
                    @error('telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-blue-50 border-2 border-blue-200 rounded-xl">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-blue-800 font-bold text-sm">Informasi Akun</p>
                            <p class="text-blue-700 text-sm">
                                Terdaftar sejak: <strong>{{ $user->created_at->translatedFormat('d F Y') }}</strong>
                                ({{ $user->created_at->diffForHumans() }})
                            </p>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full px-6 py-4 gradient-cyan text-white font-bold rounded-xl hover:shadow-lg hover:shadow-cyan-500/50 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Tab: Ubah Password -->
        <div x-show="activeTab === 'password'" x-transition class="glass-white rounded-2xl p-8 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 gradient-orange rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Ubah Password</h3>
                    <p class="text-gray-600 text-sm">Perbarui password untuk keamanan akun</p>
                </div>
            </div>

            <form action="{{ route('profil.password.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Warning Box -->
                <div class="p-4 bg-yellow-50 border-2 border-yellow-200 rounded-xl">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="text-yellow-800 font-bold">Perhatian!</p>
                            <p class="text-yellow-700 text-sm">Pastikan password baru Anda kuat dan mudah diingat. Gunakan
                                kombinasi huruf besar, huruf kecil, angka, dan simbol.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Password Lama <span
                            class="text-red-500">*</span></label>
                    <input type="password" name="password_lama" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all"
                        placeholder="Masukkan password lama">
                    @error('password_lama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Password Baru <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password_baru" required minlength="8"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all"
                            placeholder="Minimal 8 karakter">
                        @error('password_baru')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-2">Minimal 8 karakter</p>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password Baru <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password_baru_confirmation" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all"
                            placeholder="Ulangi password baru">
                    </div>
                </div>

                <!-- Tips Box -->
                <div class="p-4 bg-green-50 border-2 border-green-200 rounded-xl">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-green-800 font-bold text-sm mb-2">Tips Password yang Kuat:</p>
                            <ul class="text-green-700 text-sm space-y-1">
                                <li>✓ Minimal 8 karakter</li>
                                <li>✓ Kombinasi huruf besar dan kecil</li>
                                <li>✓ Gunakan angka dan simbol</li>
                                <li>✓ Hindari kata-kata umum</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full px-6 py-4 gradient-orange text-white font-bold rounded-xl hover:shadow-lg hover:shadow-orange-500/50 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Ubah Password
                </button>
            </form>
        </div>

    </div>
@endsection
