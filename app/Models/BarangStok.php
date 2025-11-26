<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangStok extends Model
{
    use HasFactory;

    protected $table = 'barang_stoks';

    protected $fillable = [
        'barang_id',
        'stok_awal',
        'stok_masuk',
        'stok_keluar',
        'stok_akhir',
        'satuan',
        'status',
        'tipe_transaksi',
        'referensi_id',
        'referensi_tipe',
        'keterangan',
    ];

    protected $casts = [
        'stok_awal' => 'integer',
        'stok_masuk' => 'integer',
        'stok_keluar' => 'integer',
        'stok_akhir' => 'integer',
    ];

    // Relationships
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }


    // Helper methods
    public function hitungStokAkhir()
    {
        $this->stok_akhir = $this->stok_awal + $this->stok_masuk - $this->stok_keluar;
        $this->updateStatus();
        $this->save();
        return $this->stok_akhir;
    }

    public function tambahStokMasuk($jumlah, $keterangan = null)
    {
        $this->increment('stok_masuk', $jumlah);
        $this->hitungStokAkhir();

        if ($keterangan) {
            $this->keterangan = $keterangan;
            $this->save();
        }
    }

    public function tambahStokKeluar($jumlah, $keterangan = null)
    {
        $this->increment('stok_keluar', $jumlah);
        $this->hitungStokAkhir();

        if ($keterangan) {
            $this->keterangan = $keterangan;
            $this->save();
        }
    }

    public function updateStatus()
    {
        if ($this->stok_akhir <= 0) {
            $this->status = 'kosong';
        } else {
            $this->status = 'tersedia';
        }
    }

    public function isAvailable($jumlah = 1): bool
    {
        return $this->status === 'tersedia' && $this->stok_akhir >= $jumlah;
    }

    // Scopes
    public function scopeByRuang($query, $ruangId)
    {
        return $query->where('ruang_id', $ruangId);
    }

    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia')->where('stok_akhir', '>', 0);
    }

    // Events
    protected static function booted()
    {
        // Auto calculate stok_akhir saat create/update
        static::saving(function ($barangStok) {
            $barangStok->stok_akhir = $barangStok->stok_awal + $barangStok->stok_masuk - $barangStok->stok_keluar;

            // Update status
            if ($barangStok->stok_akhir <= 0) {
                $barangStok->status = 'kosong';
            } else {
                $barangStok->status = 'tersedia';
            }
        });
    }
    // Polymorphic-like relationship (manual)
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'referensi_id')
            ->where('referensi_tipe', 'peminjaman');
    }

    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(Permintaan::class, 'referensi_id')
            ->where('referensi_tipe', 'permintaan');
    }

    // Helper method untuk ambil referensi dinamis
    public function getReferensiAttribute()
    {
        if ($this->referensi_tipe === 'peminjaman') {
            return $this->peminjaman;
        }

        if ($this->referensi_tipe === 'permintaan') {
            return $this->permintaan;
        }

        return null;
    }

    // Scope
    public function scopeByBarang($query, $barangId)
    {
        return $query->where('barang_id', $barangId);
    }

    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe_transaksi', $tipe);
    }

    public function scopeByPeriode($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }
}
