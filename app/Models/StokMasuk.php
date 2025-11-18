<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    use HasFactory;
    protected $table = 'stok_masuk';

    protected $fillable = [
        'kode',
        'jumlah',
        'harga_beli',
        'total_modal',
        'tanggal_beli',
        'supplier',
        'catatan',
        'foto_bukti',
        'user_id',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'total_modal' => 'decimal:2',
        'tanggal_beli' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->kode = self::generateKode();
            $model->total_modal = $model->jumlah * $model->harga_beli;
        });
    }

    public static function generateKode()
    {
        $date = date('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'SM-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
