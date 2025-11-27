<div class="min-h-screen ">
    <!-- Page Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1
                        class="text-3xl font-bold bg-linear-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        📦 Katalog Barang
                    </h1>
                    <p class="text-gray-600 mt-1">Jelajahi koleksi barang inventaris kami</p>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <div class="text-center px-4 py-2 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-xs text-blue-600 font-semibold">Total Barang</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $barangs->total() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search & Filter Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Bar -->
                <div class="md:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="block w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-400"
                            placeholder="Cari nama barang, kode, atau merk...">
                    </div>
                </div>

                <!-- Filter Kategori -->
                <div>
                    <select wire:model.live="filterKategori"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status -->
                <div>
                    <select wire:model.live="filterStatus"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
            </div>

            <!-- Active Filters -->
            @if($search || $filterKategori || $filterStatus)
            <div class="mt-4 flex flex-wrap gap-2">
                <span class="text-sm text-gray-600">Filter aktif:</span>
                @if($search)
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Pencarian: "{{ $search }}"
                    <button wire:click="$set('search', '')" class="ml-2 hover:text-blue-900">×</button>
                </span>
                @endif
                @if($filterKategori)
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    Kategori
                    <button wire:click="$set('filterKategori', '')" class="ml-2 hover:text-purple-900">×</button>
                </span>
                @endif
                @if($filterStatus)
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Status: {{ ucfirst($filterStatus) }}
                    <button wire:click="$set('filterStatus', '')" class="ml-2 hover:text-green-900">×</button>
                </span>
                @endif
            </div>
            @endif
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6">
            @forelse($barangs as $barang)
            @php
            $status = $this->getStatusBadge($barang);
            @endphp
            <div wire:key="barang-{{ $barang->id }}"
                class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">

                <!-- Image Container -->
                <div class="relative h-48 bg-linear-to-br from-blue-100 to-purple-100 overflow-hidden">
                    @if($barang->foto_thumbnail)
                    <img src="{{ asset('storage/' . $barang->foto_thumbnail) }}" alt="{{ $barang->nama_barang }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-20 h-20 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    @endif

                    <!-- Status Badge (Floating) -->
                    <div class="absolute top-3 right-3">
                        <span
                            class="px-3 py-1 text-xs font-bold rounded-full border shadow-sm backdrop-blur-sm {{ $status['class'] }}">
                            {{ $status['text'] }}
                        </span>
                    </div>

                    <!-- Quick View Button -->
                    <button wire:click="showDetailModal({{ $barang->id }})"
                        class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <span
                            class="px-4 py-2 bg-white text-gray-900 rounded-lg font-semibold text-sm shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform">
                            👁️ Lihat Detail
                        </span>
                    </button>
                </div>

                <!-- Card Content -->
                <div class="p-4">
                    <!-- Category -->
                    <div class="mb-2">
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $barang->kategori->nama_kategori }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h3
                        class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-blue-600 transition-colors">
                        {{ $barang->nama_barang }}
                    </h3>

                    <!-- Code -->
                    <p class="text-xs text-gray-500 mb-3 font-mono">{{ $barang->kode_barang }}</p>

                    <!-- Details -->
                    <div class="space-y-2 mb-4">
                        @if($barang->merk)
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span class="truncate">{{ $barang->merk }}</span>
                        </div>
                        @endif

                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="truncate">{{ $barang->ruang->nama_ruang }}</span>
                        </div>
                    </div>

                    <!-- Stock Info -->
                    <div class="pt-3 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 font-medium">Stok Tersedia</span>
                            <div class="flex items-center space-x-1">
                                <span
                                    class="text-lg font-bold {{ $barang->jumlah_tersedia > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $barang->jumlah_tersedia }}
                                </span>
                                <span class="text-sm text-gray-400">/</span>
                                <span class="text-sm text-gray-500">{{ $barang->jumlah_total }}</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-1.5">
                            @php
                            $percentage = $barang->jumlah_total > 0 ? ($barang->jumlah_tersedia / $barang->jumlah_total)
                            * 100 : 0;

                            $width = $percentage . '%';

                            @endphp
                            <div
                                class="h-1.5 rounded-full transition-all {{ $percentage > 50 ? 'bg-green-500' : ($percentage > 0 ? 'bg-yellow-500' : 'bg-red-500') }} w-[{{ $width }}]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="col-span-full">
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Tidak ada barang ditemukan</h3>
                    <p class="mt-2 text-sm text-gray-500">Coba ubah filter atau kata kunci pencarian</p>
                    @if($search || $filterKategori || $filterStatus)
                    <button wire:click="$set('search', ''); $set('filterKategori', ''); $set('filterStatus', '')"
                        class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                        Reset Filter
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($barangs->hasPages())
        <div class="mt-8">
            {{ $barangs->links() }}
        </div>
        @endif
    </div>

    <!-- Detail Modal -->
    @if($showDetail && $selectedBarang)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="closeDetailModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <!-- Modal Header -->
                <div class="bg-linear-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Detail Barang</h3>
                        <button wire:click="closeDetailModal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left: Image -->
                        <div>
                            <div
                                class="relative h-80 bg-linear-to-br from-blue-100 to-purple-100 rounded-xl overflow-hidden">
                                @if($selectedBarang->foto)
                                <img src="{{ asset('storage/' . $selectedBarang->foto) }}"
                                    alt="{{ $selectedBarang->nama_barang }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right: Details -->
                        <div class="space-y-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $selectedBarang->nama_barang }}
                                </h2>
                                <p class="text-sm text-gray-500 font-mono">{{ $selectedBarang->kode_barang }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                                    <p class="text-xs text-blue-600 font-semibold mb-1">Kategori</p>
                                    <p class="text-sm font-bold text-gray-900">
                                        {{ $selectedBarang->kategori->nama_kategori }}
                                    </p>
                                </div>
                                <div class="bg-purple-50 rounded-lg p-3 border border-purple-200">
                                    <p class="text-xs text-purple-600 font-semibold mb-1">Ruang</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $selectedBarang->ruang->nama_ruang }}
                                    </p>
                                </div>
                            </div>

                            @if($selectedBarang->merk)
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Merk/Brand</p>
                                <p class="text-base text-gray-900">{{ $selectedBarang->merk }}</p>
                            </div>
                            @endif

                            @if($selectedBarang->deskripsi)
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Deskripsi</p>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $selectedBarang->deskripsi }}</p>
                            </div>
                            @endif

                            <div class="pt-4 border-t border-gray-200">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center bg-green-50 rounded-lg p-4 border border-green-200">
                                        <p class="text-xs text-green-600 font-semibold mb-1">Stok Tersedia</p>
                                        <p class="text-3xl font-bold text-green-700">
                                            {{ $selectedBarang->jumlah_tersedia }}
                                        </p>
                                    </div>
                                    <div class="text-center bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <p class="text-xs text-gray-600 font-semibold mb-1">Total Stok</p>
                                        <p class="text-3xl font-bold text-gray-700">{{ $selectedBarang->jumlah_total }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @php
                            $statusDetail = $this->getStatusBadge($selectedBarang);
                            @endphp
                            <div class="flex items-center justify-center pt-2">
                                <span
                                    class="px-4 py-2 text-sm font-bold rounded-full border {{ $statusDetail['class'] }}">
                                    {{ $statusDetail['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <button wire:click="closeDetailModal"
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>