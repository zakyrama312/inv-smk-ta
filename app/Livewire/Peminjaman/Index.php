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

    // Property untuk modal tolak
    public $showRejectModal = false;
    public $rejectPeminjamanId = null;
    public $rejectReason = '';

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

    // Method untuk buka modal tolak
    public function openRejectModal($id)
    {
        $this->rejectPeminjamanId = $id;
        $this->rejectReason = '';
        $this->showRejectModal = true;
    }

    // Method untuk tutup modal
    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->rejectPeminjamanId = null;
        $this->rejectReason = '';
    }

    // Method untuk confirm tolak dengan alasan
    public function confirmReject()
    {
        $this->validate([
            'rejectReason' => 'required|string|min:10',
        ], [
            'rejectReason.required' => 'Alasan penolakan wajib diisi',
            'rejectReason.min' => 'Alasan penolakan minimal 10 karakter',
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($this->rejectPeminjamanId);

            if ($peminjaman->status !== 'pending') {
                throw new \Exception('Hanya peminjaman dengan status pending yang bisa ditolak');
            }

            // Update status dan keterangan
            $peminjaman->update([
                'status' => 'ditolak',
                'keterangan' => "Ditolak: " . $this->rejectReason,
            ]);

            // TIDAK perlu kembalikan stok karena stok belum dikurangi saat pending

            DB::commit();

            $this->closeRejectModal();
            session()->flash('success', 'Peminjaman berhasil ditolak!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menolak peminjaman: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($id);
            $barang = $peminjaman->barang;

            // Kembalikan stok HANYA jika status 'dipinjam' (sudah disetujui)
            if ($peminjaman->status === 'dipinjam') {
                $barang->increment('jumlah_tersedia', $peminjaman->jumlah);

                // Catat pembatalan di barang_stok
                BarangStok::create([
                    'barang_id' => $peminjaman->barang_id,
                    'stok_masuk' => $peminjaman->jumlah,
                    'stok_keluar' => 0,
                    'tipe_transaksi' => 'penyesuaian',
                    'referensi_id' => null,
                    'referensi_tipe' => null,
                    'keterangan' => "Penghapusan peminjaman (dibatalkan) - {$peminjaman->nama_peminjam} ({$peminjaman->kelas})",
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

            if ($status === 'dipinjam' && $peminjaman->status === 'pending') {
                // Konfirmasi peminjaman (pending -> dipinjam)
                // Event 'updated' di Model akan otomatis kurangi stok

                $peminjaman->update([
                    'status' => 'dipinjam',
                    'tanggal_pinjam' => now(),
                ]);

                session()->flash('success', 'Peminjaman berhasil dikonfirmasi!');
            } elseif ($status === 'dikembalikan' && $peminjaman->status === 'dipinjam') {
                // Kembalikan barang (dipinjam -> dikembalikan)
                // Event 'updated' di Model akan otomatis tambah stok

                $peminjaman->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali_actual' => now(),
                ]);

                session()->flash('success', 'Barang berhasil dikembalikan!');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal mengubah status: ' . $e->getMessage());

            \Log::error('Update Status Error', [
                'peminjaman_id' => $id,
                'status_baru' => $status,
                'error' => $e->getMessage(),
            ]);
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
