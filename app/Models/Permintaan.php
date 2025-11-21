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
}
