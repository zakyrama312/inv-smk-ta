<?php

namespace App\Livewire\Kondisi;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Kondisi;
use Illuminate\Support\Str;

#[Layout('components.layouts.app')]
#[Title('Kelola Kondisi')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nama_kondisi = '';
    public $kondisiId = null;
    public $isEdit = false;
    public $showModal = false;

    protected $rules = [
        'nama_kondisi' => 'required|min:3|max:255',
    ];

    protected $messages = [
        'nama_kondisi.required' => 'Nama kondisi wajib diisi.',
        'nama_kondisi.min' => 'Nama kondisi minimal 3 karakter.',
        'nama_kondisi.max' => 'Nama kondisi maksimal 255 karakter.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function openModal()
    {
        $this->reset(['nama_kondisi', 'kondisiId', 'isEdit']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['nama_kondisi', 'kondisiId', 'isEdit']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->isEdit) {
                $kondisi = Kondisi::findOrFail($this->kondisiId);
                $kondisi->update([
                    'nama_kondisi' => $this->nama_kondisi,
                ]);

                session()->flash('success', 'Kondisi berhasil diupdate!');
            } else {
                Kondisi::create([
                    'nama_kondisi' => $this->nama_kondisi,
                    'prodi_id' => auth()->user()->prodi_id,
                ]);

                session()->flash('success', 'Kondisi berhasil ditambahkan!');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kondisi = Kondisi::findOrFail($id);
        $this->kondisiId = $kondisi->id;
        $this->nama_kondisi = $kondisi->nama_kondisi;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        try {
            $kondisi = Kondisi::findOrFail($id);

            // Check if kondisi has barang
            if ($kondisi->barangs()->count() > 0) {
                session()->flash('error', 'Kondisi tidak dapat dihapus karena masih memiliki barang!');
                return;
            }

            $kondisi->delete();
            session()->flash('success', 'Kondisi berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $prodiId = auth()->user()->prodi_id;
        $kondisis = Kondisi::query()
            ->when($this->search, function ($query) {
                $query->where('nama_kondisi', 'like', '%' . $this->search . '%');
            })
            ->withCount('barangs')
            ->latest()
            ->where('prodi_id', $prodiId)
            ->paginate(10);

        return view('livewire.kondisi.index')->with([
            'kondisis' => $kondisis,
        ]);
    }
}
