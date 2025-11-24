<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pengaturan;
use App\Models\StokSekarang;
use App\Models\StokMasuk;
use App\Models\Transaksi;
use App\Models\PenyesuaianStok;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users
        $owner = User::create([
            'nama' => 'Owner Gas',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'owner', // Pastikan kolom 'role' sudah ada di migrasi users
            'telepon' => '081234567890',
        ]);

        $staff1 = User::create([
            'nama' => 'Rosi Fitrishea',
            'email' => 'rosi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'telepon' => '081234567891',
        ]);

        $staff2 = User::create([
            'nama' => 'Kevin Hartono',
            'email' => 'kevin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'telepon' => '081234567892',
        ]);

        // 2. Create Settings
        Pengaturan::create([
            'nama_toko' => 'Pangkalan Suryati D.',
            'alamat_toko' => 'Jl. Merdeka No. 123, Bandung, Jawa Barat',
            'telepon_toko' => '022-7654321',
            'harga_modal' => 17000,
            'harga_jual' => 20000,
            'stok_minimum' => 10,
            'notifikasi_stok' => true,
        ]);
    }
}
