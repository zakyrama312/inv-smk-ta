<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
        <p class="text-gray-600 mt-1">Selamat datang, <span
                class="font-semibold text-blue-600">{{ auth()->user()->name }}</span>!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @if(auth()->user()->isAdmin())
        <!-- Admin Stats -->

        <!-- Total Barang -->
        <div
            class="bg-linear-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Barang</p>
                    <p class="text-4xl font-bold">{{ $stats['total_barang'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-blue-100">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                        clip-rule="evenodd" />
                </svg>
                Semua kategori
            </div>
        </div>

        <!-- Total Users -->
        <div
            class="bg-linear-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Total Users</p>
                    <p class="text-4xl font-bold">{{ $stats['total_users'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-purple-100">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                Terdaftar di sistem
            </div>
        </div>

        <!-- Sedang Dipinjam -->
        <div
            class="bg-linear-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium mb-1">Sedang Dipinjam</p>
                    <p class="text-4xl font-bold">{{ $stats['total_peminjaman'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-orange-100">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                        clip-rule="evenodd" />
                </svg>
                Status aktif
            </div>
        </div>

        <!-- Permintaan Menunggu -->
        <div
            class="bg-linear-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-1">Permintaan Menunggu</p>
                    <p class="text-4xl font-bold">{{ $stats['permintaan_menunggu'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-red-100">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                Perlu review
            </div>
        </div>

        @elseif(auth()->user()->isKaprodi())
        <!-- Kaprodi Stats -->

        <!-- Total Barang Prodi -->
        <div
            class="bg-linear-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Barang Prodi</p>
                    <p class="text-4xl font-bold">{{ $stats['total_barang'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-blue-100">
                <span class="px-2 py-1 bg-white bg-opacity-20 rounded-full text-xs font-semibold">
                    {{ auth()->user()->prodi->nama_prodi }}
                </span>
            </div>
        </div>

        <!-- Sedang Dipinjam -->
        <div
            class="bg-linear-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium mb-1">Sedang Dipinjam</p>
                    <p class="text-4xl font-bold">{{ $stats['total_peminjaman'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-orange-100">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                        clip-rule="evenodd" />
                </svg>
                Status aktif
            </div>
        </div>

        <!-- Permintaan Menunggu -->
        <div
            class="bg-linear-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-1">Permintaan Menunggu</p>
                    <p class="text-4xl font-bold">{{ $stats['permintaan_menunggu'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-red-100">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                Perlu approval
            </div>
        </div>

        @else
        <!-- Anggota Stats -->

        <!-- Permintaan Saya -->
        <div
            class="bg-linear-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200 lg:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Permintaan Saya</p>
                    <p class="text-4xl font-bold">{{ $stats['permintaan_saya'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-green-100">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                        clip-rule="evenodd" />
                </svg>
                Total pengajuan
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div
            class="bg-linear-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200 lg:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Peminjaman Aktif</p>
                    <p class="text-4xl font-bold">{{ $stats['peminjaman_aktif'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-blue-100">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                        clip-rule="evenodd" />
                </svg>
                Belum dikembalikan
            </div>
        </div>

        @endif
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Quick Actions
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if(auth()->user()->isAdmin())
            <a href="{{ route('barang.index') }}"
                class="group flex items-center p-4 bg-linear-to-r from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all transform hover:scale-105 hover:shadow-md">
                <div class="bg-blue-500 rounded-lg p-3 mr-4 group-hover:bg-blue-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">Tambah Barang</p>
                    <p class="text-sm text-gray-600">Input barang baru</p>
                </div>
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="group flex items-center p-4 bg-linear-to-r from-purple-50 to-purple-100 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all transform hover:scale-105 hover:shadow-md">
                <div class="bg-purple-500 rounded-lg p-3 mr-4 group-hover:bg-purple-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 group-hover:text-purple-700 transition-colors">Kelola User</p>
                    <p class="text-sm text-gray-600">Manajemen pengguna</p>
                </div>
            </a>
            <a href="{{ route('laporan.index') }}"
                class="group flex items-center p-4 bg-linear-to-r from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all transform hover:scale-105 hover:shadow-md">
                <div class="bg-green-500 rounded-lg p-3 mr-4 group-hover:bg-green-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 group-hover:text-green-700 transition-colors">Lihat Laporan
                    </p>
                    <p class="text-sm text-gray-600">Laporan lengkap</p>
                </div>
            </a>
            @elseif(auth()->user()->isKaprodi())
            <a href="{{ route('permintaan.index') }}"
                class="group flex items-center p-4 bg-linear-to-r from-red-50 to-red-100 rounded-xl hover:from-red-100 hover:to-red-200 transition-all transform hover:scale-105 hover:shadow-md">
                <div class="bg-red-500 rounded-lg p-3 mr-4 group-hover:bg-red-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 group-hover:text-red-700 transition-colors">Review Permintaan
                    </p>
                    <p class="text-sm text-gray-600">Approve/tolak permintaan</p>
                </div>
            </a>
            <a href="{{ route('barang.index') }}"
                class="group flex items-center p-4 bg-linear-to-r from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all transform hover:scale-105 hover:shadow-md">
                <div class="bg-blue-500 rounded-lg p-3 mr-4 group-hover:bg-blue-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">Kelola Barang</p>
                    <p class="text-sm text-gray-600">Data barang prodi</p>
                </div>
            </a>
            <a href="{{ route('laporan.index') }}"
                class="group flex items-center p-4 bg-linear-to-r from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all transform hover:scale-105 hover:shadow-md">
                <div class="bg-green-500 rounded-lg p-3 mr-4 group-hover:bg-green-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 group-hover:text-green-700 transition-colors">Lihat Laporan
                    </p>
                    <p class="text-sm text-gray-600">Laporan prodi</p>
                </div>
            </a>
            @else
            <a href="{{ route('barang.index') }}"
                class="group flex items-center p-4 bg-linear-to-r from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all transform hover:scale-105 hover:shadow-md">
                <div class="bg-blue-500 rounded-lg p-3 mr-4 group-hover:bg-blue-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">Cari Barang</p>
                    <p class="text-sm text-gray-600">Lihat katalog barang</p>
                </div>
            </a>
            <a href="{{ route('permintaan.index') }}"
                class="group flex items-center p-4 bg-linear-to-r from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all transform hover:scale-105 hover:shadow-md">
                <div class="bg-green-500 rounded-lg p-3 mr-4 group-hover:bg-green-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 group-hover:text-green-700 transition-colors">Buat Permintaan
                    </p>
                    <p class="text-sm text-gray-600">Ajukan peminjaman</p>
                </div>
            </a>
            <a href="{{ route('peminjaman.index') }}"
                class="group flex items-center p-4 bg-linear-to-r from-orange-50 to-orange-100 rounded-xl hover:from-orange-100 hover:to-orange-200 transition-all transform hover:scale-105 hover:shadow-md">
                <div class="bg-orange-500 rounded-lg p-3 mr-4 group-hover:bg-orange-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 group-hover:text-orange-700 transition-colors">Lihat
                        Peminjaman
                    </p>
                    <p class="text-sm text-gray-600">Lihat riwayat peminjaman</p>
                </div>
            </a>
            @endif
        </div>
    </div>
</div>
