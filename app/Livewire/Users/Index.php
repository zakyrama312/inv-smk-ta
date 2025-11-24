<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Prodi;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.app')]
#[Title('Kelola Users')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = '';
    public $filterProdi = '';

    public $userId = null;
    public $name = '';
    public $username = '';
    public $password = '';
    public $role = 'anggota';
    public $prodi_id = '';

    public $isEdit = false;
    public $showModal = false;

    protected function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'username' => 'required|min:3|max:255|unique:users,username,' . $this->userId,
            'role' => 'required|in:admin,kaprodi,anggota',
        ];

        // Password wajib saat create, optional saat edit
        if (!$this->isEdit) {
            $rules['password'] = 'required|min:6';
        } else if ($this->password) {
            $rules['password'] = 'min:6';
        }

        // Prodi wajib untuk kaprodi dan anggota
        if (in_array($this->role, ['kaprodi', 'anggota'])) {
            $rules['prodi_id'] = 'required|exists:prodi,id';
        }

        return $rules;
    }

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'name.min' => 'Nama minimal 3 karakter.',
        'username.required' => 'Username wajib diisi.',
        'username.min' => 'Username minimal 3 karakter.',
        'username.unique' => 'Username sudah digunakan.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'role.required' => 'Role wajib dipilih.',
        'prodi_id.required' => 'Prodi wajib dipilih untuk role Kaprodi dan Anggota.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function updatingFilterProdi()
    {
        $this->resetPage();
    }

    // Reset prodi_id ketika role admin dipilih
    public function updatedRole($value)
    {
        if ($value === 'admin') {
            $this->prodi_id = '';
        }
    }

    public function openModal()
    {
        $this->reset(['name', 'username', 'password', 'role', 'prodi_id', 'userId', 'isEdit']);
        $this->role = 'anggota'; // default role
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'username', 'password', 'role', 'prodi_id', 'userId', 'isEdit']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->isEdit) {
                $user = User::findOrFail($this->userId);

                $data = [
                    'name' => $this->name,
                    'username' => $this->username,
                    'role' => $this->role,
                    'prodi_id' => $this->role === 'admin' ? null : $this->prodi_id,
                ];

                // Update password jika diisi
                if ($this->password) {
                    $data['password'] = Hash::make($this->password);
                }

                $user->update($data);

                session()->flash('success', 'User berhasil diupdate!');
            } else {
                User::create([
                    'name' => $this->name,
                    'username' => $this->username,
                    'password' => Hash::make($this->password),
                    'role' => $this->role,
                    'prodi_id' => $this->role === 'admin' ? null : $this->prodi_id,
                ]);

                session()->flash('success', 'User berhasil ditambahkan!');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->role = $user->role;
        $this->prodi_id = $user->prodi_id ?? '';
        $this->password = ''; // Kosongkan password
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);

            // Tidak bisa hapus diri sendiri
            if ($user->id === auth()->id()) {
                session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
                return;
            }

            $user->delete();
            session()->flash('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $prodiId = auth()->user()->prodi_id;
        $users = User::query()
            ->with('prodi')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, function ($query) {
                $query->where('role', $this->filterRole);
            })
            ->when($this->filterProdi, function ($query) {
                $query->where('prodi_id', $this->filterProdi);
            })
            ->where('prodi_id', $prodiId)
            ->latest()
            ->paginate(10);

        $prodis = Prodi::all();

        return view('livewire.users.index', [
            'users' => $users,
            'prodis' => $prodis,
        ]);
    }
}
