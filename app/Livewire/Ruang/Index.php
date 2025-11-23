<?php

namespace App\Livewire\Ruang;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Ruang;
use Illuminate\Support\Str;

#[Layout('components.layouts.app')]
#[Title('Kelola Ruang')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nama_ruang = '';
    public $ruangId = null;
    public $isEdit = false;
    public $showModal = false;

    protected $rules = [
        'nama_ruang' => 'required|min:3|max:255',
    ];

    protected $messages = [
        'nama_ruang.required' => 'Nama ruang wajib diisi.',
        'nama_ruang.min' => 'Nama ruang minimal 3 karakter.',
        'nama_ruang.max' => 'Nama ruang maksimal 255 karakter.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function openModal()
    {
        $this->reset(['nama_ruang', 'ruangId', 'isEdit']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['nama_ruang', 'ruangId', 'isEdit']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->isEdit) {
                $ruang = Ruang::findOrFail($this->ruangId);
                $ruang->update([
                    'nama_ruang' => $this->nama_ruang,
                    'slug' => Str::slug($this->nama_ruang),
                ]);

                session()->flash('success', 'Ruang berhasil diupdate!');
            } else {
                Ruang::create([
                    'nama_ruang' => $this->nama_ruang,
                    'slug' => Str::slug($this->nama_ruang),
                ]);

                session()->flash('success', 'Ruang berhasil ditambahkan!');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ruang = Ruang::findOrFail($id);
        $this->ruangId = $ruang->id;
        $this->nama_ruang = $ruang->nama_ruang;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        try {
            $ruang = Ruang::findOrFail($id);

            // Check if ruang has barang
            if ($ruang->barangStoks()->count() > 0) {
                session()->flash('error', 'Ruang tidak dapat dihapus karena masih memiliki barang!');
                return;
            }

            $ruang->delete();
            session()->flash('success', 'Ruang berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $ruangs = Ruang::query()
            ->when($this->search, function ($query) {
                $query->where('nama_ruang', 'like', '%' . $this->search . '%');
            })
            ->withCount('barangStoks')
            ->latest()
            ->paginate(10);

        return view('livewire.ruang.index')->with([
            'ruangs' => $ruangs,
        ]);
    }
}
