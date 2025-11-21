<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangStok extends Model
{
    use HasFactory;

    protected $table = 'barang_stoks';

    protected $fillable = [
        'barang_id',
        'ruang_id',
        'satuan',
        'total_stok',
        'stok_masuk',
        'stok_keluar',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'total_stok' => 'integer',
        'stok_masuk' => 'integer',
        'stok_keluar' => 'integer',
    ];

    // Relationships
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class);
    }

    // Helper methods
    public function updateStok($jumlah, $tipe = 'masuk')
    {
        if ($tipe === 'masuk') {
            $this->increment('stok_masuk', $jumlah);
            $this->increment('total_stok', $jumlah);
        } else {
            $this->increment('stok_keluar', $jumlah);
            $this->decrement('total_stok', $jumlah);
        }

        // Update status based on stock
        if ($this->total_stok <= 0) {
            $this->status = 'kosong';
        } elseif ($this->status === 'kosong') {
            $this->status = 'tersedia';
        }

        $this->save();
    }

    public function isAvailable($jumlah = 1): bool
    {
        return $this->status === 'tersedia' && $this->total_stok >= $jumlah;
    }

    // Scopes
    public function scopeByRuang($query, $ruangId)
    {
        return $query->where('ruang_id', $ruangId);
    }

    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia')->where('total_stok', '>', 0);
    }
}
