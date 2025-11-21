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
        Schema::create('permintaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // peminjam
            $table->string('nama_peminjam'); // redundant tapi untuk history
            $table->string('kelas')->nullable();
            $table->integer('jumlah')->default(1);
            $table->date('tanggal_pinjam'); // tanggal rencana pinjam
            $table->date('tanggal_kembali'); // tanggal rencana kembali
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('keperluan')->nullable(); // keperluan peminjaman
            $table->text('keterangan')->nullable(); // catatan admin/kaprodi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan');
    }
};