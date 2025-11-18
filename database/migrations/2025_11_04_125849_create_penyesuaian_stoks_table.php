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
        Schema::create('penyesuaian_stok', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->integer('jumlah');
            $table->enum('tipe', ['penambahan', 'pengurangan']);
            $table->enum('alasan', ['rusak', 'hilang', 'ditemukan', 'koreksi', 'lainnya']);
            $table->text('catatan')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyesuaian_stok');
    }
};
