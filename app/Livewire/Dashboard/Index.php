<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Permintaan;
use App\Models\User;

#[Layout('components.layouts.app')]
#[Title('Dashboard')]
class Index extends Component
{
    public function render()
    {
        $user = auth()->user();

        // Data yang ditampilkan berbeda berdasarkan role
        $stats = [];

        if ($user->isAdmin()) {
            // Admin melihat semua data
            $stats = [
                'total_barang' => Barang::count(),
                'total_users' => User::count(),
                'total_peminjaman' => Peminjaman::dipinjam()->count(),
                'permintaan_menunggu' => Permintaan::menunggu()->count(),
            ];
        } elseif ($user->isKaprodi()) {
            // Kaprodi melihat data prodi mereka
            $stats = [
                'total_barang' => Barang::byProdi($user->prodi_id)->count(),
                'total_peminjaman' => Peminjaman::byProdi($user->prodi_id)->dipinjam()->count(),
                'permintaan_menunggu' => Permintaan::byProdi($user->prodi_id)->menunggu()->count(),
            ];
        } else {
            // Anggota melihat data mereka sendiri
            $stats = [
                'permintaan_saya' => Permintaan::byUser($user->id)->count(),
                'peminjaman_aktif' => Peminjaman::byUser($user->id)->dipinjam()->count(),
            ];
        }

        return view('livewire.dashboard.index', compact('stats'));
    }
}
