<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Index as Dashboard;
use App\Livewire\Kategori\Index;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
});

// Authenticated Routes - Single Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Admin Only Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', function () {
            return view('livewire.users.index');
        })->name('users.index');
        Route::get('/prodi', function () {
            return view('livewire.prodi.index');
        })->name('prodi.index');


        Route::get('/kategori', Index::class)->name('kategori.index');

        Route::get('/kondisi', function () {
            return view('livewire.kondisi.index');
        })->name('kondisi.index');
        Route::get('/ruang', function () {
            return view('livewire.ruang.index');
        })->name('ruang.index');
    });

    // Barang Routes (accessible by all authenticated users)
    Route::get('/barang', function () {
        return view('livewire.barang.index');
    })->name('barang.index');

    // Permintaan Routes (accessible by kaprodi & anggota)
    Route::middleware(['role:kaprodi,anggota'])->group(function () {
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
