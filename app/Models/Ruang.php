<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruang extends Model
{
    use HasFactory;

    protected $table = 'ruang';

    protected $fillable = [
        'prodi_id',
        'nama_ruang',
        'slug',
    ];

    // Relationships
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    public function barangStoks(): HasMany
    {
        return $this->hasMany(BarangStok::class);
    }

    // Helper method
    public function getTotalBarangAttribute()
    {
        return $this->barangStoks()->sum('total_stok');
    }
}
