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
        Schema::table('barang_stoks', function (Blueprint $table) {
            // Tambah kolom baru
            $table->enum('tipe_transaksi', [
                'peminjaman',
                'pengembalian',
                'permintaan',
            ])->after('stok_keluar')->nullable();

            $table->unsignedBigInteger('referensi_id')->after('tipe_transaksi')->nullable();
            $table->string('referensi_tipe')->after('referensi_id')->nullable();

            // Index untuk performa
            $table->index(['barang_id', 'created_at']);
            $table->index(['referensi_tipe', 'referensi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_stok', function (Blueprint $table) {
            //
        });
    }
};
