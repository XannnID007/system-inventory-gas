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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice')->unique();
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('diskon', 10, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->enum('metode_bayar', ['tunai', 'transfer', 'qris'])->default('tunai');
            $table->string('nama_pelanggan')->nullable();
            $table->string('telepon_pelanggan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_transaksi');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
