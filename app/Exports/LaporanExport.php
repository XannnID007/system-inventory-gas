<?php

namespace App\Exports;

use App\Models\Transaksi;
use App\Models\StokMasuk;
use App\Models\Pengaturan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LaporanExport implements WithMultipleSheets
{
     protected $periodeAwal;
     protected $periodeAkhir;

     public function __construct($periodeAwal, $periodeAkhir)
     {
          $this->periodeAwal = $periodeAwal;
          $this->periodeAkhir = $periodeAkhir;
     }

     public function sheets(): array
     {
          return [
               new RingkasanSheet($this->periodeAwal, $this->periodeAkhir),
               new TransaksiSheet($this->periodeAwal, $this->periodeAkhir),
               new StokMasukSheet($this->periodeAwal, $this->periodeAkhir),
          ];
     }
}

// Sheet 1: Ringkasan
class RingkasanSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
     protected $periodeAwal;
     protected $periodeAkhir;

     public function __construct($periodeAwal, $periodeAkhir)
     {
          $this->periodeAwal = $periodeAwal;
          $this->periodeAkhir = $periodeAkhir;
     }

     public function collection()
     {
          $pengaturan = Pengaturan::first();

          $penjualan = Transaksi::whereBetween('tanggal_transaksi', [$this->periodeAwal, $this->periodeAkhir])
               ->selectRaw('COUNT(*) as total_transaksi, SUM(jumlah) as total_qty, SUM(total) as total_pendapatan')
               ->first();

          $stokMasuk = StokMasuk::whereBetween('tanggal_beli', [$this->periodeAwal, $this->periodeAkhir])
               ->selectRaw('SUM(jumlah) as total_qty, SUM(total_modal) as total_modal')
               ->first();

          $keuntungan = ($penjualan->total_pendapatan ?? 0) - ($stokMasuk->total_modal ?? 0);

          return collect([
               ['LAPORAN KEUANGAN', ''],
               ['Nama Toko', $pengaturan->nama_toko ?? '-'],
               ['Periode', date('d/m/Y', strtotime($this->periodeAwal)) . ' - ' . date('d/m/Y', strtotime($this->periodeAkhir))],
               ['', ''],
               ['PENJUALAN', ''],
               ['Total Transaksi', $penjualan->total_transaksi ?? 0],
               ['Total Tabung Terjual', $penjualan->total_qty ?? 0],
               ['Total Pendapatan', 'Rp ' . number_format($penjualan->total_pendapatan ?? 0, 0, ',', '.')],
               ['', ''],
               ['PEMBELIAN STOK', ''],
               ['Total Tabung Dibeli', $stokMasuk->total_qty ?? 0],
               ['Total Modal', 'Rp ' . number_format($stokMasuk->total_modal ?? 0, 0, ',', '.')],
               ['', ''],
               ['KEUNTUNGAN KOTOR', 'Rp ' . number_format($keuntungan, 0, ',', '.')],
          ]);
     }

     public function headings(): array
     {
          return [];
     }

     public function styles(Worksheet $sheet)
     {
          return [
               1 => ['font' => ['bold' => true, 'size' => 16]],
               5 => ['font' => ['bold' => true, 'size' => 12]],
               10 => ['font' => ['bold' => true, 'size' => 12]],
               14 => ['font' => ['bold' => true, 'size' => 14], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFD700']]],
          ];
     }

     public function title(): string
     {
          return 'Ringkasan';
     }
}

// Sheet 2: Detail Transaksi
class TransaksiSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
     protected $periodeAwal;
     protected $periodeAkhir;

     public function __construct($periodeAwal, $periodeAkhir)
     {
          $this->periodeAwal = $periodeAwal;
          $this->periodeAkhir = $periodeAkhir;
     }

     public function collection()
     {
          return Transaksi::with('user')
               ->whereBetween('tanggal_transaksi', [$this->periodeAwal, $this->periodeAkhir])
               ->orderBy('tanggal_transaksi', 'desc')
               ->get()
               ->map(function ($item, $index) {
                    return [
                         'no' => $index + 1,
                         'invoice' => $item->no_invoice,
                         'tanggal' => $item->tanggal_transaksi->format('d/m/Y H:i'),
                         'pelanggan' => $item->nama_pelanggan ?? 'Umum',
                         'jumlah' => $item->jumlah,
                         'harga_satuan' => $item->harga_satuan,
                         'subtotal' => $item->subtotal,
                         'diskon' => $item->diskon,
                         'total' => $item->total,
                         'metode_bayar' => ucfirst($item->metode_bayar),
                         'kasir' => $item->user->nama,
                    ];
               });
     }

     public function headings(): array
     {
          return [
               'No',
               'No Invoice',
               'Tanggal',
               'Pelanggan',
               'Jumlah',
               'Harga Satuan',
               'Subtotal',
               'Diskon',
               'Total',
               'Metode Bayar',
               'Kasir',
          ];
     }

     public function styles(Worksheet $sheet)
     {
          return [
               1 => [
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
                    'font' => ['color' => ['rgb' => 'FFFFFF']],
               ],
          ];
     }

     public function title(): string
     {
          return 'Detail Transaksi';
     }
}

// Sheet 3: Detail Stok Masuk
class StokMasukSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
     protected $periodeAwal;
     protected $periodeAkhir;

     public function __construct($periodeAwal, $periodeAkhir)
     {
          $this->periodeAwal = $periodeAwal;
          $this->periodeAkhir = $periodeAkhir;
     }

     public function collection()
     {
          return StokMasuk::with('user')
               ->whereBetween('tanggal_beli', [$this->periodeAwal, $this->periodeAkhir])
               ->orderBy('tanggal_beli', 'desc')
               ->get()
               ->map(function ($item, $index) {
                    return [
                         'no' => $index + 1,
                         'kode' => $item->kode,
                         'tanggal' => date('d/m/Y', strtotime($item->tanggal_beli)),
                         'supplier' => $item->supplier ?? '-',
                         'jumlah' => $item->jumlah,
                         'harga_beli' => $item->harga_beli,
                         'total_modal' => $item->total_modal,
                         'input_by' => $item->user->nama,
                    ];
               });
     }

     public function headings(): array
     {
          return [
               'No',
               'Kode',
               'Tanggal Beli',
               'Supplier',
               'Jumlah',
               'Harga Beli',
               'Total Modal',
               'Input By',
          ];
     }

     public function styles(Worksheet $sheet)
     {
          return [
               1 => [
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '70AD47']],
                    'font' => ['color' => ['rgb' => 'FFFFFF']],
               ],
          ];
     }

     public function title(): string
     {
          return 'Stok Masuk';
     }
}
