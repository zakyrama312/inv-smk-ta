<?php

namespace App\Livewire\Barang;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Kondisi;
use App\Models\Ruang;
use App\Models\Prodi;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $barangId;
    public $nama_barang;
    public $merk;
    public $kategori_id;
    public $kondisi_id;
    public $jumlah_total;
    public $jumlah_tersedia;
    public $ruang_id;
    public $prodi_id;
    public $keterangan;
    public $foto_thumbnail;
    public $existing_foto;

    protected function rules()
    {
        return [
            'nama_barang' => 'required|string|max:255',
            'merk' => 'nullable|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'kondisi_id' => 'required|exists:kondisis,id',
            'jumlah_total' => 'required|integer|min:1',
            'jumlah_tersedia' => 'required|integer|min:0|lte:jumlah_total',
            'ruang_id' => 'required|exists:ruangs,id',
            'prodi_id' => 'required|exists:prodis,id',
            'keterangan' => 'nullable|string',
            'foto_thumbnail' => 'nullable|image|max:2048', // max 2MB
        ];
    }

    protected $messages = [
        'nama_barang.required' => 'Nama barang wajib diisi',
        'kategori_id.required' => 'Kategori wajib dipilih',
        'kondisi_id.required' => 'Kondisi wajib dipilih',
        'jumlah_total.required' => 'Jumlah total wajib diisi',
        'jumlah_total.min' => 'Jumlah total minimal 1',
        'jumlah_tersedia.required' => 'Jumlah tersedia wajib diisi',
        'jumlah_tersedia.lte' => 'Jumlah tersedia tidak boleh lebih dari jumlah total',
        'ruang_id.required' => 'Ruang wajib dipilih',
        'prodi_id.required' => 'Prodi wajib dipilih',
        'foto_thumbnail.image' => 'File harus berupa gambar',
        'foto_thumbnail.max' => 'Ukuran gambar maksimal 2MB',
    ];

    public function mount($id)
    {
        $barang = Barang::findOrFail($id);

        $this->barangId = $barang->id;
        $this->nama_barang = $barang->nama_barang;
        $this->merk = $barang->merk;
        $this->kategori_id = $barang->kategori_id;
        $this->kondisi_id = $barang->kondisi_id;
        $this->jumlah_total = $barang->jumlah_total;
        $this->jumlah_tersedia = $barang->jumlah_tersedia;
        $this->ruang_id = $barang->ruang_id;
        $this->prodi_id = $barang->prodi_id;
        $this->keterangan = $barang->keterangan;
        $this->existing_foto = $barang->foto_thumbnail;
    }

    public function update()
    {
        $this->validate();

        try {
            $barang = Barang::findOrFail($this->barangId);

            $data = [
                'nama_barang' => $this->nama_barang,
                'merk' => $this->merk,
                'kategori_id' => $this->kategori_id,
                'kondisi_id' => $this->kondisi_id,
                'jumlah_total' => $this->jumlah_total,
                'jumlah_tersedia' => $this->jumlah_tersedia,
                'ruang_id' => $this->ruang_id,
                'prodi_id' => $this->prodi_id,
                'keterangan' => $this->keterangan,
            ];

            // Handle foto upload
            if ($this->foto_thumbnail) {
                // Hapus foto lama jika ada
                if ($this->existing_foto) {
                    Storage::disk('public')->delete($this->existing_foto);
                }

                $data['foto_thumbnail'] = $this->foto_thumbnail->store('barang', 'public');
            }

            $barang->update($data);

            session()->flash('success', 'Barang berhasil diperbarui!');
            return redirect()->route('admin.barang.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memperbarui barang: ' . $e->getMessage());
        }
    }

    public function removePhoto()
    {
        if ($this->existing_foto) {
            Storage::disk('public')->delete($this->existing_foto);

            $barang = Barang::findOrFail($this->barangId);
            $barang->update(['foto_thumbnail' => null]);

            $this->existing_foto = null;
            session()->flash('success', 'Foto berhasil dihapus!');
        }
    }

    public function render()
    {
        return view('livewire.barang.edit', [
            'kategoris' => Kategori::all(),
            'kondisis' => Kondisi::all(),
            'ruangs' => Ruang::all(),
            'prodis' => Prodi::all(),
        ]);
    }
}
