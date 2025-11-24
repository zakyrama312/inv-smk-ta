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
        Schema::create('barang_stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang')->cascadeOnDelete();
            $table->integer('stok_awal')->default(0); // stok pertama kali masuk
            $table->integer('stok_masuk')->default(0); // total stok yang masuk (akumulasi)
            $table->integer('stok_keluar')->default(0); // total stok yang keluar (akumulasi)
            $table->integer('stok_akhir')->default(0); // stok saat ini (calculated)
            $table->string('satuan')->nullable();
            $table->enum('status', ['tersedia', 'kosong'])->default('tersedia');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_stoks');
    }
};
