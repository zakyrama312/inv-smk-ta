<?php

namespace App\Livewire\Barang;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\Barang;
use App\Models\Prodi;
use App\Models\Kategori;
use App\Models\Kondisi;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

#[Layout('components.layouts.app')]
#[Title('Tambah Barang')]
class Create extends Component
{
    use WithFileUploads;

    public $prodi_id = '';
    public $kategori_id = '';
    public $kondisi_id = '';
    public $nama_barang = '';
    public $kode_barang = '';
    public $deskripsi = '';
    public $merk = '';
    public $foto;
    public $jumlah_total = 1;

    protected $rules = [
        'prodi_id' => 'required|exists:prodi,id',
        'kategori_id' => 'required|exists:kategori,id',
        'kondisi_id' => 'required|exists:kondisi,id',
        'nama_barang' => 'required|min:3|max:255',
        'kode_barang' => 'nullable|unique:barang,kode_barang|max:255',
        'deskripsi' => 'nullable|max:1000',
        'merk' => 'nullable|max:255',
        'foto' => 'nullable|image|max:2048', // max 2MB
        'jumlah_total' => 'required|integer|min:1',
    ];

    protected $messages = [
        'prodi_id.required' => 'Prodi wajib dipilih.',
        'kategori_id.required' => 'Kategori wajib dipilih.',
        'kondisi_id.required' => 'Kondisi wajib dipilih.',
        'nama_barang.required' => 'Nama barang wajib diisi.',
        'nama_barang.min' => 'Nama barang minimal 3 karakter.',
        'kode_barang.unique' => 'Kode barang sudah digunakan.',
        'foto.image' => 'File harus berupa gambar.',
        'foto.max' => 'Ukuran gambar maksimal 2MB.',
        'jumlah_total.required' => 'Jumlah barang wajib diisi.',
        'jumlah_total.min' => 'Jumlah barang minimal 1.',
    ];

    public function mount()
    {
        // Set default prodi for kaprodi/anggota
        if (auth()->user()->isKaprodi() || auth()->user()->isAnggota()) {
            $this->prodi_id = auth()->user()->prodi_id;
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'prodi_id' => $this->prodi_id,
                'kategori_id' => $this->kategori_id,
                'kondisi_id' => $this->kondisi_id,
                'nama_barang' => $this->nama_barang,
                'slug' => Str::slug($this->nama_barang),
                'kode_barang' => $this->kode_barang,
                'deskripsi' => $this->deskripsi,
                'merk' => $this->merk,
                'jumlah_total' => $this->jumlah_total,
                'jumlah_tersedia' => $this->jumlah_total, // Same as total initially
            ];

            // Handle photo upload
            if ($this->foto) {
                $filename = Str::slug($this->nama_barang) . '-' . time() . '.' . $this->foto->extension();
                $path = $this->foto->storeAs('barang', $filename, 'public');

                // Create thumbnail (optional)
                $thumbnailPath = 'barang/thumb-' . $filename;
                $img = Image::make($this->foto->getRealPath());
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save(storage_path('app/public/' . $thumbnailPath));

                $data['foto'] = $path;
                $data['foto_thumbnail'] = $thumbnailPath;
            }

            Barang::create($data);

            session()->flash('success', 'Barang berhasil ditambahkan!');
            return redirect()->route('barang.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $prodis = auth()->user()->isAdmin()
            ? Prodi::all()
            : Prodi::where('id', auth()->user()->prodi_id)->get();

        $kategoris = Kategori::all();
        $kondisis = Kondisi::all();

        return view('livewire.barang.create', [
            'prodis' => $prodis,
            'kategoris' => $kategoris,
            'kondisis' => $kondisis,
        ]);
    }
}
