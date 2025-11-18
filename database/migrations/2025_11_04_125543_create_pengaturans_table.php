<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko');
            $table->text('alamat_toko')->nullable();
            $table->string('telepon_toko')->nullable();
            $table->string('logo_toko')->nullable();
            $table->decimal('harga_modal', 10, 2)->default(0);
            $table->decimal('harga_jual', 10, 2)->default(0);
            $table->integer('stok_minimum')->default(10);
            $table->boolean('notifikasi_stok')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
