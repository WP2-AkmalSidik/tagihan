<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tagihan::with(['pelanggan', 'pelanggan.tarif']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('pelanggan', function($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('nomor_meter', 'like', "%{$search}%");
            })->orWhere('kode_tagihan', 'like', "%{$search}%");
        }

        $tagihan = $query->paginate(10);
        return view('tagihan.index', compact('tagihan'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::where('is_active', true)->get();
        return view('tagihan.create', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'periode_tagihan' => 'required|date',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric|gt:meter_awal',
        ]);

        $pelanggan = Pelanggan::with('tarif')->find($validated['pelanggan_id']);
        
        $tagihan = new Tagihan();
        $tagihan->kode_tagihan = 'TGH' . date('Ymd') . Str::random(5);
        $tagihan->pelanggan_id = $validated['pelanggan_id'];
        $tagihan->periode_tagihan = $validated['periode_tagihan'];
        $tagihan->meter_awal = $validated['meter_awal'];
        $tagihan->meter_akhir = $validated['meter_akhir'];
        $tagihan->hitungPemakaian();
        $tagihan->total_tagihan = $tagihan->pemakaian * $pelanggan->tarif->harga_per_kwh;
        $tagihan->save();

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dibuat!');
    }

    public function edit(Tagihan $tagihan)
    {
        $pelanggan = Pelanggan::where('is_active', true)->get();
        return view('tagihan.edit', compact('tagihan', 'pelanggan'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'periode_tagihan' => 'required|date',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric|gt:meter_awal',
        ]);

        $pelanggan = Pelanggan::with('tarif')->find($validated['pelanggan_id']);
        
        $tagihan->update([
            'pelanggan_id' => $validated['pelanggan_id'],
            'periode_tagihan' => $validated['periode_tagihan'],
            'meter_awal' => $validated['meter_awal'],
            'meter_akhir' => $validated['meter_akhir'],
        ]);

        $tagihan->hitungPemakaian();
        $tagihan->total_tagihan = $tagihan->pemakaian * $pelanggan->tarif->harga_per_kwh;
        $tagihan->save();

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diupdate!');
    }

    public function destroy(Tagihan $tagihan)
    {
        $tagihan->delete();
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus!');
    }

    public function bayar(Tagihan $tagihan)
    {
        $tagihan->bayar();
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dibayar!');
    }
}