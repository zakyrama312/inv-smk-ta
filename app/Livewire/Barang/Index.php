<?php

namespace App\Livewire\Barang;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Barang;
use App\Models\Prodi;
use App\Models\Kategori;

#[Layout('components.layouts.app')]
#[Title('Kelola Barang')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterProdi = '';
    public $filterKategori = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterProdi()
    {
        $this->resetPage();
    }

    public function updatingFilterKategori()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            $barang = Barang::findOrFail($id);

            // Check if barang has peminjaman aktif
            if ($barang->peminjamans()->where('status', 'dipinjam')->count() > 0) {
                session()->flash('error', 'Barang tidak dapat dihapus karena masih sedang dipinjam!');
                return;
            }

            // Delete photo if exists
            if ($barang->foto && \Storage::exists($barang->foto)) {
                \Storage::delete($barang->foto);
            }
            if ($barang->foto_thumbnail && \Storage::exists($barang->foto_thumbnail)) {
                \Storage::delete($barang->foto_thumbnail);
            }

            $barang->delete();
            session()->flash('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Barang::query()
            ->with(['prodi', 'kategori', 'kondisi']);

        // Apply filters based on user role
        if (auth()->user()->isKaprodi() || auth()->user()->isAnggota()) {
            $query->where('prodi_id', auth()->user()->prodi_id);
        }

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_barang', 'like', '%' . $this->search . '%')
                    ->orWhere('kode_barang', 'like', '%' . $this->search . '%')
                    ->orWhere('merk', 'like', '%' . $this->search . '%');
            });
        }

        // Apply filters
        if ($this->filterProdi) {
            $query->where('prodi_id', $this->filterProdi);
        }

        if ($this->filterKategori) {
            $query->where('kategori_id', $this->filterKategori);
        }

        $barangs = $query->latest()->paginate(10);

        // Get filter options
        $prodis = auth()->user()->isAdmin()
            ? Prodi::all()
            : Prodi::where('id', auth()->user()->prodi_id)->get();

        $kategoris = Kategori::all();

        return view('livewire.barang.index')->with([
            'barangs' => $barangs,
            'prodis' => $prodis,
            'kategoris' => $kategoris,
        ]);
    }
}
