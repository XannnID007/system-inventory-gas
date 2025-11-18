<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokSekarang extends Model
{
    use HasFactory;
    protected $table = 'stok_sekarang';

    protected $fillable = [
        'jumlah',
        'terakhir_update',
    ];

    protected $casts = [
        'terakhir_update' => 'datetime',
    ];

    public static function getStok()
    {
        $stok = self::first();
        return $stok ? $stok->jumlah : 0;
    }

    public static function updateStok($jumlah)
    {
        $stok = self::firstOrCreate(['id' => 1]);
        $stok->jumlah = $jumlah;
        $stok->terakhir_update = now();
        $stok->save();
        return $stok;
    }

    public static function tambahStok($jumlah)
    {
        $stok = self::firstOrCreate(['id' => 1]);
        $stok->jumlah += $jumlah;
        $stok->terakhir_update = now();
        $stok->save();
        return $stok;
    }

    public static function kurangiStok($jumlah)
    {
        $stok = self::firstOrCreate(['id' => 1]);
        $stok->jumlah -= $jumlah;
        $stok->terakhir_update = now();
        $stok->save();
        return $stok;
    }
}
