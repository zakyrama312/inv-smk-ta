<?php

namespace App\Livewire\Kategori;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Kategori;
use Illuminate\Support\Str;

#[Layout('components.layouts.app')]
#[Title('Kelola Kategori')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nama_kategori = '';
    public $kategoriId = null;
    public $isEdit = false;
    public $showModal = false;

    protected $rules = [
        'nama_kategori' => 'required|min:3|max:255',
    ];

    protected $messages = [
        'nama_kategori.required' => 'Nama kategori wajib diisi.',
        'nama_kategori.min' => 'Nama kategori minimal 3 karakter.',
        'nama_kategori.max' => 'Nama kategori maksimal 255 karakter.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function openModal()
    {
        $this->reset(['nama_kategori', 'kategoriId', 'isEdit']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['nama_kategori', 'kategoriId', 'isEdit']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->isEdit) {
                $kategori = Kategori::findOrFail($this->kategoriId);
                $kategori->update([
                    'nama_kategori' => $this->nama_kategori,
                    'slug' => Str::slug($this->nama_kategori),
                ]);

                session()->flash('success', 'Kategori berhasil diupdate!');
            } else {
                Kategori::create([
                    'nama_kategori' => $this->nama_kategori,
                    'slug' => Str::slug($this->nama_kategori),
                ]);

                session()->flash('success', 'Kategori berhasil ditambahkan!');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        $this->kategoriId = $kategori->id;
        $this->nama_kategori = $kategori->nama_kategori;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            // Check if kategori has barang
            if ($kategori->barangs()->count() > 0) {
                session()->flash('error', 'Kategori tidak dapat dihapus karena masih memiliki barang!');
                return;
            }

            $kategori->delete();
            session()->flash('success', 'Kategori berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $kategoris = Kategori::query()
            ->when($this->search, function ($query) {
                $query->where('nama_kategori', 'like', '%' . $this->search . '%');
            })
            ->withCount('barangs')
            ->latest()
            ->where('prodi_id', auth()->user()->prodi_id)
            ->paginate(10);

        return view('livewire.kategori.index')->with([
            'kategoris' => $kategoris,
        ]);
    }
}
