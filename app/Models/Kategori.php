<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

    // Relationships
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }

    // Helper method
    public function getTotalBarangAttribute()
    {
        return $this->barangs()->count();
    }
}