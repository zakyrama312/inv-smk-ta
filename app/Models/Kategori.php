<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'prodi_id',
        'nama_kategori',
        'slug',
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

    // Helper method
    public function getTotalBarangAttribute()
    {
        return $this->barangs()->count();
    }

    // Scopes
    public function scopeByProdi($query, $prodiId)
    {
        return $query->where('prodi_id', $prodiId);
    }
}
