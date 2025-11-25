<?php

namespace App\Livewire\Peminjaman;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Peminjaman;
use App\Models\Prodi;
use App\Models\BarangStok;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterProdi = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterProdi' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterProdi()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($id);
            $barang = $peminjaman->barang;

            // Kembalikan stok jika peminjaman belum selesai
            if ($peminjaman->status !== 'selesai') {
                $barang->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);

                // Catat pembatalan di barang_stoks
                BarangStok::create([
                    'barang_id' => $peminjaman->barang_id,
                    'stok_masuk' => $peminjaman->jumlah_pinjam,
                    'stok_keluar' => 0,
                    'keterangan' => "Penghapusan peminjaman - {$peminjaman->nama_peminjam} ({$peminjaman->kelas})",
                    'tanggal' => now(),
                    'user_id' => auth()->id(),
                ]);
            }

            $peminjaman->delete();

            DB::commit();
            session()->flash('success', 'Data peminjaman berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($id);
            $barang = $peminjaman->barang;

            if ($status === 'dipinjam' && $peminjaman->status === 'pending') {
                // Konfirmasi peminjaman
                $peminjaman->update([
                    'status' => 'dipinjam',
                    'tanggal_pinjam' => now(),
                ]);
                session()->flash('success', 'Peminjaman berhasil dikonfirmasi!');
            } elseif ($status === 'selesai' && $peminjaman->status === 'dipinjam') {
                // Kembalikan barang
                $peminjaman->update([
                    'status' => 'selesai',
                    'tanggal_kembali' => now(),
                ]);

                // Tambah stok kembali di table barangs
                $barang->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);

                // Catat stok masuk di table barang_stoks
                BarangStok::create([
                    'barang_id' => $peminjaman->barang_id,
                    'stok_masuk' => $peminjaman->jumlah_pinjam,
                    'stok_keluar' => 0,
                    'keterangan' => "Pengembalian dari {$peminjaman->nama_peminjam} ({$peminjaman->kelas})",
                    'tanggal' => now(),
                    'user_id' => auth()->id(),
                ]);

                session()->flash('success', 'Barang berhasil dikembalikan!');
            } elseif ($status === 'ditolak' && $peminjaman->status === 'pending') {
                // Tolak peminjaman - kembalikan stok
                $peminjaman->update(['status' => 'ditolak']);

                // Tambah stok kembali di table barangs
                $barang->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);

                // Catat pembatalan di table barang_stoks
                BarangStok::create([
                    'barang_id' => $peminjaman->barang_id,
                    'stok_masuk' => $peminjaman->jumlah_pinjam,
                    'stok_keluar' => 0,
                    'keterangan' => "Pembatalan peminjaman - {$peminjaman->nama_peminjam} ({$peminjaman->kelas})",
                    'tanggal' => now(),
                    'user_id' => auth()->id(),
                ]);

                session()->flash('success', 'Peminjaman ditolak!');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Peminjaman::with(['barang.kategori', 'barang.prodi'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('nama_peminjam', 'like', '%' . $this->search . '%')
                        ->orWhere('kelas', 'like', '%' . $this->search . '%')
                        ->orWhere('no_telepon', 'like', '%' . $this->search . '%')
                        ->orWhereHas('barang', function ($q) {
                            $q->where('nama_barang', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->when($this->filterProdi, function ($q) {
                $q->whereHas('barang', function ($query) {
                    $query->where('prodi_id', $this->filterProdi);
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.peminjaman.index', [
            'peminjamans' => $query,
            'prodis' => Prodi::all(),
        ]);
    }
}
