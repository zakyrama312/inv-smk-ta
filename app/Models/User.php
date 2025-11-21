<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'prodi_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Relationships
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
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
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKaprodi(): bool
    {
        return $this->role === 'kaprodi';
    }

    public function isAnggota(): bool
    {
        return $this->role === 'anggota';
    }

    public function hasRole($role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    public function canAccessProdi($prodiId): bool
    {
        // Admin bisa akses semua prodi
        if ($this->isAdmin()) {
            return true;
        }

        // Kaprodi dan Anggota hanya bisa akses prodi mereka
        return $this->prodi_id == $prodiId;
    }

    // Scopes
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeKaprodi($query)
    {
        return $query->where('role', 'kaprodi');
    }

    public function scopeAnggota($query)
    {
        return $query->where('role', 'anggota');
    }

    public function scopeByProdi($query, $prodiId)
    {
        return $query->where('prodi_id', $prodiId);
    }
}
