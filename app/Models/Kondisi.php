<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kondisi extends Model
{
    use HasFactory;

    protected $table = 'kondisi';

    protected $fillable = [
        'prodi_id',
        'nama_kondisi',
    ];

    // Relationships
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }

    public function peminjamanKondisiAwal(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'kondisi_awal_id');
    }

    public function peminjamanKondisiAkhir(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'kondisi_akhir_id');
    }

    // Scopes
    public function scopeByProdi($query, $prodiId)
    {
        return $query->where('prodi_id', $prodiId);
    }
}
