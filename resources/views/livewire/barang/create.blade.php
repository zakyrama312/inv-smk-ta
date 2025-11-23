<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Barang</h1>
        <a href="{{ route('admin.barang.index') }}"
            class="px-4 py-2 bg-gray-700 text-white rounded-xl shadow hover:bg-gray-800 transition">
            Kembali
        </a>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('success'))
    <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-xl shadow-sm border border-green-200">
        {{ session('success') }}
    </div>
    @endif
    @if (session()->has('error'))
    <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-xl shadow-sm border border-red-200">
        {{ session('error') }}
    </div>
    @endif

    <form wire:submit.prevent="save"
        class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-8 rounded-2xl shadow-lg border border-gray-100">

        {{-- Prodi --}}
        <div>
            <label for="prodi_id" class="block font-medium mb-2 text-gray-700">Prodi</label>
            <select wire:model="prodi_id" id="prodi_id"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 p-2.5 bg-gray-50">
                <option value="">-- Pilih Prodi --</option>
                @foreach ($prodis as $prodi)
                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>
            @error('prodi_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        {{-- Kategori --}}
        <div>
            <label class="block font-medium mb-2 text-gray-700">Kategori</label>
            <select wire:model="kategori_id"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 p-2.5 bg-gray-50">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
            @error('kategori_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        {{-- Kondisi --}}
        <div>
            <label class="block font-medium mb-2 text-gray-700">Kondisi Barang</label>
            <select wire:model="kondisi_id"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 p-2.5 bg-gray-50">
                <option value="">-- Pilih Kondisi --</option>
                @foreach ($kondisis as $kondisi)
                <option value="{{ $kondisi->id }}">{{ $kondisi->nama_kondisi }}</option>
                @endforeach
            </select>
            @error('kondisi_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        {{-- Nama Barang --}}
        <div>
            <label class="block font-medium mb-2 text-gray-700">Nama Barang</label>
            <input wire:model="nama_barang" type="text" placeholder="Masukkan nama barang"
                class="w-full bg-gray-50 text-gray-800 border rounded-xl p-3 shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 @error('nama_barang') border-red-500 @enderror">
            @error('nama_barang') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        {{-- Kode Barang --}}
        <div>
            <label class="block font-medium mb-2 text-gray-700">Kode Barang</label>
            <input wire:model="kode_barang" type="text" placeholder="Contoh: BRG-001"
                class="w-full bg-gray-50 text-gray-800 border rounded-xl p-3 shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 @error('kode_barang') border-red-500 @enderror">
            @error('kode_barang') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        {{-- Merk --}}
        <div>
            <label class="block font-medium mb-2 text-gray-700">Merk</label>
            <input wire:model="merk" type="text" placeholder="Masukkan merk barang"
                class="w-full bg-gray-50 text-gray-800 border rounded-xl p-3 shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
        </div>

        {{-- Jumlah --}}
        <div>
            <label class="block font-medium mb-2 text-gray-700">Jumlah</label>
            <input wire:model="jumlah_total" type="number" min="1"
                class="w-full bg-gray-50 border rounded-xl p-3 text-gray-800 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('jumlah_total') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="md:col-span-2">
            <label class="block font-medium mb-2 text-gray-700">Deskripsi</label>
            <textarea wire:model="deskripsi" rows="3"
                class="w-full bg-gray-50 border rounded-xl p-3 text-gray-800 shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                placeholder="Masukkan deskripsi barang"></textarea>
        </div>

        {{-- Foto --}}
        <div class="md:col-span-2">
            <label class="block font-medium mb-2 text-gray-700">Foto Barang</label>
            <input wire:model="foto" type="file"
                class="w-full text-gray-700 p-2.5 bg-gray-50 border rounded-xl shadow-sm">

            @error('foto') <span class="text-sm text-red-500">{{ $message }}</span> @enderror

            @if ($foto)
            <img src="{{ $foto->temporaryUrl() }}"
                class="h-32 mt-4 rounded-xl shadow border border-gray-200 object-cover">
            @endif
        </div>

        {{-- Submit --}}
        <div class="md:col-span-2 flex justify-end">
            <button type="submit"
                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 transition">
                Simpan Barang
            </button>
        </div>
    </form>
</div>