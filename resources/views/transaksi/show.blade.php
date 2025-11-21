@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', 'Informasi lengkap transaksi penjualan')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Back Button -->
        <div>
            <a href="{{ route('transaksi.index') }}"
                class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Transaksi
            </a>
        </div>

        <!-- Invoice Header -->
        <div class="glass-white rounded-2xl p-8 shadow-xl">
            <div class="flex items-start justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $transaksi->no_invoice }}</h2>
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-2 bg-green-100 text-green-700 rounded-xl text-sm font-bold">
                            Lunas
                        </span>
                        <span
                            class="px-4 py-2 {{ $transaksi->metode_bayar === 'tunai' ? 'bg-blue-100 text-blue-700' : ($transaksi->metode_bayar === 'transfer' ? 'bg-purple-100 text-purple-700' : 'bg-pink-100 text-pink-700') }} rounded-xl text-sm font-bold">
                            {{ ucfirst($transaksi->metode_bayar) }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-sm font-medium mb-1">Tanggal Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</p>
                    <p class="text-gray-600 text-sm">{{ $transaksi->tanggal_transaksi->format('H:i') }} WIB</p>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Info Pelanggan -->
                <div class="p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 gradient-cyan rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Informasi Pelanggan</h3>
                    </div>
                    @if ($transaksi->nama_pelanggan)
                        <div class="space-y-2">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Nama</p>
                                <p class="text-gray-900 font-bold text-lg">{{ $transaksi->nama_pelanggan }}</p>
                            </div>
                            @if ($transaksi->telepon_pelanggan)
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Telepon</p>
                                    <p class="text-gray-900 font-semibold">{{ $transaksi->telepon_pelanggan }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-400 italic">Pelanggan Umum</p>
                    @endif
                </div>

                <!-- Info Kasir -->
                <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 gradient-green rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Informasi Kasir</h3>
                    </div>
                    <div class="space-y-2">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Nama Kasir</p>
                            <p class="text-gray-900 font-bold text-lg">{{ $transaksi->user->nama }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Email</p>
                            <p class="text-gray-900 font-semibold">{{ $transaksi->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Transaksi -->
            <div class="border-2 border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b-2 border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Rincian Pembelian</h3>
                </div>
                <div class="p-6">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 text-gray-700 font-bold">Item</th>
                                <th class="text-center py-3 text-gray-700 font-bold">Jumlah</th>
                                <th class="text-right py-3 text-gray-700 font-bold">Harga Satuan</th>
                                <th class="text-right py-3 text-gray-700 font-bold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 gradient-purple rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">Gas LPG 3kg</p>
                                            <p class="text-gray-500 text-sm">Tabung gas elpiji 3 kilogram</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 text-center">
                                    <span class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg font-bold text-lg">
                                        {{ $transaksi->jumlah }}
                                    </span>
                                </td>
                                <td class="py-4 text-right font-semibold text-gray-900">
                                    Rp {{ number_format($transaksi->harga_satuan, 0, ',', '.') }}
                                </td>
                                <td class="py-4 text-right font-bold text-gray-900 text-lg">
                                    Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Summary -->
                    <div class="mt-6 pt-6 border-t-2 border-gray-200">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-semibold">Subtotal</span>
                                <span class="text-gray-900 font-bold text-lg">Rp
                                    {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if ($transaksi->diskon > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-semibold">Diskon</span>
                                    <span class="text-red-600 font-bold text-lg">- Rp
                                        {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between items-center pt-3 border-t-2 border-gray-200">
                                <span class="text-gray-900 font-bold text-xl">Total Bayar</span>
                                <span class="text-3xl font-extrabold text-green-600">Rp
                                    {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            @if ($transaksi->catatan)
                <div class="mt-6 p-4 bg-yellow-50 border-2 border-yellow-200 rounded-xl">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <div>
                            <p class="text-yellow-800 font-bold mb-1">Catatan</p>
                            <p class="text-yellow-700">{{ $transaksi->catatan }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-4 mt-8 pt-6 border-t-2 border-gray-200">
                <button onclick="window.print()"
                    class="flex-1 px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Invoice
                </button>
                <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok akan dikembalikan.')"
                    class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full px-6 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Transaksi
                    </button>
                </form>
            </div>
        </div>

    </div>

    <style>
        @media print {

            .sidebar,
            header,
            button,
            a {
                display: none !important;
            }

            .glass-white {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
@endsection
