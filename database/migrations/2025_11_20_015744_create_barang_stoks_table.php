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
            $table->foreignId('ruang_id')->constrained('ruang')->cascadeOnDelete();
            $table->string('satuan')->default('unit'); // unit, pcs, set, dll
            $table->integer('total_stok')->default(0); // total di ruangan ini
            $table->integer('stok_masuk')->default(0); // history stok masuk
            $table->integer('stok_keluar')->default(0); // history stok keluar
            $table->enum('status', ['tersedia', 'dipinjam', 'rusak', 'hilang'])->default('tersedia');
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