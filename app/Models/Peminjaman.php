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
        'no_telepon',
        'kelas',
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

    public function barangStoks()
    {
        return $this->hasMany(BarangStok::class, 'referensi_id')
            ->where('referensi_tipe', 'peminjaman');
    }

    // Attributes
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
        // HAPUS EVENT 'created' - Stok jangan berkurang dulu saat peminjaman dibuat

        // Event saat peminjaman diupdate
        static::updated(function ($peminjaman) {
            // 1. Saat status berubah dari 'pending' ke 'dipinjam' (DISETUJUI)
            if (
                $peminjaman->isDirty('status') &&
                $peminjaman->status === 'dipinjam' &&
                $peminjaman->getOriginal('status') === 'pending'
            ) {

                // Kurangi stok
                $peminjaman->barang->decrement('jumlah_tersedia', $peminjaman->jumlah);

                // Catat di barang_stok
                \App\Models\BarangStok::create([
                    'barang_id' => $peminjaman->barang_id,
                    'stok_masuk' => 0,
                    'stok_keluar' => $peminjaman->jumlah,
                    'tipe_transaksi' => 'peminjaman',
                    'referensi_id' => $peminjaman->id,
                    'referensi_tipe' => 'peminjaman',
                    'keterangan' => "Peminjaman oleh {$peminjaman->nama_peminjam} ({$peminjaman->kelas})" .
                        ($peminjaman->keperluan ? " - {$peminjaman->keperluan}" : ""),
                ]);
            }

            // 2. Saat status berubah jadi 'dikembalikan'
            if ($peminjaman->isDirty('status') && $peminjaman->status === 'dikembalikan') {
                // Tambah stok kembali
                $peminjaman->barang->increment('jumlah_tersedia', $peminjaman->jumlah);

                // Catat di barang_stok
                BarangStok::create([
                    'barang_id' => $peminjaman->barang_id,
                    'stok_masuk' => $peminjaman->jumlah,
                    'stok_keluar' => 0,
                    'tipe_transaksi' => 'pengembalian',
                    'referensi_id' => $peminjaman->id,
                    'referensi_tipe' => 'peminjaman',
                    'keterangan' => "Pengembalian dari {$peminjaman->nama_peminjam} ({$peminjaman->kelas})" .
                        ($peminjaman->keterangan ? " - {$peminjaman->keterangan}" : ""),
                ]);
            }
        });
    }
}
