<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyesuaianStok extends Model
{
    use HasFactory;
    protected $table = 'penyesuaian_stok';

    protected $fillable = [
        'kode',
        'jumlah',
        'tipe',
        'alasan',
        'catatan',
        'user_id',
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
        });
    }

    public static function generateKode()
    {
        $date = date('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'PS-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
