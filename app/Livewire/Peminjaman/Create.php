<?php

namespace App\Livewire\Peminjaman;

use App\Models\Barang;
use Livewire\Component;
use App\Models\BarangStok;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $nama_peminjam;
    public $kelas;
    public $no_telepon;
    public $barang_id;
    public $jumlah_pinjam = '';
    public $tanggal_pinjam;
    public $tanggal_kembali;
    public $keperluan;

    public $selectedBarang;

    public $searchBarang = '';
    public $filteredBarangs = [];

    public function mount()
    {
        // Set default tanggal pinjam ke hari ini
        $this->tanggal_pinjam = now()->format('Y-m-d');
    }

    public function updatedSearchBarang()
    {
        if (strlen($this->searchBarang) >= 2) {
            $this->filteredBarangs = Barang::where('nama_barang', 'like', '%' . $this->searchBarang . '%')
                ->orWhereHas('ruang', function ($q) {
                    $q->where('nama_ruang', 'like', '%' . $this->searchBarang . '%');
                })
                ->with('ruang')
                ->limit(6)
                ->get();
        } else {
            $this->filteredBarangs = [];
        }
    }

    public function selectBarang($barangId)
    {
        $this->barang_id = $barangId;
        $this->selectedBarang = Barang::with('ruang')->find($barangId);
        $this->searchBarang = $this->selectedBarang->nama_barang;
        $this->filteredBarangs = [];
    }

    public function clearBarang()
    {
        $this->barang_id = null;
        $this->selectedBarang = null;
        $this->searchBarang = '';
        $this->filteredBarangs = [];
    }
    protected function rules()
    {
        return [
            'nama_peminjam' => 'required|string|max:255',
            'kelas' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20',
            'barang_id' => 'required|exists:barang,id',
            'jumlah_pinjam' => 'required|integer|min:1|max:' . (intval($this->selectedBarang->jumlah_tersedia ?? 1)),

            'keperluan' => 'required|string',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ];
    }

    protected $messages = [
        'nama_peminjam.required' => 'Nama peminjam wajib diisi',
        'kelas.required' => 'Kelas wajib diisi',
        'no_telepon.required' => 'Nomor telepon wajib diisi',
        'barang_id.required' => 'Barang wajib dipilih',
        'jumlah_pinjam.required' => 'Jumlah pinjam wajib diisi',
        'jumlah_pinjam.min' => 'Jumlah pinjam minimal 1',
        'jumlah_pinjam.max' => 'Jumlah melebihi stok tersedia',
        'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi',
        'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh sebelum hari ini',
        'tanggal_kembali.required' => 'Tanggal kembali wajib diisi',
        'tanggal_kembali.after' => 'Tanggal kembali harus setelah tanggal pinjam',
        'keperluan.required' => 'Keperluan wajib diisi',
    ];

    public function updatedBarangId($value)
    {
        $this->selectedBarang = Barang::find($value);
        $this->jumlah_pinjam = null; // Reset jumlah
    }

    public function save()
    {
        $this->selectedBarang = Barang::find($this->barang_id);
        $this->validate();
        try {
            DB::beginTransaction();

            // TAMBAHKAN VALIDASI INI
            if (!is_numeric($this->jumlah_pinjam) || $this->jumlah_pinjam <= 0) {
                throw new \Exception('Jumlah pinjam harus berupa angka valid');
            }

            // 1. Buat record peminjaman
            $peminjaman = Peminjaman::create([
                'nama_peminjam' => $this->nama_peminjam,
                'kelas' => $this->kelas,
                'no_telepon' => $this->no_telepon,
                'barang_id' => $this->barang_id,
                'jumlah_pinjam' => (int) $this->jumlah_pinjam,
                'tanggal_pinjam' => $this->tanggal_pinjam,
                'tanggal_kembali_rencana' => $this->tanggal_kembali,
                'keperluan' => $this->keperluan,
                'status' => 'pending',
            ]);


            // 2. Kurangi stok di table barangs
            $barang = Barang::find($this->barang_id);
            $barang->jumlah_tersedia = $barang->jumlah_tersedia - intval($this->jumlah_pinjam);
            $barang->save();



            // 3. Catat stok keluar di table barang_stoks
            BarangStok::create([
                'barang_id' => $this->barang_id,
                'stok_masuk' => 0,
                'stok_keluar' => (int) $this->jumlah_pinjam,
                'keterangan' => "Peminjaman oleh {$this->nama_peminjam} ({$this->kelas}) - {$this->keperluan}",

            ]);

            DB::commit();

            session()->flash('success', 'Peminjaman berhasil ditambahkan!');
            return redirect()->route('admin.peminjaman.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menambahkan peminjaman: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.peminjaman.create', [
            'barangs' => Barang::with('ruang')->where('prodi_id', auth()->user()->prodi_id)->where('jumlah_tersedia', '>', 0)->get(),
        ]);
    }
}
