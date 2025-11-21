@extends('layouts.app')

@section('title', 'Kelola Stok')
@section('page-title', 'Kelola Stok Gas')
@section('page-subtitle', 'Manajemen stok masuk dan penyesuaian')

@section('content')
    <div class="space-y-6" x-data="{ activeTab: 'masuk' }">

        <!-- Stok Info Card -->
        <div class="glass-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div
                        class="w-16 h-16 gradient-purple rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/50 animate-float">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Stok Gas Saat Ini</p>
                        <p class="text-4xl font-extrabold text-gray-900">{{ number_format($stokSekarang, 0, ',', '.') }}
                            Tabung</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="glass-white rounded-2xl p-2 shadow-lg">
            <div class="flex gap-2">
                <button @click="activeTab = 'masuk'"
                    :class="activeTab === 'masuk' ? 'gradient-green text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100'"
                    class="flex-1 px-6 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Stok Masuk
                </button>
                <button @click="activeTab = 'penyesuaian'"
                    :class="activeTab === 'penyesuaian' ? 'gradient-orange text-white shadow-lg' :
                        'text-gray-600 hover:bg-gray-100'"
                    class="flex-1 px-6 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Penyesuaian Stok
                </button>
            </div>
        </div>

        <!-- Tab Content: Stok Masuk -->
        <div x-show="activeTab === 'masuk'" x-transition class="space-y-6">

            <!-- Form Stok Masuk -->
            <div class="glass-white rounded-2xl p-8 shadow-xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 gradient-green rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Tambah Stok Masuk</h3>
                </div>

                <form action="{{ route('stok.stok-masuk.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Jumlah Tabung <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="jumlah" min="1" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all"
                                placeholder="Masukkan jumlah">
                            @error('jumlah')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Harga Beli per Tabung <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</div>
                                <input type="number" name="harga_beli" min="0" required
                                    class="w-full pl-14 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all"
                                    placeholder="0">
                            </div>
                            @error('harga_beli')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tanggal Pembelian <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_beli" value="{{ date('Y-m-d') }}" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all">
                            @error('tanggal_beli')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Supplier</label>
                            <input type="text" name="supplier"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all"
                                placeholder="Nama supplier (opsional)">
                            @error('supplier')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Foto Bukti Pembelian</label>
                        <input type="file" name="foto_bukti" accept="image/*"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
                        <p class="text-gray-500 text-sm mt-2">Format: JPG, PNG (Max: 2MB)</p>
                        @error('foto_bukti')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Catatan</label>
                        <textarea name="catatan" rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all resize-none"
                            placeholder="Tambahkan catatan..."></textarea>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full px-6 py-4 gradient-green text-white font-bold rounded-xl hover:shadow-lg hover:shadow-green-500/50 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Stok Masuk
                    </button>
                </form>
            </div>

            <!-- Daftar Stok Masuk -->
            <div class="glass-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                    <h3 class="text-xl font-bold text-gray-900">Riwayat Stok Masuk</h3>
                    <p class="text-gray-600 text-sm">15 data terakhir</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Supplier</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Jumlah</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Total Modal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($stokMasuk as $item)
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->kode }}</td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($item->tanggal_beli)->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->created_at->format('H:i') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">{{ $item->supplier ?? '-' }}</p>
                                        @if ($item->foto_bukti)
                                            <a href="{{ asset('storage/' . $item->foto_bukti) }}" target="_blank"
                                                class="text-xs text-blue-600 hover:underline">Lihat Bukti</a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                                            +{{ $item->jumlah }} Tabung
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-lg">
                                        Rp {{ number_format($item->total_modal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('stok.stok-masuk.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini? Stok akan dikurangi.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        Belum ada data stok masuk
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($stokMasuk->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $stokMasuk->links() }}
                    </div>
                @endif
            </div>

        </div>

        <!-- Tab Content: Penyesuaian Stok -->
        <div x-show="activeTab === 'penyesuaian'" x-transition class="space-y-6">

            <!-- Form Penyesuaian -->
            <div class="glass-white rounded-2xl p-8 shadow-xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 gradient-orange rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Penyesuaian Stok</h3>
                </div>

                <form action="{{ route('stok.penyesuaian.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="p-4 bg-blue-50 border-2 border-blue-200 rounded-xl">
                        <div class="flex gap-3">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-blue-800 font-bold">Informasi</p>
                                <p class="text-blue-700 text-sm">Penyesuaian stok digunakan untuk menambah/mengurangi stok
                                    karena kerusakan, kehilangan, atau koreksi data.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tipe Penyesuaian <span
                                    class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="tipe" value="penambahan" class="peer sr-only"
                                        required>
                                    <div
                                        class="p-4 border-2 border-gray-200 rounded-xl text-center peer-checked:border-green-500 peer-checked:bg-green-50 transition-all">
                                        <svg class="w-8 h-8 text-gray-400 peer-checked:text-green-600 mx-auto mb-2"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-semibold text-gray-700">Penambahan</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="tipe" value="pengurangan" class="peer sr-only">
                                    <div
                                        class="p-4 border-2 border-gray-200 rounded-xl text-center peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                        <svg class="w-8 h-8 text-gray-400 peer-checked:text-red-600 mx-auto mb-2"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-semibold text-gray-700">Pengurangan</span>
                                    </div>
                                </label>
                            </div>
                            @error('tipe')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Jumlah <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="jumlah" min="1" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all"
                                placeholder="Masukkan jumlah">
                            @error('jumlah')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Alasan <span
                                class="text-red-500">*</span></label>
                        <select name="alasan" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all">
                            <option value="">Pilih alasan...</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                            <option value="ditemukan">Ditemukan</option>
                            <option value="koreksi">Koreksi Data</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        @error('alasan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Catatan</label>
                        <textarea name="catatan" rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all resize-none"
                            placeholder="Jelaskan detail penyesuaian..."></textarea>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full px-6 py-4 gradient-orange text-white font-bold rounded-xl hover:shadow-lg hover:shadow-orange-500/50 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Penyesuaian
                    </button>
                </form>
            </div>

            <!-- Daftar Penyesuaian -->
            <div class="glass-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-yellow-50">
                    <h3 class="text-xl font-bold text-gray-900">Riwayat Penyesuaian</h3>
                    <p class="text-gray-600 text-sm">15 data terakhir</p>
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
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($penyesuaian as $item)
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
                                    <td class="px-6 py-4 text-gray-700 text-sm">
                                        {{ $item->catatan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        Belum ada data penyesuaian
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($penyesuaian->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $penyesuaian->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
