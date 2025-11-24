<div>
    <!-- Page Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Tambah Barang</h2>
            <p class="text-gray-600 mt-1">Form input data barang baru - Prodi: <span
                    class="font-semibold text-blue-600">{{ auth()->user()->prodi->nama_prodi }}</span></p>
        </div>
        <a href="{{ route('admin.barang.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md transition-all">
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

    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Data Barang -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Informasi Barang
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="kategori_id"
                        class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('kategori_id') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kondisi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kondisi <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="kondisi_id"
                        class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('kondisi_id') border-red-500 @enderror">
                        <option value="">-- Pilih Kondisi --</option>
                        @foreach($kondisis as $kondisi)
                        <option value="{{ $kondisi->id }}">{{ $kondisi->nama_kondisi }}</option>
                        @endforeach
                    </select>
                    @error('kondisi_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ruang -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ruang <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="ruang_id"
                        class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('ruang_id') border-red-500 @enderror">
                        <option value="">-- Pilih Ruang --</option>
                        @foreach($ruangs as $ruang)
                        <option value="{{ $ruang->id }}">{{ $ruang->nama_ruang }}</option>
                        @endforeach
                    </select>
                    @error('ruang_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Barang -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="nama_barang" type="text"
                        class="block w-full px-3 py-2.5 placeholder:text-gray-400 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('nama_barang') border-red-500 @enderror"
                        placeholder="Contoh: Laptop Dell Latitude">
                    @error('nama_barang')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kode Barang -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Barang
                    </label>
                    <input wire:model="kode_barang" type="text"
                        class="block w-full px-3 py-2.5 placeholder:text-gray-400 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('kode_barang') border-red-500 @enderror"
                        placeholder="Contoh: LPT-001">
                    @error('kode_barang')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Merk -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Merk
                    </label>
                    <input wire:model="merk" type="text"
                        class="block w-full px-3 py-2.5 placeholder:text-gray-400 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Contoh: Dell">
                </div>

                <!-- Jumlah Total -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah Total <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="jumlah_total" type="number" min="1"
                        class="block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('jumlah_total') border-red-500 @enderror">
                    @error('jumlah_total')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Satuan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Satuan <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="satuan" type="text"
                        class="block w-full px-3 py-2.5 placeholder:text-gray-400 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('satuan') border-red-500 @enderror"
                        placeholder="Contoh: Unit, Buah, Set">
                    @error('satuan')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea wire:model="deskripsi" rows="3"
                        class="block w-full px-3 py-2.5 placeholder:text-gray-400 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Deskripsi detail barang..."></textarea>
                </div>

                <!-- Foto -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Barang
                    </label>
                    <input wire:model="foto" type="file" accept="image/*"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG (Max. 2MB)</p>
                    @error('foto')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @if ($foto)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                        <img src="{{ $foto->temporaryUrl() }}"
                            class="h-40 w-40 object-cover rounded-lg border-2 border-gray-200 shadow-md">
                    </div>
                    @endif
                </div>
            </div>
        </div>


        <!-- Submit Button -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.barang.index') }}"
                class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-3 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-md transition-all transform hover:scale-105">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Barang
            </button>
        </div>
    </form>
</div>