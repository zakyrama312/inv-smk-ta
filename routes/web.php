<?php

use App\Livewire\Users\Index as UsersIndex;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Livewire\Barang\Create;
use App\Livewire\Barang\Index as BarangIndex;
use App\Livewire\Dashboard\Index as Dashboard;
use App\Livewire\Kategori\Index;
use App\Livewire\Kondisi\Index as KondisiIndex;
use App\Livewire\Prodi\Index as ProdiIndex;
use App\Livewire\Ruang\Index as RuangIndex;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
});

// Authenticated Routes - Single Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Admin Only Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // master data management
        Route::get('/users', UsersIndex::class)->name('users.index');
        Route::get('/prodi', ProdiIndex::class)->name('prodi.index');
        Route::get('/kategori', Index::class)->name('kategori.index');
        Route::get('/kondisi', KondisiIndex::class)->name('kondisi.index');
        Route::get('/ruang', RuangIndex::class)->name('ruang.index');
        // data barang
        Route::get('/barang', BarangIndex::class)->name('barang.index');
        Route::get('/tambah-barang', Create::class)->name('barang.create');
    });



    // Permintaan Routes (accessible by kaprodi & anggota)
    Route::middleware(['role:admin,kaprodi,anggota'])->group(function () {
        Route::get('/permintaan', function () {
            return view('livewire.permintaan.index');
        })->name('permintaan.index');
    });

    // Peminjaman Routes (accessible by all authenticated users)
    Route::get('/peminjaman', function () {
        return view('livewire.peminjaman.index');
    })->name('peminjaman.index');

    // Laporan Routes (admin & kaprodi only)
    Route::middleware(['role:admin,kaprodi'])->group(function () {
        Route::get('/laporan', function () {
            return view('livewire.laporan.index');
        })->name('laporan.index');
    });
});

// Logout
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login')->with('success', 'Berhasil logout.');
})->middleware('auth')->name('logout');
