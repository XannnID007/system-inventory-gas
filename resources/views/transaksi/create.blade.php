@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page-title', 'Buat Transaksi Penjualan')
@section('page-subtitle', 'Form penjualan gas LPG 3kg')

@section('content')
    <div class="max-w-4xl mx-auto">

        <!-- Info Stok -->
        <div class="glass-white rounded-2xl p-6 mb-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 gradient-purple rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Stok Tersedia</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ number_format($stok, 0, ',', '.') }} Tabung</p>
                    </div>
                </div>
                @if ($pengaturan)
                    <div class="text-right">
                        <p class="text-gray-500 text-sm font-medium">Harga Jual</p>
                        <p class="text-2xl font-bold text-purple-600">Rp
                            {{ number_format($pengaturan->harga_jual, 0, ',', '.') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Form Transaksi -->
        <form action="{{ route('transaksi.store') }}" method="POST" x-data="transaksiForm()"
            class="glass-white rounded-2xl p-8 shadow-xl">
            @csrf

            <div class="space-y-6">

                <!-- Jumlah Tabung -->
                <div>
                    <label class="block text-gray-700 font-bold mb-3">Jumlah Tabung <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="jumlah" x-model.number="jumlah" @input="calculateTotal" min="1"
                            max="{{ $stok }}"
                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all text-lg font-semibold"
                            placeholder="Masukkan jumlah tabung" required>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2">
                            <span class="text-gray-400 font-medium">Tabung</span>
                        </div>
                    </div>
                    @error('jumlah')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-2">Stok maksimal: {{ $stok }} tabung</p>
                </div>

                <!-- Harga Satuan -->
                <div>
                    <label class="block text-gray-700 font-bold mb-3">Harga per Tabung <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</div>
                        <input type="number" name="harga_satuan" x-model.number="hargaSatuan" @input="calculateTotal"
                            value="{{ $pengaturan ? $pengaturan->harga_jual : '' }}"
                            class="w-full pl-14 pr-5 py-4 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all text-lg font-semibold"
                            placeholder="0" required>
                    </div>
                    @error('harga_satuan')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subtotal (Read Only) -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-5 border-2 border-purple-200">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 font-bold text-lg">Subtotal</span>
                        <span class="text-3xl font-extrabold text-purple-600" x-text="formatRupiah(subtotal)">Rp 0</span>
                    </div>
                </div>

                <!-- Diskon (Optional) -->
                <div x-data="{ showDiskon: false }">
                    <button type="button" @click="showDiskon = !showDiskon"
                        class="flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span x-text="showDiskon ? 'Sembunyikan Diskon' : 'Tambah Diskon'"></span>
                    </button>

                    <div x-show="showDiskon" x-transition class="mb-4">
                        <label class="block text-gray-700 font-bold mb-3">Diskon (Opsional)</label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</div>
                            <input type="number" name="diskon" x-model.number="diskon" @input="calculateTotal"
                                class="w-full pl-14 pr-5 py-4 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all text-lg font-semibold"
                                placeholder="0" min="0">
                        </div>
                        @error('diskon')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Total Bayar -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border-2 border-green-300">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 font-bold text-xl">Total Bayar</span>
                        <span class="text-4xl font-extrabold text-green-600" x-text="formatRupiah(total)">Rp 0</span>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <label class="block text-gray-700 font-bold mb-3">Metode Pembayaran <span
                            class="text-red-500">*</span></label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="metode_bayar" value="tunai" class="peer sr-only" checked>
                            <div
                                class="p-4 border-2 border-gray-200 rounded-xl text-center peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all hover:border-purple-300">
                                <svg class="w-8 h-8 text-gray-400 peer-checked:text-purple-600 mx-auto mb-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="font-semibold text-gray-700">Tunai</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="metode_bayar" value="transfer" class="peer sr-only">
                            <div
                                class="p-4 border-2 border-gray-200 rounded-xl text-center peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all hover:border-purple-300">
                                <svg class="w-8 h-8 text-gray-400 peer-checked:text-purple-600 mx-auto mb-2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span class="font-semibold text-gray-700">Transfer</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="metode_bayar" value="qris" class="peer sr-only">
                            <div
                                class="p-4 border-2 border-gray-200 rounded-xl text-center peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all hover:border-purple-300">
                                <svg class="w-8 h-8 text-gray-400 peer-checked:text-purple-600 mx-auto mb-2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                                <span class="font-semibold text-gray-700">QRIS</span>
                            </div>
                        </label>
                    </div>
                    @error('metode_bayar')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data Pelanggan (Optional) -->
                <div x-data="{ showPelanggan: false }" class="border-t-2 border-gray-100 pt-6">
                    <button type="button" @click="showPelanggan = !showPelanggan"
                        class="flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span
                            x-text="showPelanggan ? 'Sembunyikan Data Pelanggan' : 'Tambah Data Pelanggan (Opsional)'"></span>
                    </button>

                    <div x-show="showPelanggan" x-transition class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                                placeholder="Nama pelanggan (opsional)">
                            @error('nama_pelanggan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                            <input type="text" name="telepon_pelanggan"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all"
                                placeholder="08xxx (opsional)">
                            @error('telepon_pelanggan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan" rows="3"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all resize-none"
                        placeholder="Tambahkan catatan transaksi..."></textarea>
                    @error('catatan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 mt-8 pt-6 border-t-2 border-gray-100">
                <a href="{{ route('transaksi.index') }}"
                    class="flex-1 px-6 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all text-center">
                    Batal
                </a>
                <button type="submit"
                    class="flex-1 px-6 py-4 gradient-purple text-white font-bold rounded-xl hover:shadow-lg hover:shadow-purple-500/50 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Proses Transaksi
                </button>
            </div>
        </form>

    </div>

    @push('scripts')
        <script>
            function transaksiForm() {
                return {
                    jumlah: 0,
                    hargaSatuan: {{ $pengaturan ? $pengaturan->harga_jual : 0 }},
                    diskon: 0,
                    subtotal: 0,
                    total: 0,

                    calculateTotal() {
                        this.subtotal = this.jumlah * this.hargaSatuan;
                        this.total = this.subtotal - this.diskon;

                        if (this.total < 0) {
                            this.total = 0;
                        }
                    },

                    formatRupiah(number) {
                        if (isNaN(number) || number === 0) {
                            return 'Rp 0';
                        }
                        return 'Rp ' + number.toLocaleString('id-ID');
                    }
                }
            }
        </script>
    @endpush
@endsection
