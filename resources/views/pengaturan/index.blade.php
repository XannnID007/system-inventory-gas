@extends('layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Kelola pengaturan toko dan profil')

@section('content')
    <div class="space-y-6" x-data="{ activeTab: 'toko' }">

        <!-- Tabs -->
        <div class="glass-white rounded-2xl p-2 shadow-lg">
            <div class="flex gap-2">
                <button @click="activeTab = 'toko'"
                    :class="activeTab === 'toko' ? 'gradient-purple text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100'"
                    class="flex-1 px-6 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Pengaturan Toko
                </button>
                <button @click="activeTab = 'profil'"
                    :class="activeTab === 'profil' ? 'gradient-cyan text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100'"
                    class="flex-1 px-6 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil Saya
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

        <!-- Tab: Pengaturan Toko -->
        <div x-show="activeTab === 'toko'" x-transition class="glass-white rounded-2xl p-8 shadow-xl">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Pengaturan Toko</h3>

            <form action="{{ route('pengaturan.toko.update') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Logo Toko -->
                <div class="p-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                    <label class="block text-gray-700 font-bold mb-4">Logo Toko</label>
                    <div class="flex items-center gap-6">
                        @if ($pengaturan && $pengaturan->logo_toko)
                            <img src="{{ asset('storage/' . $pengaturan->logo_toko) }}" alt="Logo"
                                class="w-24 h-24 rounded-xl object-cover shadow-lg">
                        @else
                            <div class="w-24 h-24 gradient-purple rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" name="logo_toko" accept="image/*"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200">
                            <p class="text-gray-500 text-sm mt-2">Format: JPG, PNG (Max: 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Info Toko -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Toko <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_toko" value="{{ $pengaturan->nama_toko ?? '' }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                            required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Telepon Toko</label>
                        <input type="text" name="telepon_toko" value="{{ $pengaturan->telepon_toko ?? '' }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Alamat Toko</label>
                    <textarea name="alamat_toko" rows="3"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all resize-none">{{ $pengaturan->alamat_toko ?? '' }}</textarea>
                </div>

                <!-- Harga -->
                <div class="pt-6 border-t-2 border-gray-100">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Pengaturan Harga</h4>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Harga Modal <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</div>
                                <input type="number" name="harga_modal" value="{{ $pengaturan->harga_modal ?? 0 }}"
                                    class="w-full pl-14 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                                    required>
                            </div>
                            <p class="text-gray-500 text-sm mt-2">Harga beli per tabung</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Harga Jual <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</div>
                                <input type="number" name="harga_jual" value="{{ $pengaturan->harga_jual ?? 0 }}"
                                    class="w-full pl-14 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                                    required>
                            </div>
                            <p class="text-gray-500 text-sm mt-2">Harga jual per tabung</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Margin Keuntungan</label>
                            <div class="px-4 py-3 bg-green-100 border-2 border-green-300 rounded-xl">
                                @if ($pengaturan)
                                    <p class="font-bold text-green-700 text-lg">Rp
                                        {{ number_format($pengaturan->margin, 0, ',', '.') }}</p>
                                    <p class="text-green-600 text-xs">
                                        {{ number_format($pengaturan->persentase_margin, 1) }}%</p>
                                @else
                                    <p class="font-bold text-green-700">Rp 0</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stok Alert -->
                <div class="pt-6 border-t-2 border-gray-100">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Notifikasi Stok</h4>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Stok Minimum <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="stok_minimum" value="{{ $pengaturan->stok_minimum ?? 10 }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                                required>
                            <p class="text-gray-500 text-sm mt-2">Alert akan muncul jika stok ≤ nilai ini</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-4">Status Notifikasi</label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="notifikasi_stok" value="1"
                                    {{ $pengaturan && $pengaturan->notifikasi_stok ? 'checked' : '' }}
                                    class="w-6 h-6 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                <span class="text-gray-700 font-semibold">Aktifkan notifikasi stok menipis</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full px-6 py-4 gradient-purple text-white font-bold rounded-xl hover:shadow-lg hover:shadow-purple-500/50 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Pengaturan Toko
                </button>
            </form>
        </div>

        <!-- Tab: Profil Saya -->
        <div x-show="activeTab === 'profil'" x-transition class="glass-white rounded-2xl p-8 shadow-xl">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Profil Saya</h3>

            <form action="{{ route('pengaturan.profile.update') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Foto Profil -->
                <div class="p-6 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-xl">
                    <label class="block text-gray-700 font-bold mb-4">Foto Profil</label>
                    <div class="flex items-center gap-6">
                        @if ($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto"
                                class="w-24 h-24 rounded-full object-cover shadow-lg">
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
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ $user->nama }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100 transition-all"
                            required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ $user->email }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100 transition-all"
                            required>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nomor Telepon</label>
                    <input type="text" name="telepon" value="{{ $user->telepon }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100 transition-all"
                        placeholder="08xxx">
                </div>

                <button type="submit"
                    class="w-full px-6 py-4 gradient-cyan text-white font-bold rounded-xl hover:shadow-lg hover:shadow-cyan-500/50 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Profil
                </button>
            </form>
        </div>

        <!-- Tab: Ubah Password -->
        <div x-show="activeTab === 'password'" x-transition class="glass-white rounded-2xl p-8 shadow-xl">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Ubah Password</h3>

            <form action="{{ route('pengaturan.password.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="p-4 bg-yellow-50 border-2 border-yellow-200 rounded-xl">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="text-yellow-800 font-bold">Perhatian!</p>
                            <p class="text-yellow-700 text-sm">Pastikan password baru Anda kuat dan mudah diingat. Anda
                                akan logout setelah mengubah password.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Password Lama <span
                            class="text-red-500">*</span></label>
                    <input type="password" name="password_lama"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Password Baru <span
                            class="text-red-500">*</span></label>
                    <input type="password" name="password_baru"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all"
                        required minlength="8">
                    <p class="text-gray-500 text-sm mt-2">Minimal 8 karakter</p>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password Baru <span
                            class="text-red-500">*</span></label>
                    <input type="password" name="password_baru_confirmation"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all"
                        required>
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
