<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tarif;
use App\Models\Pelanggan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun admin (pastikan tabel 'users' memiliki kolom 'role')
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@listrik.com',
            'password' => Hash::make('password'),
            'role' => 'admin', // Pastikan kolom ini ada di tabel users
        ]);

        // Buat data tarif dasar listrik
        $tarif = Tarif::create([
            'kode_tarif' => 'R1',
            'nama_tarif' => 'Rumah Tangga 900VA',
            'harga_per_kwh' => 1444.70,
            'deskripsi' => 'Tarif untuk rumah tangga dengan daya 900VA',
        ]);

        // Buat data pelanggan contoh
        Pelanggan::create([
            'nomor_meter'    => '001234567890',
            'nama_pelanggan' => 'Budi Santoso',
            'alamat'         => 'Jl. Merdeka No. 123, Jakarta',
            'no_telepon'     => '08123456789',
            'tarif_id'       => $tarif->id,
            'daya'           => 900,
        ]);
    }
}
