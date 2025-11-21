<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'barang_id',
        'user_id',
        'nama_peminjam',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_actual',
        'status',
        'kondisi_awal_id',
        'kondisi_akhir_id',
        'denda',
        'keperluan',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'denda' => 'integer',
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_actual' => 'date',
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

    public function kondisiAwal(): BelongsTo
    {
        return $this->belongsTo(Kondisi::class, 'kondisi_awal_id');
    }

    public function kondisiAkhir(): BelongsTo
    {
        return $this->belongsTo(Kondisi::class, 'kondisi_akhir_id');
    }

    // Helper methods
    public function kembalikan($kondisiAkhirId, $keterangan = null)
    {
        $this->tanggal_kembali_actual = now();
        $this->kondisi_akhir_id = $kondisiAkhirId;
        $this->status = 'dikembalikan';

        // Hitung denda jika terlambat
        if ($this->tanggal_kembali_actual->gt($this->tanggal_kembali_rencana)) {
            $hariTerlambat = $this->tanggal_kembali_actual->diffInDays($this->tanggal_kembali_rencana);
            $this->denda = $hariTerlambat * 5000; // Rp 5.000 per hari
        }

        if ($keterangan) {
            $this->keterangan = $keterangan;
        }

        $this->save();

        // Update jumlah tersedia barang
        $this->barang->increment('jumlah_tersedia', $this->jumlah);
    }

    public function getHariTerlambatAttribute()
    {
        if ($this->status === 'dikembalikan' && $this->tanggal_kembali_actual) {
            return $this->tanggal_kembali_actual->gt($this->tanggal_kembali_rencana)
                ? $this->tanggal_kembali_actual->diffInDays($this->tanggal_kembali_rencana)
                : 0;
        }

        if ($this->status === 'dipinjam') {
            return now()->gt($this->tanggal_kembali_rencana)
                ? now()->diffInDays($this->tanggal_kembali_rencana)
                : 0;
        }

        return 0;
    }

    public function getIsTerlambatAttribute()
    {
        return $this->status === 'dipinjam' && now()->gt($this->tanggal_kembali_rencana);
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'dipinjam' => $this->is_terlambat ? 'danger' : 'warning',
            'dikembalikan' => 'success',
            'terlambat' => 'danger',
            default => 'secondary',
        };
    }

    // Scopes
    public function scopeDipinjam($query)
    {
        return $query->where('status', 'dipinjam');
    }

    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'dikembalikan');
    }

    public function scopeTerlambat($query)
    {
        return $query->where('status', 'dipinjam')
            ->where('tanggal_kembali_rencana', '<', now());
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

    // Events
    protected static function booted()
    {
        static::creating(function ($peminjaman) {
            // Kurangi jumlah tersedia saat peminjaman dibuat
            $peminjaman->barang->decrement('jumlah_tersedia', $peminjaman->jumlah);
        });
    }
}