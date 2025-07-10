<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Tarif;
use App\Models\Pelanggan;
use App\Models\Tagihan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@listrik.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buat 10 akun user biasa
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@listrik.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // Buat 10 data tarif listrik
        $tarifs = [
            ['R1', 'Rumah Tangga 450VA', 415, 'Tarif untuk rumah tangga dengan daya 450VA'],
            ['R2', 'Rumah Tangga 900VA', 1444.70, 'Tarif untuk rumah tangga dengan daya 900VA'],
            ['R3', 'Rumah Tangga 1300VA', 1444.70, 'Tarif untuk rumah tangga dengan daya 1300VA'],
            ['R4', 'Rumah Tangga 2200VA', 1444.70, 'Tarif untuk rumah tangga dengan daya 2200VA'],
            ['B1', 'Bisnis 450VA', 605, 'Tarif untuk bisnis kecil dengan daya 450VA'],
            ['B2', 'Bisnis 900VA', 1444.70, 'Tarif untuk bisnis dengan daya 900VA'],
            ['B3', 'Bisnis 1300VA', 1444.70, 'Tarif untuk bisnis dengan daya 1300VA'],
            ['I1', 'Industri 2200VA', 1444.70, 'Tarif untuk industri kecil dengan daya 2200VA'],
            ['I2', 'Industri 3500VA', 1444.70, 'Tarif untuk industri dengan daya 3500VA'],
            ['I3', 'Industri 5500VA', 1444.70, 'Tarif untuk industri besar dengan daya 5500VA'],
        ];

        foreach ($tarifs as $tarif) {
            Tarif::create([
                'kode_tarif' => $tarif[0],
                'nama_tarif' => $tarif[1],
                'harga_per_kwh' => $tarif[2],
                'deskripsi' => $tarif[3],
            ]);
        }

        // Buat 10 data pelanggan
        $faker = \Faker\Factory::create('id_ID');
        $tarifIds = Tarif::pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {
            Pelanggan::create([
                'nomor_meter' => str_pad($i, 12, '0', STR_PAD_LEFT),
                'nama_pelanggan' => $faker->name,
                'alamat' => $faker->address,
                'no_telepon' => $this->generatePhoneNumber($faker), // Gunakan fungsi khusus
                'tarif_id' => $faker->randomElement($tarifIds),
                'daya' => $faker->randomElement([450, 900, 1300, 2200, 3500, 5500]),
            ]);
        }

        // Buat 10 data tagihan untuk setiap pelanggan
        $pelangganIds = Pelanggan::pluck('id')->toArray();
        $currentDate = Carbon::now();
        
        foreach ($pelangganIds as $pelangganId) {
            $pelanggan = Pelanggan::with('tarif')->find($pelangganId);
            
            for ($i = 0; $i < 1; $i++) {
                $periode = $currentDate->copy()->subMonths($i);
                $meterAwal = $faker->numberBetween(1000, 5000);
                $meterAkhir = $meterAwal + $faker->numberBetween(100, 500);
                $pemakaian = $meterAkhir - $meterAwal;
                $totalTagihan = $pemakaian * $pelanggan->tarif->harga_per_kwh;
                
                $status = $faker->randomElement(['belum_bayar', 'sudah_bayar']);
                $tanggalBayar = $status === 'sudah_bayar' ? $periode->copy()->addDays($faker->numberBetween(1, 15)) : null;
                
                Tagihan::create([
                    'kode_tagihan' => 'TGH-' . Str::upper(Str::random(10)),
                    'pelanggan_id' => $pelangganId,
                    'periode_tagihan' => $periode->format('Y-m-d'),
                    'meter_awal' => $meterAwal,
                    'meter_akhir' => $meterAkhir,
                    'pemakaian' => $pemakaian,
                    'total_tagihan' => $totalTagihan,
                    'status' => $status,
                    'tanggal_bayar' => $tanggalBayar,
                ]);
            }
        }
    }

    // Fungsi untuk generate nomor telepon yang lebih pendek
    protected function generatePhoneNumber($faker)
    {
        // Format: 0812-3456-7890 (total 13 karakter)
        return substr(str_replace(['+62', '(', ')', ' ', '-'], '', $faker->phoneNumber), 0, 13);
    }
}