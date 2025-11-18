<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;
    protected $table = 'pengaturan';

    protected $fillable = [
        'nama_toko',
        'alamat_toko',
        'telepon_toko',
        'logo_toko',
        'harga_modal',
        'harga_jual',
        'stok_minimum',
        'notifikasi_stok',
    ];

    protected $casts = [
        'harga_modal' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'notifikasi_stok' => 'boolean',
    ];

    public function getMarginAttribute()
    {
        return $this->harga_jual - $this->harga_modal;
    }

    public function getPersentaseMarginAttribute()
    {
        if ($this->harga_modal == 0) return 0;
        return ($this->getMarginAttribute() / $this->harga_modal) * 100;
    }
}
