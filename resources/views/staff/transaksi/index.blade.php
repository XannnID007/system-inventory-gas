@extends('layouts.app')

@section('title', 'Daftar Transaksi')
@section('page-title', 'Kelola Transaksi')
@section('page-subtitle', 'Daftar semua transaksi penjualan')

@section('content')
    <div class="space-y-6">

        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-white font-bold text-2xl mb-1">Daftar Transaksi</h3>
                <p class="text-purple-300 text-sm">Total {{ $transaksi->total() }} transaksi</p>
            </div>
            <a href="{{ route('staff.transaksi.create') }}"
                class="px-6 py-3 gradient-purple text-white font-bold rounded-xl hover:shadow-lg hover:shadow-purple-500/50 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Transaksi Baru
            </a>
        </div>

        <!-- Filter & Search -->
        <div class="glass-white rounded-2xl p-6 shadow-lg">
            <form action="{{ route('staff.transaksi.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari invoice, pelanggan..."
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-6 py-3 gradient-purple text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    <a href="{{ route('staff.transaksi.index') }}"
                        class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Transaksi List -->
        <div class="glass-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-purple-50 to-pink-50">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No
                                Invoice</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Pelanggan</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Jumlah
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Total
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Metode</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($transaksi as $item)
                            <tr class="hover:bg-purple-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-10 h-10 gradient-cyan rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $item->no_invoice }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->user->nama }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">{{ $item->tanggal_transaksi->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $item->tanggal_transaksi->format('H:i') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->nama_pelanggan)
                                        <p class="font-semibold text-gray-900">{{ $item->nama_pelanggan }}</p>
                                        @if ($item->telepon_pelanggan)
                                            <p class="text-xs text-gray-500">{{ $item->telepon_pelanggan }}</p>
                                        @endif
                                    @else
                                        <span class="text-gray-400 italic">Umum</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold">
                                        {{ $item->jumlah }} Tabung
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <p class="font-bold text-gray-900 text-lg">Rp
                                        {{ number_format($item->total, 0, ',', '.') }}</p>
                                    @if ($item->diskon > 0)
                                        <p class="text-xs text-green-600">Diskon: Rp
                                            {{ number_format($item->diskon, 0, ',', '.') }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($item->metode_bayar === 'tunai')
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Tunai
                                        </span>
                                    @elseif($item->metode_bayar === 'transfer')
                                        <span
                                            class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            Transfer
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                            </svg>
                                            QRIS
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('staff.transaksi.show', $item->id) }}"
                                            class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors"
                                            title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('staff.transaksi.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok akan dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500 font-semibold text-lg mb-2">Belum ada transaksi</p>
                                    <p class="text-gray-400 mb-4">Mulai buat transaksi penjualan pertama Anda</p>
                                    <a href="{{ route('staff.transaksi.create') }}"
                                        class="inline-flex items-center gap-2 px-6 py-3 gradient-purple text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Buat Transaksi
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($transaksi->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $transaksi->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
