<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - Sistem Inventaris SMK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-linear-to-br from-gray-50 to-gray-100">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav x-data="{ mobileOpen: false }" class="bg-white shadow-lg border-b border-gray-200">
            <div class="max-w mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">

                    <!-- LEFT: LOGO -->
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-linear-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h1
                            class="text-xl font-bold bg-linear-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                            Inventaris SMK
                        </h1>
                    </div>

                    <!-- HAMBURGER (MOBILE ONLY) -->
                    <button @click="mobileOpen = !mobileOpen"
                        class="sm:hidden p-2 rounded-md text-gray-700 hover:bg-gray-100">
                        <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- DESKTOP MENU -->
                    <div class="hidden sm:flex flex-1 justify-center space-x-1">

                        <a wire:navigate href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>

                        @if(auth()->user()->hasRole(['admin']))
                        <a wire:navigate href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Users
                        </a>

                        <!-- MASTER DATA DROPDOWN -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Master Data
                                <svg class="w-4 h-4 ml-1 transition-transform" :class="open ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    <a wire:navigate href="{{ route('admin.prodi.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Prodi</a>
                                    <a wire:navigate href="{{ route('admin.kategori.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kategori</a>
                                    <a wire:navigate href="{{ route('admin.kondisi.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kondisi</a>
                                    <a wire:navigate href="{{ route('admin.ruang.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ruang</a>
                                </div>
                            </div>
                        </div>

                        <!-- Barang -->
                        <a wire:navigate href="{{ route('admin.barang.index') }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Barang
                        </a>
                        @endif

                        @if(auth()->user()->hasRole(['admin', 'kaprodi','anggota']))
                        <a wire:navigate href="{{ route('peminjaman.index') }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            Peminjaman
                        </a>

                        <a wire:navigate href="{{ route('permintaan.index') }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                            </svg>
                            Permintaan
                        </a>
                        @endif

                        @if(auth()->user()->hasRole(['admin', 'kaprodi']))
                        <!-- LAPORAN DROPDOWN -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Laporan
                                <svg class="w-4 h-4 ml-1 transition-transform" :class="open ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    <a wire:navigate href="{{ route('laporan.index') }}?type=barang"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Laporan
                                        Barang</a>
                                    <a wire:navigate href="{{ route('laporan.index') }}?type=peminjaman"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Laporan
                                        Peminjaman</a>
                                    <a wire:navigate href="{{ route('laporan.index') }}?type=permintaan"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Laporan
                                        Permintaan</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- USER INFO (DESKTOP) -->
                    <div class="hidden sm:flex items-center space-x-4">
                        @auth
                        @if(auth()->user()->prodi)
                        <span class="hidden md:block text-xs text-gray-500 px-3 py-1 bg-gray-100 rounded-full">
                            {{ auth()->user()->prodi->nama_prodi }}
                        </span>
                        @endif

                        @if(auth()->user()->hasRole(['admin', 'kaprodi']))
                        <livewire:components.notificationbell />
                        @endif

                        <span class="text-sm font-medium text-gray-700 me-3">{{ auth()->user()->name }}</span>

                        <span @class([ 'px-3 py-1 text-xs font-semibold rounded-full shadow-sm text-white'
                            , 'bg-red-500'=> auth()->user()->isAdmin(),
                            'bg-blue-600' => auth()->user()->isKaprodi(),
                            'bg-gradient-to-r from-green-500 to-green-600' =>
                            !auth()->user()->isAdmin() && !auth()->user()->isKaprodi(),
                            ])>
                            {{ ucfirst(auth()->user()->role) }}
                        </span>

                        <a wire:navigate href="{{ route('logout') }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-red-600 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </a>
                        @endauth
                    </div>

                </div>
            </div>

            <!-- MOBILE MENU DROPDOWN -->
            <div x-show="mobileOpen" x-transition class="sm:hidden border-t bg-white px-4 pb-4">

                <!-- MENU ITEMS MOBILE -->
                <div class="flex flex-col space-y-2 pt-3">

                    <a wire:navigate href="{{ route('dashboard') }}"
                        class="px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50">Dashboard</a>

                    @if(auth()->user()->hasRole(['admin']))
                    <a wire:navigate href="{{ route('admin.users.index') }}"
                        class="px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50">Users</a>

                    <!-- MASTER DATA -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full px-3 py-2 flex justify-between text-gray-700 hover:bg-gray-50">
                            Master Data
                            <span x-text="open ? '▲' : '▼'"></span>
                        </button>

                        <div x-show="open" class="ml-4 flex flex-col space-y-1">
                            <a wire:navigate href="{{ route('admin.prodi.index') }}"
                                class="py-1 text-gray-600">Prodi</a>
                            <a wire:navigate href="{{ route('admin.kategori.index') }}"
                                class="py-1 text-gray-600">Kategori</a>
                            <a wire:navigate href="{{ route('admin.kondisi.index') }}"
                                class="py-1 text-gray-600">Kondisi</a>
                            <a wire:navigate href="{{ route('admin.ruang.index') }}"
                                class="py-1 text-gray-600">Ruang</a>
                        </div>
                    </div>

                    <a wire:navigate href="{{ route('admin.barang.index') }}"
                        class="px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50">Barang</a>
                    @endif

                    @if(auth()->user()->hasRole(['admin','kaprodi','anggota']))
                    <a wire:navigate href="{{ route('peminjaman.index') }}"
                        class="px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50">Peminjaman</a>

                    <a wire:navigate href="{{ route('permintaan.index') }}"
                        class="px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50">Permintaan</a>
                    @endif

                    @if(auth()->user()->hasRole(['admin','kaprodi']))
                    <!-- LAPORAN -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full px-3 py-2 flex justify-between text-gray-700 hover:bg-gray-50">
                            Laporan
                            <span x-text="open ? '▲' : '▼'"></span>
                        </button>

                        <div x-show="open" class="ml-4 flex flex-col space-y-1">
                            <a wire:navigate href="{{ route('laporan.index') }}?type=barang"
                                class="py-1 text-gray-600">Laporan Barang</a>
                            <a wire:navigate href="{{ route('laporan.index') }}?type=peminjaman"
                                class="py-1 text-gray-600">Laporan Peminjaman</a>
                            <a wire:navigate href="{{ route('laporan.index') }}?type=permintaan"
                                class="py-1 text-gray-600">Laporan Permintaan</a>
                        </div>
                    </div>
                    @endif

                    <!-- USER INFO MOBILE -->
                    <div class="pt-3 border-t">
                        <div class="text-gray-700 font-medium">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</div>

                        <a wire:navigate href="{{ route('logout') }}"
                            class="block mt-2 px-3 py-2 rounded-md text-red-600 hover:bg-red-50">
                            Logout
                        </a>
                    </div>

                </div>
            </div>

        </nav>



        <!-- Page Content -->
        <main class="py-6 sm:py-8">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

    </div>

    @livewireScripts

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('redirectTo', (data) => {
                window.location.href = data.url;
            });
        });
    </script>

</body>

</html>