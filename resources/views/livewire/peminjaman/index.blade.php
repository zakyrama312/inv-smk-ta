<div>
    <!-- Page Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Peminjaman</h2>
            <p class="text-gray-600 mt-1">Manajemen data peminjaman barang inventaris</p>
        </div>
        <a wire:navigate href="{{ route('peminjaman.create') }}"
            class="inline-flex items-center px-4 py-2 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-md transition-all transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Peminjaman
        </a>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
        <div class="flex">
            <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            <span class="text-sm text-green-700 font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
        <div class="flex">
            <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd" />
            </svg>
            <span class="text-sm text-red-700 font-medium">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="mb-6 bg-white rounded-2xl p-4 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="block w-full pl-10 pr-3 py-2.5 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Cari peminjam, kelas, atau barang...">
            </div>

            <!-- Filter Status -->
            <select wire:model.live="filterStatus"
                class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="dipinjam">Dipinjam</option>
                <option value="dikembalikan">Dikembalikan</option>
                <option value="ditolak">Ditolak</option>
            </select>


        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-linear-to-br from-yellow-400 to-yellow-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Pending</p>
                    <p class="text-2xl font-bold">{{ $peminjamans->where('status', 'pending')->count() }}</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-20 rounded-lg p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-linear-to-br from-blue-400 to-blue-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Dipinjam</p>
                    <p class="text-2xl font-bold">{{ $peminjamans->where('status', 'dipinjam')->count() }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-20 rounded-lg p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-linear-to-br from-green-400 to-green-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Dikembalikan</p>
                    <p class="text-2xl font-bold">{{ $peminjamans->where('status', 'dikembalikan')->count() }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-20 rounded-lg p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-linear-to-br from-red-400 to-red-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Ditolak</p>
                    <p class="text-2xl font-bold">{{ $peminjamans->where('status', 'ditolak')->count() }}</p>
                </div>
                <div class="bg-red-400 bg-opacity-20 rounded-lg p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 relative z-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-linear-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Peminjam
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Kontak
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Barang
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        @if (auth()->user()->isAdmin())
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($peminjamans as $index => $peminjaman)
                    <tr wire:key="peminjaman-{{ $peminjaman->id }}" class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                            {{ $peminjamans->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                <div class="font-semibold text-gray-900">{{ $peminjaman->nama_peminjam }}</div>
                                <div class="text-xs text-gray-500">{{ $peminjaman->kelas }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="https://wa.me/{{ $peminjaman->no_telepon }}" target="_blank"
                                class="inline-flex items-center px-3 py-1 bg-green-100 hover:bg-green-200 text-green-800 text-xs font-medium rounded-full transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                                {{ $peminjaman->no_telepon }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($peminjaman->barang->foto_thumbnail)
                                <img src="{{ asset('storage/' . $peminjaman->barang->foto_thumbnail) }}"
                                    alt="{{ $peminjaman->barang->nama_barang }}"
                                    class="h-10 w-10 rounded-lg object-cover">
                                @else
                                <div
                                    class="h-10 w-10 bg-linear-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                @endif
                                <div class="ml-3">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ $peminjaman->barang->nama_barang }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $peminjaman->barang->kategori->nama_kategori }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 text-sm font-bold text-gray-900 bg-gray-100 rounded-full">
                                {{ $peminjaman->jumlah }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="text-xs">
                                <div><span class="font-semibold">Pengajuan:</span>
                                    {{ $peminjaman->created_at->format('d M Y') }}
                                </div>
                                @if($peminjaman->tanggal_pinjam)
                                <div class="text-blue-600"><span class="font-semibold">Pinjam:</span>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                </div>
                                @endif
                                @if($peminjaman->tanggal_kembali_actual)
                                <!-- GANTI dari tanggal_kembali -->
                                <div class="text-green-600"><span class="font-semibold">Kembali:</span>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_actual)->format('d M Y') }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span @class([ 'px-3 py-1 text-xs font-semibold rounded-full'
                                , 'bg-yellow-100 text-yellow-800'=> $peminjaman->status === 'pending',
                                'bg-blue-100 text-blue-800' => $peminjaman->status === 'dipinjam',
                                'bg-green-100 text-green-800' => $peminjaman->status === 'dikembalikan',
                                'bg-red-100 text-red-800' => $peminjaman->status === 'ditolak',
                                ])>
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </td>
                        @if (auth()->user()->isAdmin())
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-2">
                                @if($peminjaman->status === 'pending')
                                <button wire:click="updateStatus({{ $peminjaman->id }}, 'dipinjam')"
                                    wire:confirm="Konfirmasi peminjaman ini?"
                                    class="relative z-10 inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setuju
                                </button>
                                <button wire:click="openRejectModal({{ $peminjaman->id }})"
                                    class="relative z-10 inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak
                                </button>
                                @elseif($peminjaman->status === 'dipinjam')
                                <!-- GANTI 'selesai' jadi 'dikembalikan' -->
                                <button wire:click="updateStatus({{ $peminjaman->id }}, 'dikembalikan')"
                                    wire:confirm="Tandai barang sudah dikembalikan?"
                                    class="relative z-10 inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                    </svg>
                                    Kembalikan
                                </button>
                                @endif

                                <!-- Tombol hapus hanya untuk yang bukan dikembalikan -->
                                @if($peminjaman->status !== 'dikembalikan')
                                <button wire:click="delete({{ $peminjaman->id }})"
                                    wire:confirm="Apakah Anda yakin ingin menghapus data ini?"
                                    class="relative z-10 inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                                @endif
                            </div>
                        </td>


                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Tidak ada data peminjaman</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $peminjamans->links() }}
        </div>
    </div>
    <!-- Modal Tolak Peminjaman -->
    @if($showRejectModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 ">
        <div class="relative w-full max-w-md p-4">
            <div class="relative bg-white rounded-lg shadow">

                <!-- Header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Tolak Peminjaman
                    </h3>
                    <button wire:click="closeRejectModal" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <!-- Isi Modal -->
                <div class="p-4 space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Alasan Penolakan</label>
                        <textarea wire:model="rejectReason"
                            class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-red-500 focus:border-red-500"
                            rows="4" placeholder="Tuliskan alasan penolakan..."></textarea>

                        @error('rejectReason')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end items-center p-4 border-t border-gray-200 rounded-b">
                    <button wire:click="closeRejectModal" type="button"
                        class="py-2 px-4 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Batal
                    </button>

                    <button wire:click="confirmReject" type="button"
                        class="ml-3 py-2 px-4 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg focus:ring-4 focus:ring-red-300">
                        Tolak Sekarang
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif




</div> <!-- End of main content -->


</div> <!-- End of main wrapper -->
</div>