<div>
    <!-- Page Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Edit Barang</h2>
            <p class="text-gray-600 mt-1">Perbarui data barang inventaris</p>
        </div>
        <a href="{{ route('admin.barang.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md transition-all transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
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

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <form wire:submit.prevent="update">
            <div class="p-6 space-y-6">

                <!-- Row 1: Nama Barang & Merk -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_barang" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="nama_barang" id="nama_barang"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('nama_barang') border-red-500 @enderror"
                            placeholder="Masukkan nama barang">
                        @error('nama_barang')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="merk" class="block text-sm font-semibold text-gray-700 mb-2">
                            Merk
                        </label>
                        <input type="text" wire:model="merk" id="merk"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="Masukkan merk barang">
                        @error('merk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Row 2: Kategori & Kondisi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kategori_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="kategori_id" id="kategori_id"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('kategori_id') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kondisi_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kondisi <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="kondisi_id" id="kondisi_id"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('kondisi_id') border-red-500 @enderror">
                            <option value="">Pilih Kondisi</option>
                            @foreach($kondisis as $kondisi)
                            <option value="{{ $kondisi->id }}">{{ $kondisi->nama_kondisi }}</option>
                            @endforeach
                        </select>
                        @error('kondisi_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Row 3: Jumlah Total & Jumlah Tersedia -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="jumlah_total" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jumlah Total <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model="jumlah_total" id="jumlah_total" min="1"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('jumlah_total') border-red-500 @enderror"
                            placeholder="0">
                        @error('jumlah_total')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah_tersedia" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jumlah Tersedia <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model="jumlah_tersedia" id="jumlah_tersedia" min="0"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('jumlah_tersedia') border-red-500 @enderror"
                            placeholder="0">
                        @error('jumlah_tersedia')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Row 4: Ruang & Prodi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="ruang_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Ruang <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="ruang_id" id="ruang_id"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('ruang_id') border-red-500 @enderror">
                            <option value="">Pilih Ruang</option>
                            @foreach($ruangs as $ruang)
                            <option value="{{ $ruang->id }}">{{ $ruang->nama_ruang }}</option>
                            @endforeach
                        </select>
                        @error('ruang_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prodi_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Program Studi <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="prodi_id" id="prodi_id"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('prodi_id') border-red-500 @enderror">
                            <option value="">Pilih Prodi</option>
                            @foreach($prodis as $prodi)
                            <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Foto Thumbnail -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Foto Barang
                    </label>

                    <!-- Existing Photo Preview -->
                    @if($existing_foto)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/' . $existing_foto) }}" alt="Current photo"
                                class="h-32 w-32 object-cover rounded-lg border-2 border-gray-300">
                            <button type="button" wire:click="removePhoto"
                                wire:confirm="Apakah Anda yakin ingin menghapus foto ini?"
                                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Photo -->
                    <input type="file" wire:model="foto_thumbnail" id="foto_thumbnail" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, maksimal 2MB</p>

                    @error('foto_thumbnail')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Preview New Photo -->
                    @if($foto_thumbnail && !$errors->has('foto_thumbnail'))
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 mb-2">Preview foto baru:</p>
                        <img src="{{ $foto_thumbnail->temporaryUrl() }}" alt="Preview"
                            class="h-32 w-32 object-cover rounded-lg border-2 border-blue-500">
                    </div>
                    @endif

                    <div wire:loading wire:target="foto_thumbnail" class="mt-2">
                        <p class="text-sm text-blue-600">Mengupload foto...</p>
                    </div>
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Keterangan
                    </label>
                    <textarea wire:model="keterangan" id="keterangan" rows="4"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Masukkan keterangan tambahan (opsional)"></textarea>
                    @error('keterangan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Form Actions -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('admin.barang.index') }}"
                    class="inline-flex items-center px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-all transform hover:scale-105"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="update" class="flex">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui
                    </span>
                    <span wire:loading wire:target="update">
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