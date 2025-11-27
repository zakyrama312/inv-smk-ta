<div wire:poll.3s>
    <div class="relative" x-data="{ dropdownOpen: false }" @click.away="dropdownOpen = false">
        <!-- Bell Button -->
        <button @click="dropdownOpen = !dropdownOpen" type="button"
            class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <!-- Bell Icon -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>

            <!-- Badge Counter -->
            @if($pendingCount > 0)
            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span
                    class="relative inline-flex items-center justify-center rounded-full h-5 w-5 bg-red-500 text-white text-xs font-bold">
                    {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                </span>
            </span>
            @endif
        </button>

        <!-- Dropdown Menu -->
        <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden"
            style="display: none;">

            <!-- Header -->
            <div class="bg-linear-to-r from-yellow-500 to-yellow-600 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-white flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Peminjaman Pending
                    </h3>
                    @if($pendingCount > 0)
                    <span class="px-2 py-1 bg-white bg-opacity-20 text-yellow-600 text-xs font-bold rounded-full">
                        {{ $pendingCount }}
                    </span>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="max-h-96 overflow-y-auto">
                @if($pendingPeminjamans->count() > 0)
                @foreach($pendingPeminjamans as $peminjaman)
                <a wire:navigate href="{{ route('peminjaman.index') }}" wire:key="notif-{{ $peminjaman->id }}"
                    @click="dropdownOpen = false"
                    class="block px-4 py-3 hover:bg-blue-50 transition-colors border-b border-gray-100">

                    <div class="flex items-start space-x-3">
                        <!-- Icon/Image -->
                        <div class="shrink-0">
                            @if($peminjaman->barang->foto_thumbnail)
                            <img src="{{ asset('storage/' . $peminjaman->barang->foto_thumbnail) }}"
                                alt="{{ $peminjaman->barang->nama_barang }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                            <div
                                class="w-12 h-12 bg-linear-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $peminjaman->nama_peminjam }}
                                        <span class="text-xs text-gray-500 font-normal">-
                                            {{ $peminjaman->kelas }}</span>
                                    </p>
                                    <p class="text-xs text-gray-600 mt-0.5 truncate">
                                        📦 {{ $peminjaman->barang->nama_barang }}
                                        <span class="font-semibold text-blue-600">({{ $peminjaman->jumlah }}
                                            unit)</span>
                                    </p>
                                </div>
                                <span
                                    class="shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                    Pending
                                </span>
                            </div>

                            <!-- Time -->
                            <div class="flex items-center mt-1 text-xs text-gray-500">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $peminjaman->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach

                <!-- Footer - Lihat Semua -->
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    <a wire:navigate href="{{ route('peminjaman.index') }}" @click="dropdownOpen = false"
                        class="block w-full text-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors py-2">
                        Lihat Semua Peminjaman →
                    </a>
                </div>
                @else
                <!-- Empty State -->
                <div class="px-4 py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengajuan baru</p>
                    <p class="mt-1 text-xs text-gray-500">Semua peminjaman telah diproses</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>