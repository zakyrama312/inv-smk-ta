<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'prodi_id',
        'kategori_id',
        'kondisi_id',
        'ruang_id',
        'nama_barang',
        'slug',
        'kode_barang',
        'deskripsi',
        'merk',
        'foto',
        'foto_thumbnail',
        'jumlah_total',
        'jumlah_tersedia',
    ];

    protected $casts = [
        'jumlah_total' => 'integer',
        'jumlah_tersedia' => 'integer',
    ];

    // Relationships
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class);
    }

    public function kondisi(): BelongsTo
    {
        return $this->belongsTo(Kondisi::class);
    }

    public function barangStoks(): HasMany
    {
        return $this->hasMany(BarangStok::class);
    }

    public function permintaans(): HasMany
    {
        return $this->hasMany(Permintaan::class);
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Helper methods
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return Storage::url($this->foto);
        }
        return asset('images/no-image.png'); // default image
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->foto_thumbnail) {
            return Storage::url($this->foto_thumbnail);
        }
        return $this->foto_url;
    }

    public function getJumlahDipinjamAttribute()
    {
        return $this->peminjamans()
            ->where('status', 'dipinjam')
            ->sum('jumlah');
    }

    public function isAvailable($jumlah = 1): bool
    {
        return $this->jumlah_tersedia >= $jumlah;
    }

    // Scopes
    public function scopeByProdi($query, $prodiId)
    {
        return $query->where('prodi_id', $prodiId);
    }

    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    public function scopeAvailable($query)
    {
        return $query->where('jumlah_tersedia', '>', 0);
    }
}
