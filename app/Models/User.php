<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'telepon',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Helper methods untuk role
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function getRoleLabelAttribute(): string
    {
        return $this->role === 'owner' ? 'Owner' : 'Staff';
    }

    // Relations
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function stokMasuk()
    {
        return $this->hasMany(StokMasuk::class);
    }

    public function penyesuaianStok()
    {
        return $this->hasMany(PenyesuaianStok::class);
    }
}
