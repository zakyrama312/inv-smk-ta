<div>
    <!-- Page Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Tambah Peminjaman</h2>
            <p class="text-gray-600 mt-1">Buat pengajuan peminjaman barang baru</p>
        </div>
        <a wire:navigate href="{{ route('peminjaman.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md transition-all transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Alert Messages -->
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

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <form wire:submit.prevent="save">
            <div class="p-6 space-y-6">

                <!-- Data Peminjam Section -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Data Peminjam
                    </h3>

                    <!-- Row 1: Nama Peminjam & Kelas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="nama_peminjam" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Peminjam <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="nama_peminjam" id="nama_peminjam"
                                @class([ 'block w-full placeholder-gray-400 px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all'
                                , 'border-red-500'=> $errors->has('nama_peminjam'),
                            'border-gray-300' => !$errors->has('nama_peminjam'),
                            ]) placeholder="Masukkan nama lengkap">
                            @error('nama_peminjam')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kelas" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kelas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="kelas" id="kelas"
                                @class([ 'block w-full placeholder-gray-400 px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all'
                                , 'border-red-500'=> $errors->has('kelas'),
                            'border-gray-300' => !$errors->has('kelas'),
                            ])
                            placeholder="Contoh: 12 RPL 1">
                            @error('kelas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nomor Telepon (WhatsApp) -->
                    <div>
                        <label for="no_telepon" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Telepon (WhatsApp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                            </div>
                            <input type="text" wire:model="no_telepon" id="no_telepon"
                                @class([ 'block w-full placeholder-gray-400 pl-10 pr-4 py-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all'
                                , 'border border-red-500'=> $errors->has('no_telepon'),
                            'border border-gray-300' => !$errors->has('no_telepon'),
                            ])
                            placeholder="Contoh: 081234567890">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Format: 08xxxxxxxxxx (untuk WhatsApp)</p>
                        @error('no_telepon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Data Peminjaman Section -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Data Peminjaman
                    </h3>

                    <!-- Row 2: Barang & Jumlah -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="barang_search" class="block text-sm font-semibold text-gray-700 mb-2">
                                Pilih Barang <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <!-- Input dengan nilai yang sudah dipilih -->
                                <div class="relative">
                                    <input type="text" wire:model.live.debounce.300ms="searchBarang"
                                        placeholder="Ketik untuk mencari barang..."
                                        class="block w-full px-4 py-2.5 pr-10 border @error('barang_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        @if($selectedBarang) readonly @endif>

                                    <!-- Icon Search / Clear -->
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        @if($selectedBarang)
                                        <!-- Tombol Clear -->
                                        <button type="button" wire:click="clearBarang"
                                            class="text-gray-400 hover:text-gray-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        @else
                                        <!-- Icon Search -->
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        @endif
                                    </div>
                                </div>

                                <!-- Dropdown Results -->
                                @if($searchBarang && !$selectedBarang && count($filteredBarangs) > 0)
                                <div
                                    class="absolute z-50 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-xl max-h-80 overflow-hidden">
                                    <div class="overflow-y-auto max-h-80">
                                        @foreach($filteredBarangs as $barang)
                                        <div wire:click="selectBarang({{ $barang->id }})"
                                            class="px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors border-b border-gray-100 last:border-b-0">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-gray-900">
                                                        {{ $barang->nama_barang }}</p>
                                                    <div class="flex items-center mt-1 space-x-2">
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                            </svg>
                                                            {{ $barang->ruang->nama_ruang }}
                                                        </span>
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                            </svg>
                                                            Stok: {{ $barang->jumlah_tersedia }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @elseif($searchBarang && !$selectedBarang && count($filteredBarangs) === 0)
                                <!-- No Results -->
                                <div
                                    class="absolute z-50 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-xl">
                                    <div class="px-4 py-6 text-center text-sm text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p>Barang tidak ditemukan</p>
                                    </div>
                                </div>
                                @endif

                                <!-- Selected Item Display -->
                                @if($selectedBarang)
                                <div class="mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900 mb-2">
                                                {{ $selectedBarang->nama_barang }}</p>
                                            <div class="flex items-center space-x-2">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    {{ $selectedBarang->ruang->nama_ruang }}
                                                </span>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                    Stok: {{ $selectedBarang->jumlah_tersedia }}
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button" wire:click="clearBarang"
                                            class="ml-4 text-gray-400 hover:text-red-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @error('barang_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jumlah_pinjam" class="block text-sm font-semibold text-gray-700 mb-2">
                                Jumlah Pinjam <span class="text-red-500">*</span>
                            </label>
                            <input type="number" wire:model="jumlah_pinjam" id="jumlah_pinjam" min="1"
                                max="{{ $selectedBarang->jumlah_tersedia ?? 1 }}"
                                @class([ 'block w-full px-4 py-2.5 placeholder-gray-400 border rounded-lg focus:ring-2 focus:ring-blue-500 transition-all'
                                , $errors->has('jumlah_pinjam') ? 'border-red-500' : 'border-gray-300'
                            ])
                            placeholder="0" @if(!$selectedBarang) disabled @endif>
                            @if($selectedBarang)
                            <p class="mt-1 text-xs text-gray-500">
                                Stok tersedia: <span class="font-semibold">{{ $selectedBarang->jumlah_tersedia }}</span>
                            </p>
                            @else
                            <p class="mt-1 text-xs text-gray-500">Pilih barang terlebih dahulu</p>
                            @endif
                            @error('jumlah_pinjam')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 3: Tanggal Pinjam & Tanggal Kembali -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tanggal_pinjam" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Pinjam <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" wire:model="tanggal_pinjam" id="tanggal_pinjam"
                                    min="{{ now()->format('Y-m-d') }}"
                                    @class([ 'block w-full pl-10 pr-4 py-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all'
                                    , $errors->has('tanggal_pinjam') ? 'border-red-500' : 'border-gray-300'
                                ])>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Default: Hari ini ({{ now()->format('d M Y') }})</p>
                            @error('tanggal_pinjam')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_kembali" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Kembali (Estimasi) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" wire:model="tanggal_kembali" id="tanggal_kembali"
                                    min="{{ $tanggal_pinjam ?? now()->format('Y-m-d') }}"
                                    @class([ 'block w-full pl-10 pr-4 py-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all'
                                    , $errors->has('tanggal_kembali') ? 'border-red-500' : 'border-gray-300'
                                ])>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Harus setelah tanggal pinjam</p>
                            @error('tanggal_kembali')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Keperluan -->
                <div>
                    <label for="keperluan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Keperluan Peminjaman <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="keperluan" id="keperluan" rows="4"
                        class="block w-full placeholder-gray-400 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Jelaskan keperluan peminjaman"></textarea>
                    @error('keperluan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-400 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="text-sm text-blue-700">
                            <p class="font-semibold mb-1">Informasi Penting:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Pengajuan akan berstatus "Pending" menunggu persetujuan admin</li>
                                <li>Pastikan nomor WhatsApp aktif untuk komunikasi</li>
                                <li>Barang harus dikembalikan dalam kondisi baik</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Actions -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('peminjaman.index') }}"
                    class="inline-flex items-center px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center px-6 py-2.5 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-md transition-all transform hover:scale-105"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save" class="flex">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Ajukan Peminjaman
                    </span>
                    <span wire:loading wire:target="save">
                        <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
