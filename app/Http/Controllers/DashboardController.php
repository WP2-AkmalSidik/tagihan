<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Tarif;
use App\Models\Tagihan;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard dengan statistik
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Menyiapkan data statistik untuk dashboard
        $data = [
            'total_users' => User::count(), // Total user
            'total_pelanggan' => Pelanggan::count(), // Total pelanggan
            'total_tarif' => Tarif::count(), // Total tarif
            'total_tagihan' => Tagihan::count(), // Total tagihan
            'tagihan_belum_bayar' => Tagihan::where('status', 'belum_bayar')->count(), // Tagihan belum bayar
            'tagihan_sudah_bayar' => Tagihan::where('status', 'sudah_bayar')->count(), // Tagihan sudah bayar
        ];

        return view('dashboard', $data);
    }
}