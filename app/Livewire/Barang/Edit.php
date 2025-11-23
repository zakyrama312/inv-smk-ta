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
#[Title('Edit Barang')]
class Edit extends Component
{
    use WithFileUploads;

    public Barang $barang;
    public $prodi_id;
    public $kategori_id;
    public $kondisi_id;
    public $nama_barang;
    public $kode_barang;
    public $deskripsi;
    public $merk;
    public $foto;
    public $jumlah_total;
    public $existing_foto;

    protected function rules()
    {
        return [
            'prodi_id' => 'required|exists:prodi,id',
            'kategori_id' => 'required|exists:kategori,id',
            'kondisi_id' => 'required|exists:kondisi,id',
            'nama_barang' => 'required|min:3|max:255',
            'kode_barang' => 'nullable|unique:barang,kode_barang,' . $this->barang->id . '|max:255',
            'deskripsi' => 'nullable|max:1000',
            'merk' => 'nullable|max:255',
            'foto' => 'nullable|image|max:2048',
            'jumlah_total' => 'required|integer|min:1',
        ];
    }

    protected $messages = [
        'prodi_id.required' => 'Prodi wajib dipilih.',
        'kategori_id.required' => 'Kategori wajib dipilih.',
        'kondisi_id.required' => 'Kondisi wajib dipilih.',
        'nama_barang.required' => 'Nama barang wajib diisi.',
        'kode_barang.unique' => 'Kode barang sudah digunakan.',
        'foto.image' => 'File harus berupa gambar.',
        'foto.max' => 'Ukuran gambar maksimal 2MB.',
        'jumlah_total.required' => 'Jumlah barang wajib diisi.',
    ];

    public function mount(Barang $barang)
    {
        $this->barang = $barang;
        $this->prodi_id = $barang->prodi_id;
        $this->kategori_id = $barang->kategori_id;
        $this->kondisi_id = $barang->kondisi_id;
        $this->nama_barang = $barang->nama_barang;
        $this->kode_barang = $barang->kode_barang;
        $this->deskripsi = $barang->deskripsi;
        $this->merk = $barang->merk;
        $this->jumlah_total = $barang->jumlah_total;
        $this->existing_foto = $barang->foto;
    }

    public function update()
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
            ];

            // Handle photo upload
            if ($this->foto) {
                // Delete old photos
                if ($this->barang->foto && \Storage::exists('public/' . $this->barang->foto)) {
                    \Storage::delete('public/' . $this->barang->foto);
                }
                if ($this->barang->foto_thumbnail && \Storage::exists('public/' . $this->barang->foto_thumbnail)) {
                    \Storage::delete('public/' . $this->barang->foto_thumbnail);
                }

                // Upload new photo
                $filename = Str::slug($this->nama_barang) . '-' . time() . '.' . $this->foto->extension();
                $path = $this->foto->storeAs('barang', $filename, 'public');

                // Create thumbnail
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

            // Update jumlah_tersedia proportionally
            $selisih = $this->jumlah_total - $this->barang->jumlah_total;
            $data['jumlah_tersedia'] = $this->barang->jumlah_tersedia + $selisih;

            $this->barang->update($data);

            session()->flash('success', 'Barang berhasil diupdate!');
            return redirect()->route('barang.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deletePhoto()
    {
        try {
            if ($this->barang->foto && \Storage::exists('public/' . $this->barang->foto)) {
                \Storage::delete('public/' . $this->barang->foto);
            }
            if ($this->barang->foto_thumbnail && \Storage::exists('public/' . $this->barang->foto_thumbnail)) {
                \Storage::delete('public/' . $this->barang->foto_thumbnail);
            }

            $this->barang->update([
                'foto' => null,
                'foto_thumbnail' => null,
            ]);

            $this->existing_foto = null;
            session()->flash('success', 'Foto berhasil dihapus!');
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

        return view('livewire.barang.edit', [
            'prodis' => $prodis,
            'kategoris' => $kategoris,
            'kondisis' => $kondisis,
        ]);
    }
}
