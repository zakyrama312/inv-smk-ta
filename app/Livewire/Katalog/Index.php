<?php

namespace App\Livewire\Katalog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruang;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterKategori = '';
    public $filterRuang = '';
    public $filterStatus = '';
    public $selectedBarang = null;
    public $showDetail = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterKategori' => ['except' => ''],
        'filterRuang' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterKategori()
    {
        $this->resetPage();
    }

    public function updatingFilterRuang()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function showDetailModal($barangId)
    {
        $this->selectedBarang = Barang::with(['kategori', 'ruang', 'kondisi', 'prodi'])
            ->find($barangId);
        $this->showDetail = true;
    }

    public function closeDetailModal()
    {
        $this->showDetail = false;
        $this->selectedBarang = null;
    }

    public function getStatusBadge($barang)
    {
        if ($barang->jumlah_tersedia <= 0) {
            return [
                'text' => 'Habis',
                'class' => 'bg-red-100 text-red-800 border-red-200'
            ];
        } elseif ($barang->jumlah_tersedia < ($barang->jumlah_total * 0.3)) {
            return [
                'text' => 'Terbatas',
                'class' => 'bg-yellow-100 text-yellow-800 border-yellow-200'
            ];
        } else {
            return [
                'text' => 'Tersedia',
                'class' => 'bg-green-100 text-green-800 border-green-200'
            ];
        }
    }

    public function render()
    {
        $query = Barang::with(['kategori', 'ruang', 'prodi'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('nama_barang', 'like', '%' . $this->search . '%')
                        ->orWhere('kode_barang', 'like', '%' . $this->search . '%')
                        ->orWhere('merk', 'like', '%' . $this->search . '%')
                        ->orWhereHas('kategori', function ($q) {
                            $q->where('nama_kategori', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterKategori, function ($q) {
                $q->where('kategori_id', $this->filterKategori);
            })
            ->when($this->filterRuang, function ($q) {
                $q->where('ruang_id', $this->filterRuang);
            })
            ->when($this->filterStatus, function ($q) {
                if ($this->filterStatus === 'tersedia') {
                    $q->where('jumlah_tersedia', '>', 0);
                } elseif ($this->filterStatus === 'habis') {
                    $q->where('jumlah_tersedia', '=', 0);
                }
            })
            ->latest()
            ->paginate(12);

        return view('livewire.katalog.index', [
            'barangs' => $query,
            'kategoris' => Kategori::all(),
            'ruangs' => Ruang::all(),
        ]);
    }
}
