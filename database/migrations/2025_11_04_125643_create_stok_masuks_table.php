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
        Schema::create('stok_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->integer('jumlah');
            $table->decimal('harga_beli', 10, 2);
            $table->decimal('total_modal', 12, 2);
            $table->date('tanggal_beli');
            $table->string('supplier')->nullable();
            $table->text('catatan')->nullable();
            $table->string('foto_bukti')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_masuk');
    }
};
