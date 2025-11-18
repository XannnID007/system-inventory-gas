@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan & Analytics')
@section('page-subtitle', 'Laporan penjualan dan keuangan')

@section('content')
    <div class="space-y-6">

        <!-- Filter Periode -->
        <div class="glass-white rounded-2xl p-6 shadow-lg">
            <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-gray-700 font-bold mb-2">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" value="{{ $periodeAwal }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                </div>
                <div class="flex-1">
                    <label class="block text-gray-700 font-bold mb-2">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" value="{{ $periodeAkhir }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                </div>
                <button type="submit"
                    class="px-8 py-3 gradient-purple text-white font-bold rounded-xl hover:shadow-lg transition-all">
                    Tampilkan
                </button>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Transaksi -->
            <div class="glass-white rounded-2xl p-6 hover-lift shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 gradient-cyan rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Transaksi</h3>
                <p class="text-3xl font-extrabold text-gray-900">
                    {{ number_format($penjualan->total_transaksi ?? 0, 0, ',', '.') }}</p>
                <p class="text-gray-600 text-sm mt-1">{{ number_format($penjualan->total_qty ?? 0, 0, ',', '.') }} Tabung
                    terjual</p>
            </div>

            <!-- Total Pendapatan -->
            <div class="glass-white rounded-2xl p-6 hover-lift shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 gradient-green rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Pendapatan</h3>
                <p class="text-3xl font-extrabold text-green-600">Rp
                    {{ number_format($penjualan->total_pendapatan ?? 0, 0, ',', '.') }}</p>
                <p class="text-gray-600 text-sm mt-1">Rata-rata: Rp
                    {{ number_format($penjualan->rata_rata_transaksi ?? 0, 0, ',', '.') }}</p>
            </div>

            <!-- Total Modal -->
            <div class="glass-white rounded-2xl p-6 hover-lift shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 gradient-orange rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Modal</h3>
                <p class="text-3xl font-extrabold text-orange-600">Rp
                    {{ number_format($stokMasuk->total_modal ?? 0, 0, ',', '.') }}</p>
                <p class="text-gray-600 text-sm mt-1">{{ number_format($stokMasuk->total_qty ?? 0, 0, ',', '.') }} Tabung
                    dibeli</p>
            </div>

            <!-- Keuntungan -->
            <div class="glass-white rounded-2xl p-6 hover-lift shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 gradient-purple rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Keuntungan Kotor</h3>
                <p class="text-3xl font-extrabold {{ $keuntungan >= 0 ? 'text-purple-600' : 'text-red-600' }}">
                    Rp {{ number_format($keuntungan, 0, ',', '.') }}
                </p>
                <p class="text-gray-600 text-sm mt-1">
                    @if (($stokMasuk->total_modal ?? 0) > 0)
                        Margin: {{ number_format(($keuntungan / $stokMasuk->total_modal) * 100, 1) }}%
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>

        <!-- Grafik & Metode Bayar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Grafik Penjualan -->
            <div class="lg:col-span-2 glass-white rounded-2xl p-6 shadow-lg">
                <h3 class="font-bold text-gray-900 text-xl mb-6">Grafik Penjualan Harian</h3>
                <canvas id="salesChart" height="100"></canvas>
            </div>

            <!-- Metode Pembayaran -->
            <div class="glass-white rounded-2xl p-6 shadow-lg">
                <h3 class="font-bold text-gray-900 text-xl mb-6">Metode Pembayaran</h3>
                <div class="space-y-4">
                    @forelse($metodeBayar as $metode)
                        <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    @if ($metode->metode_bayar === 'tunai')
                                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                    @elseif($metode->metode_bayar === 'transfer')
                                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <span class="font-bold text-gray-900">{{ ucfirst($metode->metode_bayar) }}</span>
                                </div>
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                                    {{ $metode->jumlah }}x
                                </span>
                            </div>
                            <p class="font-bold text-gray-900 text-lg">Rp {{ number_format($metode->total, 0, ',', '.') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">Belum ada transaksi</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Detail Tabel Transaksi -->
        <div class="glass-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Detail Transaksi</h3>
                    <p class="text-gray-600 text-sm">Periode: {{ \Carbon\Carbon::parse($periodeAwal)->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse($periodeAkhir)->format('d M Y') }}</p>
                </div>
                <button onclick="window.print()"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </button>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-3 gap-6 mb-6">
                    <div class="p-4 bg-blue-50 rounded-xl">
                        <p class="text-blue-600 text-sm font-semibold mb-1">Total Penjualan</p>
                        <p class="text-2xl font-extrabold text-blue-900">
                            {{ number_format($penjualan->total_qty ?? 0, 0, ',', '.') }} Tabung</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-xl">
                        <p class="text-green-600 text-sm font-semibold mb-1">Total Pendapatan</p>
                        <p class="text-2xl font-extrabold text-green-900">Rp
                            {{ number_format($penjualan->total_pendapatan ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-xl">
                        <p class="text-purple-600 text-sm font-semibold mb-1">Keuntungan Kotor</p>
                        <p class="text-2xl font-extrabold text-purple-900">Rp
                            {{ number_format($keuntungan, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            // Chart.js - Sales Chart
            const ctx = document.getElementById('salesChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(102, 126, 234, 0.4)');
            gradient.addColorStop(1, 'rgba(118, 75, 162, 0.0)');

            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(
                        $grafikPenjualan->pluck('tanggal')->map(function ($date) {
                            return \Carbon\Carbon::parse($date)->translatedFormat('d M');
                        }),
                    ) !!},
                    datasets: [{
                        label: 'Penjualan (Tabung)',
                        data: {!! json_encode($grafikPenjualan->pluck('qty')) !!},
                        borderColor: 'rgb(102, 126, 234)',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: 'rgb(102, 126, 234)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    }, {
                        label: 'Pendapatan (Rp)',
                        data: {!! json_encode($grafikPenjualan->pluck('total')) !!},
                        borderColor: 'rgb(67, 233, 123)',
                        backgroundColor: 'rgba(67, 233, 123, 0.1)',
                        borderWidth: 3,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: 'rgb(67, 233, 123)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        yAxisID: 'y1',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            borderRadius: 8,
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            beginAtZero: true,
                            grid: {
                                drawOnChartArea: false,
                            },
                        },
                        x: {
                            grid: {
                                display: false,
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
