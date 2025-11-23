<?php

namespace App\Livewire\Prodi;

use App\Models\Prodi;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Layout('components.layouts.app')]
#[Title('Kelola prodi')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nama_prodi = '';
    public $prodiId = null;
    public $isEdit = false;
    public $showModal = false;

    protected $rules = [
        'nama_prodi' => 'required|min:3|max:255',
    ];

    protected $messages = [
        'nama_prodi.required' => 'Nama prodi wajib diisi.',
        'nama_prodi.min' => 'Nama prodi minimal 3 karakter.',
        'nama_prodi.max' => 'Nama prodi maksimal 255 karakter.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function openModal()
    {
        $this->reset(['nama_prodi', 'prodiId', 'isEdit']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['nama_prodi', 'prodiId', 'isEdit']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->isEdit) {
                $prodi = Prodi::findOrFail($this->prodiId);
                $prodi->update([
                    'nama_prodi' => $this->nama_prodi,
                    'slug' => Str::slug($this->nama_prodi),
                ]);

                session()->flash('success', 'prodi berhasil diupdate!');
            } else {
                Prodi::create([
                    'nama_prodi' => $this->nama_prodi,
                    'slug' => Str::slug($this->nama_prodi),
                ]);

                session()->flash('success', 'prodi berhasil ditambahkan!');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $prodi = Prodi::findOrFail($id);
        $this->prodiId = $prodi->id;
        $this->nama_prodi = $prodi->nama_prodi;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        try {
            $prodi = Prodi::findOrFail($id);

            // Check if prodi has barang
            if ($prodi->barangs()->count() > 0) {
                session()->flash('error', 'prodi tidak dapat dihapus karena masih memiliki barang!');
                return;
            }

            $prodi->delete();
            session()->flash('success', 'prodi berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $prodis = Prodi::query()
            ->when($this->search, function ($query) {
                $query->where('nama_prodi', 'like', '%' . $this->search . '%');
            })
            ->withCount('barangs')
            ->latest()
            ->paginate(10);

        return view('livewire.prodi.index')->with([
            'prodis' => $prodis,
        ]);
    }
}