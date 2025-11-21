<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';

    protected $fillable = [
        'nama_prodi',
        'slug',
    ];

    // Relationships
    public function ruangs(): HasMany
    {
        return $this->hasMany(Ruang::class);
    }

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Helper method
    public function getTotalBarangAttribute()
    {
        return $this->barangs()->sum('jumlah_total');
    }
}