@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data agen gas LPG 3kg')

@section('content')
    <div class="space-y-6">

        <!-- Alert Stok Menipis -->
        @if ($alertStok)
            <div class="glass-white rounded-2xl p-5 border-l-4 border-yellow-500 shadow-xl animate-pulse">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-yellow-800 text-lg">Peringatan Stok!</h3>
                        <p class="text-yellow-700">Stok gas Anda sudah menipis. Segera lakukan pengisian stok dari supplier.
                        </p>
                    </div>
                    <a href="{{ route('stok.index') }}"
                        class="px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-semibold transition-all hover-lift">
                        Isi Stok
                    </a>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stok Saat Ini -->
            <div class="glass-white rounded-2xl p-6 hover-lift shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div
                        class="w-14 h-14 gradient-purple rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/50">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">Real-time</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Stok Gas Tersedia</h3>
                <p class="text-4xl font-extrabold text-gray-900 mb-1">{{ number_format($stok, 0, ',', '.') }}</p>
                <p class="text-gray-600 text-sm font-medium">Tabung Gas 3kg</p>
            </div>

            <!-- Penjualan Hari Ini -->
            <div class="glass-white rounded-2xl p-6 hover-lift shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div
                        class="w-14 h-14 gradient-pink rounded-2xl flex items-center justify-center shadow-lg shadow-pink-500/50">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-xs font-bold">Hari Ini</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Penjualan Hari Ini</h3>
                <p class="text-4xl font-extrabold text-gray-900 mb-1">Rp
                    {{ number_format($penjualanHariIni->total_rupiah ?? 0, 0, ',', '.') }}</p>
                <p class="text-gray-600 text-sm font-medium">
                    {{ number_format($penjualanHariIni->total_qty ?? 0, 0, ',', '.') }} Tabung Terjual</p>
            </div>

            <!-- Penjualan Bulan Ini -->
            <div class="glass-white rounded-2xl p-6 hover-lift shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div
                        class="w-14 h-14 gradient-cyan rounded-2xl flex items-center justify-center shadow-lg shadow-cyan-500/50">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="px-3 py-1 bg-cyan-100 text-cyan-700 rounded-full text-xs font-bold">Bulan Ini</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Pendapatan Bulan Ini</h3>
                <p class="text-4xl font-extrabold text-gray-900 mb-1">Rp
                    {{ number_format($penjualanBulanIni->total_rupiah ?? 0, 0, ',', '.') }}</p>
                <p class="text-gray-600 text-sm font-medium">
                    {{ number_format($penjualanBulanIni->total_qty ?? 0, 0, ',', '.') }} Tabung Terjual</p>
            </div>

            <!-- Keuntungan Bulan Ini -->
            <div class="glass-white rounded-2xl p-6 hover-lift shadow-lg">
                <div class="flex items-start justify-between mb-4">
                    <div
                        class="w-14 h-14 gradient-green rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/50">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Estimasi</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Keuntungan Bulan Ini</h3>
                <p class="text-4xl font-extrabold {{ $keuntunganBulanIni >= 0 ? 'text-green-600' : 'text-red-600' }} mb-1">
                    Rp {{ number_format($keuntunganBulanIni, 0, ',', '.') }}</p>
                <p class="text-gray-600 text-sm font-medium">
                    @if ($pengaturan)
                        Margin: Rp {{ number_format($pengaturan->margin, 0, ',', '.') }}/tabung
                    @endif
                </p>
            </div>
        </div>

        <!-- Chart & Recent Transactions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Chart -->
            <div class="lg:col-span-2 glass-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-gray-900 text-xl">Grafik Penjualan</h3>
                        <p class="text-gray-600 text-sm">7 hari terakhir</p>
                    </div>
                    <div class="px-4 py-2 bg-purple-100 text-purple-700 rounded-xl text-sm font-bold">
                        Tabung
                    </div>
                </div>
                <canvas id="salesChart" height="80"></canvas>
            </div>

            <!-- Recent Transactions -->
            <div class="glass-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-900 text-xl">Transaksi Terakhir</h3>
                    <a href="{{ route('riwayat.index') }}"
                        class="text-purple-600 hover:text-purple-700 text-sm font-bold">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($transaksiTerakhir as $trans)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-10 h-10 gradient-cyan rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 text-sm truncate">{{ $trans->no_invoice }}</p>
                                <p class="text-gray-600 text-xs">{{ $trans->jumlah }} tabung</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 text-sm">Rp
                                    {{ number_format($trans->total, 0, ',', '.') }}</p>
                                <p class="text-gray-500 text-xs">{{ $trans->tanggal_transaksi->format('H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 font-medium">Belum ada transaksi</p>
                        </div>
                    @endforelse
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
                        data: {!! json_encode($grafikPenjualan->pluck('total')) !!},
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
                        pointHoverBackgroundColor: 'rgb(118, 75, 162)',
                        pointHoverBorderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            borderRadius: 8,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Tabung';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
