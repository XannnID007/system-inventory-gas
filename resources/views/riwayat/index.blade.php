@extends('layouts.app')

@section('title', 'Riwayat')
@section('page-title', 'Riwayat Aktivitas')
@section('page-subtitle', 'Semua riwayat transaksi dan stok')

@section('content')
    <div class="space-y-6">

        <!-- Filter & Tabs -->
        <div class="glass-white rounded-2xl p-6 shadow-lg">
            <form action="{{ route('riwayat.index') }}" method="GET" class="space-y-4">
                <!-- Tabs -->
                <div class="flex gap-2 p-2 bg-gray-100 rounded-xl">
                    <button type="submit" name="tipe" value="penjualan"
                        class="flex-1 px-4 py-3 rounded-lg font-bold transition-all {{ $tipe === 'penjualan' ? 'gradient-purple text-white shadow-lg' : 'text-gray-600 hover:bg-gray-200' }}">
                        Penjualan
                    </button>
                    <button type="submit" name="tipe" value="stok_masuk"
                        class="flex-1 px-4 py-3 rounded-lg font-bold transition-all {{ $tipe === 'stok_masuk' ? 'gradient-green text-white shadow-lg' : 'text-gray-600 hover:bg-gray-200' }}">
                        Stok Masuk
                    </button>
                    <button type="submit" name="tipe" value="penyesuaian"
                        class="flex-1 px-4 py-3 rounded-lg font-bold transition-all {{ $tipe === 'penyesuaian' ? 'gradient-orange text-white shadow-lg' : 'text-gray-600 hover:bg-gray-200' }}">
                        Penyesuaian
                    </button>
                </div>

                <!-- Filter Tanggal -->
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 font-semibold mb-2">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" value="{{ $tanggalAwal }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 font-semibold mb-2">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="px-6 py-3 gradient-purple text-white font-bold rounded-xl hover:shadow-lg transition-all">
                            Filter
                        </button>
                        <a href="{{ route('riwayat.index') }}"
                            class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition-all">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Content berdasarkan tipe -->
        @if ($tipe === 'penjualan')
            <!-- Riwayat Penjualan -->
            <div class="glass-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                    <h3 class="text-xl font-bold text-gray-900">Riwayat Penjualan</h3>
                    <p class="text-gray-600 text-sm">Total: {{ $data->total() }} transaksi</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Invoice</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Pelanggan</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Jumlah</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Total</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Metode</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Kasir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($data as $item)
                                <tr class="hover:bg-purple-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->no_invoice }}</td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">
                                            {{ $item->tanggal_transaksi->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->tanggal_transaksi->format('H:i') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">{{ $item->nama_pelanggan ?? 'Umum' }}</p>
                                        @if ($item->telepon_pelanggan)
                                            <p class="text-xs text-gray-500">{{ $item->telepon_pelanggan }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span
                                            class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold">
                                            {{ $item->jumlah }} Tabung
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-lg">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="px-3 py-1 {{ $item->metode_bayar === 'tunai' ? 'bg-green-100 text-green-700' : ($item->metode_bayar === 'transfer' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700') }} rounded-full text-xs font-bold">
                                            {{ ucfirst($item->metode_bayar) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-700 font-medium">
                                        {{ $item->user->nama }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        Tidak ada data penjualan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($data->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $data->links() }}
                    </div>
                @endif
            </div>
        @elseif($tipe === 'stok_masuk')
            <!-- Riwayat Stok Masuk -->
            <div class="glass-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                    <h3 class="text-xl font-bold text-gray-900">Riwayat Stok Masuk</h3>
                    <p class="text-gray-600 text-sm">Total: {{ $data->total() }} pembelian</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tanggal Beli</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Supplier</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Jumlah</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Harga Beli</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Total Modal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Input By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($data as $item)
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->kode }}</td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($item->tanggal_beli)->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->created_at->format('H:i') }}</p>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        {{ $item->supplier ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                                            +{{ $item->jumlah }} Tabung
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900">
                                        Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-lg">
                                        Rp {{ number_format($item->total_modal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-700 font-medium">
                                        {{ $item->user->nama }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        Tidak ada data stok masuk
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($data->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $data->links() }}
                    </div>
                @endif
            </div>
        @else
            <!-- Riwayat Penyesuaian -->
            <div class="glass-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-yellow-50">
                    <h3 class="text-xl font-bold text-gray-900">Riwayat Penyesuaian Stok</h3>
                    <p class="text-gray-600 text-sm">Total: {{ $data->total() }} penyesuaian</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Tipe</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Jumlah</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Alasan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Catatan</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Oleh</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($data as $item)
                                <tr class="hover:bg-orange-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->kode }}</td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">{{ $item->created_at->format('d/m/Y') }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $item->created_at->format('H:i') }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($item->tipe === 'penambahan')
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Penambahan</span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Pengurangan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span
                                            class="font-bold text-lg {{ $item->tipe === 'penambahan' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $item->tipe === 'penambahan' ? '+' : '-' }}{{ $item->jumlah }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                            {{ ucfirst($item->alasan) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $item->catatan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-700 font-medium">
                                        {{ $item->user->nama }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        Tidak ada data penyesuaian
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($data->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $data->links() }}
                    </div>
                @endif
            </div>
        @endif

    </div>
@endsection
