<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pengaturan;
use App\Models\StokSekarang;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default user
        User::create([
            'nama' => 'Admin Agen Gas',
            'email' => 'admin@gasku.com',
            'password' => Hash::make('password'),
            'telepon' => '081234567890',
        ]);

        // Create default settings
        Pengaturan::create([
            'nama_toko' => 'Agen Gas LPG GasKu',
            'alamat_toko' => 'Jl. Contoh No. 123, Jakarta',
            'telepon_toko' => '021-12345678',
            'harga_modal' => 17000,
            'harga_jual' => 20000,
            'stok_minimum' => 10,
            'notifikasi_stok' => true,
        ]);

        // Initialize stock
        StokSekarang::create([
            'jumlah' => 0,
            'terakhir_update' => now(),
        ]);

        $this->command->info('✅ Data awal berhasil dibuat!');
        $this->command->info('📧 Email: admin@gasku.com');
        $this->command->info('🔐 Password: password');
    }
}
