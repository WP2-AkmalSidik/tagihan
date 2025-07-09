<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Tarif;
use App\Models\Tagihan;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_users' => User::count(),
            'total_pelanggan' => Pelanggan::count(),
            'total_tarif' => Tarif::count(),
            'total_tagihan' => Tagihan::count(),
            'tagihan_belum_bayar' => Tagihan::where('status', 'belum_bayar')->count(),
            'tagihan_sudah_bayar' => Tagihan::where('status', 'sudah_bayar')->count(),
        ];

        return view('dashboard', $data);
    }
}