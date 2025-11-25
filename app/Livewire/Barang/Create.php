<?php

namespace App\Livewire\Barang;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\Barang;
use App\Models\BarangStok;
use App\Models\Prodi;
use App\Models\Kategori;
use App\Models\Kondisi;
use App\Models\Ruang;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
    public $jumlah_total;
    public $satuan = '';

    // Untuk distribusi ke ruangan (1 ruang, 1 jumlah)
    public $ruang_id = '';

    protected $rules = [
        'prodi_id' => 'required|exists:prodi,id',
        'kategori_id' => 'required|exists:kategori,id',
        'kondisi_id' => 'required|exists:kondisi,id',
        'ruang_id' => 'required|exists:ruang,id',
        'nama_barang' => 'required|min:3|max:255',
        'kode_barang' => 'nullable|max:255',
        'deskripsi' => 'nullable|max:1000',
        'merk' => 'nullable|max:255',
        'foto' => 'nullable|image|max:2048',
        'jumlah_total' => 'required|integer|min:1',
        'satuan' => 'required|max:50',
    ];

    protected $messages = [
        'prodi_id.required' => 'Prodi wajib dipilih.',
        'kategori_id.required' => 'Kategori wajib dipilih.',
        'kondisi_id.required' => 'Kondisi wajib dipilih.',
        'ruang_id.required' => 'Ruangan wajib dipilih.',
        'nama_barang.required' => 'Nama barang wajib diisi.',
        'nama_barang.min' => 'Nama barang minimal 3 karakter.',
        'foto.image' => 'File harus berupa gambar.',
        'foto.max' => 'Ukuran gambar maksimal 2MB.',
        'jumlah_total.required' => 'Jumlah barang wajib diisi.',
        'jumlah_total.min' => 'Jumlah barang minimal 1.',
        'satuan.required' => 'Satuan wajib diisi.',
    ];

    public function mount()
    {
        // Auto set prodi dari user yang login
        $this->prodi_id = auth()->user()->prodi_id;
    }


    public function save()
    {
        $this->validate();



        DB::beginTransaction();
        try {
            $data = [
                'prodi_id' => $this->prodi_id,
                'kategori_id' => $this->kategori_id,
                'kondisi_id' => $this->kondisi_id,

                'ruang_id' => $this->ruang_id,
                'nama_barang' => $this->nama_barang,
                'slug' => Str::slug($this->nama_barang),
                'kode_barang' => $this->kode_barang,
                'deskripsi' => $this->deskripsi,
                'merk' => $this->merk,
                'jumlah_total' => $this->jumlah_total,
                'jumlah_tersedia' => $this->jumlah_total,
            ];

            // Handle photo upload
            if ($this->foto) {
                $filename = Str::slug($this->nama_barang) . '-' . time() . '.' . $this->foto->extension();
                $path = $this->foto->storeAs('barang', $filename, 'public');

                // Create thumbnail using native PHP GD
                $thumbnailPath = 'barang/thumb-' . $filename;
                $this->createThumbnail(
                    storage_path('app/public/' . $path),
                    storage_path('app/public/' . $thumbnailPath),
                    300,
                    300
                );

                $data['foto'] = $path;
                $data['foto_thumbnail'] = $thumbnailPath;
            }

            $barang = Barang::create($data);

            BarangStok::create([
                'barang_id' => $barang->id,
                'stok_awal' => $this->jumlah_total,
                'stok_masuk' => 0,
                'stok_keluar' => 0,
                'stok_akhir' => $this->jumlah_total,
                'satuan' => $this->satuan,
                'status' => 'tersedia',
                'keterangan' => 'Stok awal barang',
            ]);


            DB::commit();
            session()->flash('success', 'Barang berhasil ditambahkan!');
            return redirect()->route('admin.barang.create');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Kategori, kondisi, dan ruang filtered by prodi user (auto)
        $kategoris = Kategori::where('prodi_id', $this->prodi_id)->get();
        $kondisis = Kondisi::where('prodi_id', $this->prodi_id)->get();
        $ruangs = Ruang::where('prodi_id', $this->prodi_id)->get();
        $prodis = Prodi::where('id', $this->prodi_id)->get();
        return view('livewire.barang.create', [
            'kategoris' => $kategoris,
            'kondisis' => $kondisis,
            'ruangs' => $ruangs,
            'prodis' => $prodis,
        ]);
    }

    // Helper function untuk create thumbnail dengan GD
    private function createThumbnail($sourcePath, $targetPath, $width, $height)
    {
        // Get image info
        $imageInfo = getimagesize($sourcePath);
        $mime = $imageInfo['mime'];

        // Create image resource from source
        switch ($mime) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $source = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($sourcePath);
                break;
            default:
                return false;
        }

        // Get original dimensions
        $origWidth = imagesx($source);
        $origHeight = imagesy($source);

        // Calculate aspect ratio
        $ratio = min($width / $origWidth, $height / $origHeight);
        $newWidth = (int)($origWidth * $ratio);
        $newHeight = (int)($origHeight * $ratio);

        // Create new image
        $thumb = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG
        if ($mime == 'image/png') {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
            imagefilledrectangle($thumb, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Resize
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Save thumbnail
        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($thumb, $targetPath, 85);
                break;
            case 'image/png':
                imagepng($thumb, $targetPath, 8);
                break;
            case 'image/gif':
                imagegif($thumb, $targetPath);
                break;
        }

        // Free memory
        imagedestroy($source);
        imagedestroy($thumb);

        return true;
    }
}
