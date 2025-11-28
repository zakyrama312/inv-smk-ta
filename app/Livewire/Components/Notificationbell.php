<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Peminjaman;

class NotificationBell extends Component
{



    public function getPendingPeminjamansProperty()
    {
        return Peminjaman::with(['barang'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();
    }


    public function getPendingCountProperty()
    {
        return Peminjaman::where('status', 'pending')->count();
    }




    public function render()
    {

        return view('livewire.components.notificationbell', [
            'pendingPeminjamans' => $this->pendingPeminjamans,
            'pendingCount' => $this->pendingCount,
        ]);
    }
}
