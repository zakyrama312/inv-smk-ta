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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id')->constrained('prodi')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategori')->cascadeOnDelete();
            $table->foreignId('kondisi_id')->constrained('kondisi')->restrictOnDelete();
            $table->foreignId('ruang_id')->constrained('ruang')->cascadeOnDelete();
            $table->string('nama_barang');
            $table->string('slug')->unique();
            $table->string('kode_barang')->unique()->nullable(); // untuk barcode/QR
            $table->text('deskripsi')->nullable();
            $table->string('merk')->nullable();
            $table->string('foto')->nullable(); // path foto
            $table->string('foto_thumbnail')->nullable(); // path thumbnail
            $table->integer('jumlah_total')->default(0); // total barang
            $table->integer('jumlah_tersedia')->default(0); // barang tersedia (tidak dipinjam)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
