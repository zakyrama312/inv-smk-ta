<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permintaan extends Model
{
    use HasFactory;

    protected $table = 'permintaan';

    protected $fillable = [
        'barang_id',
        'user_id',
        'nama_peminjam',
        'kelas',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'keperluan',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    // Relationships
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function approve($keterangan = null)
    {
        $this->status = 'disetujui';
        if ($keterangan) {
            $this->keterangan = $keterangan;
        }
        $this->save();
    }

    public function reject($keterangan)
    {
        $this->status = 'ditolak';
        $this->keterangan = $keterangan;
        $this->save();
    }

    public function complete()
    {
        $this->status = 'selesai';
        $this->save();
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'menunggu' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
            'selesai' => 'info',
            default => 'secondary',
        };
    }

    // Scopes
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByProdi($query, $prodiId)
    {
        return $query->whereHas('barang', function ($q) use ($prodiId) {
            $q->where('prodi_id', $prodiId);
        });
    }

    protected static function booted()
    {
        // Saat permintaan disetujui (stok masuk)
        static::updated(function ($permintaan) {
            if ($permintaan->isDirty('status') && $permintaan->status === 'disetujui') {
                // Pastikan ada jumlah_disetujui
                $jumlah = $permintaan->jumlah_disetujui ?? $permintaan->jumlah;

                if (is_numeric($jumlah) && $jumlah > 0) {
                    // 1. Tambah stok barang
                    $permintaan->barang->increment('jumlah_total', $jumlah);
                    $permintaan->barang->increment('jumlah_tersedia', $jumlah);

                    // 2. Catat di barang_stok
                    BarangStok::create([
                        'barang_id' => $permintaan->barang_id,
                        'stok_masuk' => $jumlah,
                        'stok_keluar' => 0,
                        'tipe_transaksi' => 'permintaan',
                        'referensi_id' => $permintaan->id,
                        'referensi_tipe' => 'permintaan',
                        'keterangan' => "Permintaan barang disetujui - {$permintaan->nama_peminjam}",
                    ]);
                }
            }
        });
    }
}
