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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // peminjam
            $table->string('nama_peminjam'); // redundant untuk history
            $table->integer('jumlah')->default(1);
            $table->date('tanggal_pinjam'); // actual tanggal pinjam
            $table->date('tanggal_kembali_rencana'); // rencana kembali
            $table->date('tanggal_kembali_actual')->nullable(); // actual kembali
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->foreignId('kondisi_awal_id')->nullable()->constrained('kondisi')->nullOnDelete(); // kondisi saat dipinjam
            $table->foreignId('kondisi_akhir_id')->nullable()->constrained('kondisi')->nullOnDelete(); // kondisi saat dikembalikan
            $table->integer('denda')->default(0); // denda keterlambatan
            $table->text('keperluan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
