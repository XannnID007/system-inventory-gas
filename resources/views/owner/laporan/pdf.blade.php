<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #10b981;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 24px;
            color: #10b981;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 14px;
            color: #666;
        }

        .info-box {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #10b981;
        }

        .info-box table {
            width: 100%;
        }

        .info-box td {
            padding: 5px 0;
        }

        .info-box td:first-child {
            font-weight: bold;
            width: 150px;
        }

        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .summary-card {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
            margin-right: 10px;
            border: 1px solid #e5e7eb;
        }

        .summary-card:last-child {
            margin-right: 0;
        }

        .summary-card h3 {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .summary-card .value {
            font-size: 20px;
            font-weight: bold;
            color: #10b981;
        }

        .summary-card .sub-value {
            font-size: 10px;
            color: #6b7280;
            margin-top: 5px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #10b981;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.data-table thead {
            background: #10b981;
            color: white;
        }

        table.data-table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }

        table.data-table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        table.data-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        table.data-table tbody tr:hover {
            background: #f0fdf4;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-tunai {
            background: #dcfce7;
            color: #166534;
        }

        .badge-transfer {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-qris {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .total-box {
            background: #10b981;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }

        .total-box h3 {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .total-box .amount {
            font-size: 24px;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ $pengaturan->nama_toko ?? 'Agen Gas LPG' }}</h1>
        <div class="subtitle">LAPORAN KEUANGAN</div>
        <div class="subtitle">Periode: {{ date('d/m/Y', strtotime($periodeAwal)) }} -
            {{ date('d/m/Y', strtotime($periodeAkhir)) }}</div>
    </div>

    <!-- Info Toko -->
    <div class="info-box">
        <table>
            <tr>
                <td>Nama Toko</td>
                <td>: {{ $pengaturan->nama_toko ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $pengaturan->alamat_toko ?? '-' }}</td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td>: {{ $pengaturan->telepon_toko ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ now()->translatedFormat('d F Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <!-- Summary Cards -->
    <div class="summary-grid">
        <div class="summary-card">
            <h3>Total Transaksi</h3>
            <div class="value">{{ number_format($penjualan->total_transaksi ?? 0, 0, ',', '.') }}</div>
            <div class="sub-value">{{ number_format($penjualan->total_qty ?? 0, 0, ',', '.') }} Tabung Terjual</div>
        </div>
        <div class="summary-card">
            <h3>Total Pendapatan</h3>
            <div class="value">Rp {{ number_format($penjualan->total_pendapatan ?? 0, 0, ',', '.') }}</div>
            <div class="sub-value">Rata-rata: Rp {{ number_format($penjualan->rata_rata_transaksi ?? 0, 0, ',', '.') }}
            </div>
        </div>
        <div class="summary-card">
            <h3>Total Modal</h3>
            <div class="value">Rp {{ number_format($stokMasuk->total_modal ?? 0, 0, ',', '.') }}</div>
            <div class="sub-value">{{ number_format($stokMasuk->total_qty ?? 0, 0, ',', '.') }} Tabung Dibeli</div>
        </div>
    </div>

    <!-- Keuntungan -->
    <div class="total-box">
        <h3>KEUNTUNGAN KOTOR</h3>
        <div class="amount">Rp {{ number_format($keuntungan, 0, ',', '.') }}</div>
    </div>

    <!-- Metode Pembayaran -->
    <h2 class="section-title">Metode Pembayaran</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 10%;">No</th>
                <th style="width: 30%;">Metode</th>
                <th style="width: 20%;" class="text-center">Jumlah Transaksi</th>
                <th style="width: 40%;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($metodeBayar as $index => $metode)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <span class="badge badge-{{ $metode->metode_bayar }}">
                            {{ ucfirst($metode->metode_bayar) }}
                        </span>
                    </td>
                    <td class="text-center">{{ $metode->jumlah }} transaksi</td>
                    <td class="text-right"><strong>Rp {{ number_format($metode->total, 0, ',', '.') }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Top Staff -->
    <h2 class="section-title">Top 5 Staff Performer</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 10%;">Rank</th>
                <th style="width: 30%;">Nama Staff</th>
                <th style="width: 15%;" class="text-center">Transaksi</th>
                <th style="width: 15%;" class="text-center">Tabung</th>
                <th style="width: 30%;" class="text-right">Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topStaff as $index => $staff)
                <tr>
                    <td class="text-center"><strong>{{ $index + 1 }}</strong></td>
                    <td>{{ $staff->user->nama }}</td>
                    <td class="text-center">{{ $staff->total_transaksi }}</td>
                    <td class="text-center">{{ $staff->total_qty }}</td>
                    <td class="text-right"><strong>Rp
                            {{ number_format($staff->total_penjualan, 0, ',', '.') }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- Detail Transaksi -->
    <h2 class="section-title">Detail Transaksi</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Invoice</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">Pelanggan</th>
                <th style="width: 8%;" class="text-center">Qty</th>
                <th style="width: 12%;" class="text-right">Subtotal</th>
                <th style="width: 10%;" class="text-right">Diskon</th>
                <th style="width: 12%;" class="text-right">Total</th>
                <th style="width: 8%;">Metode</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detailTransaksi as $index => $trans)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $trans->no_invoice }}</td>
                    <td>{{ $trans->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                    <td>{{ $trans->nama_pelanggan ?? 'Umum' }}</td>
                    <td class="text-center">{{ $trans->jumlah }}</td>
                    <td class="text-right">{{ number_format($trans->subtotal, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($trans->diskon, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>{{ number_format($trans->total, 0, ',', '.') }}</strong></td>
                    <td class="text-center">
                        <span class="badge badge-{{ $trans->metode_bayar }}">
                            {{ substr(ucfirst($trans->metode_bayar), 0, 1) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem {{ $pengaturan->nama_toko ?? 'Agen Gas LPG' }}</p>
        <p>Dicetak pada: {{ now()->translatedFormat('l, d F Y H:i') }} WIB</p>
    </div>
</body>

</html>
