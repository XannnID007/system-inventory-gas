<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';

    protected $fillable = [
        'no_invoice',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'diskon',
        'total',
        'metode_bayar',
        'nama_pelanggan',
        'telepon_pelanggan',
        'catatan',
        'tanggal_transaksi',
        'user_id',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total' => 'decimal:2',
        'tanggal_transaksi' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->no_invoice = self::generateInvoice();
            $model->subtotal = $model->jumlah * $model->harga_satuan;
            $model->total = $model->subtotal - $model->diskon;
            $model->tanggal_transaksi = now();
        });
    }

    public static function generateInvoice()
    {
        $date = date('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'INV-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
