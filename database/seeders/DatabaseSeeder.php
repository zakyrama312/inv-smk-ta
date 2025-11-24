<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Kategori;
use App\Models\Kondisi;
use App\Models\Ruang;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Prodi
        $tkj = Prodi::create([
            'nama_prodi' => 'Teknik Komputer dan Jaringan',
            'slug' => 'tkj',
        ]);

        $rpl = Prodi::create([
            'nama_prodi' => 'Rekayasa Perangkat Lunak',
            'slug' => 'rpl',
        ]);

        $mm = Prodi::create([
            'nama_prodi' => 'Multimedia',
            'slug' => 'multimedia',
        ]);

        // Create Kategori (per prodi)
        $kategorisTKJ = [
            ['prodi_id' => $tkj->id, 'nama_kategori' => 'Elektronik', 'slug' => 'elektronik-tkj'],
            ['prodi_id' => $tkj->id, 'nama_kategori' => 'Komputer', 'slug' => 'komputer-tkj'],
            ['prodi_id' => $tkj->id, 'nama_kategori' => 'Jaringan', 'slug' => 'jaringan-tkj'],
        ];

        $kategorisRPL = [
            ['prodi_id' => $rpl->id, 'nama_kategori' => 'Komputer', 'slug' => 'komputer-rpl'],
            ['prodi_id' => $rpl->id, 'nama_kategori' => 'Software', 'slug' => 'software-rpl'],
        ];

        $kategorisMM = [
            ['prodi_id' => $mm->id, 'nama_kategori' => 'Audio Visual', 'slug' => 'audio-visual-mm'],
            ['prodi_id' => $mm->id, 'nama_kategori' => 'Kamera', 'slug' => 'kamera-mm'],
        ];

        foreach (array_merge($kategorisTKJ, $kategorisRPL, $kategorisMM) as $kategori) {
            Kategori::create($kategori);
        }

        // Create Kondisi (per prodi)
        $kondisisTKJ = [
            ['prodi_id' => $tkj->id, 'nama_kondisi' => 'Baik'],
            ['prodi_id' => $tkj->id, 'nama_kondisi' => 'Rusak Ringan'],
            ['prodi_id' => $tkj->id, 'nama_kondisi' => 'Rusak Berat'],
        ];

        $kondisisRPL = [
            ['prodi_id' => $rpl->id, 'nama_kondisi' => 'Baik'],
            ['prodi_id' => $rpl->id, 'nama_kondisi' => 'Rusak Ringan'],
            ['prodi_id' => $rpl->id, 'nama_kondisi' => 'Rusak Berat'],
        ];

        $kondisisMM = [
            ['prodi_id' => $mm->id, 'nama_kondisi' => 'Baik'],
            ['prodi_id' => $mm->id, 'nama_kondisi' => 'Rusak Ringan'],
            ['prodi_id' => $mm->id, 'nama_kondisi' => 'Rusak Berat'],
        ];

        foreach (array_merge($kondisisTKJ, $kondisisRPL, $kondisisMM) as $kondisi) {
            Kondisi::create($kondisi);
        }

        // Create Ruang
        $ruangs = [
            ['prodi_id' => $tkj->id, 'nama_ruang' => 'Lab Jaringan 1', 'slug' => 'lab-jaringan-1'],
            ['prodi_id' => $tkj->id, 'nama_ruang' => 'Lab Hardware', 'slug' => 'lab-hardware'],
            ['prodi_id' => $rpl->id, 'nama_ruang' => 'Lab Programming 1', 'slug' => 'lab-programming-1'],
            ['prodi_id' => $rpl->id, 'nama_ruang' => 'Lab Programming 2', 'slug' => 'lab-programming-2'],
            ['prodi_id' => $mm->id, 'nama_ruang' => 'Lab Multimedia', 'slug' => 'lab-multimedia'],
            ['prodi_id' => $mm->id, 'nama_ruang' => 'Studio Fotografi', 'slug' => 'studio-fotografi'],
        ];

        foreach ($ruangs as $ruang) {
            Ruang::create($ruang);
        }

        // Create Users
        // Admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => 'password',
            'role' => 'admin',
            'prodi_id' => 2,
        ]);

        // Kaprodi TKJ
        User::create([
            'name' => 'Kaprodi TKJ',
            'username' => 'kaprodi_tkj',
            'password' => 'password',
            'role' => 'kaprodi',
            'prodi_id' => $tkj->id,
        ]);

        // Kaprodi RPL
        User::create([
            'name' => 'Kaprodi RPL',
            'username' => 'kaprodi_rpl',
            'password' => 'password',
            'role' => 'kaprodi',
            'prodi_id' => $rpl->id,
        ]);

        // Anggota TKJ
        User::create([
            'name' => 'Siswa TKJ',
            'username' => 'siswa_tkj',
            'password' => 'password',
            'role' => 'anggota',
            'prodi_id' => $tkj->id,
        ]);

        // Anggota RPL
        User::create([
            'name' => 'Siswa RPL',
            'username' => 'siswa_rpl',
            'password' => 'password',
            'role' => 'anggota',
            'prodi_id' => $rpl->id,
        ]);

        $this->command->info('Database seeding completed successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin / password');
        $this->command->info('Kaprodi TKJ: kaprodi_tkj / password');
        $this->command->info('Kaprodi RPL: kaprodi_rpl / password');
        $this->command->info('Siswa TKJ: siswa_tkj / password');
        $this->command->info('Siswa RPL: siswa_rpl / password');
    }
}
