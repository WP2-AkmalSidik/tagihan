<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tagihan::with(['pelanggan', 'pelanggan.tarif']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('pelanggan', function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                    ->orWhere('nomor_meter', 'like', "%{$search}%");
            })->orWhere('kode_tagihan', 'like', "%{$search}%");
        }

        $tagihan = $query->latest()->paginate(10);
        return view('tagihan.index', compact('tagihan'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::with('tarif')->get();
        return response()->json($pelanggan);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'pelanggan_id' => 'required|exists:pelanggans,id',
                'periode_tagihan' => 'required|date',
                'meter_awal' => 'required|numeric|min:0',
                'meter_akhir' => 'required|numeric|min:0|gt:meter_awal',
            ]);

            $pelanggan = Pelanggan::with('tarif')->find($request->pelanggan_id);
            $pemakaian = $request->meter_akhir - $request->meter_awal;
            $total_tagihan = $pemakaian * $pelanggan->tarif->harga_per_kwh;

            Tagihan::create([
                'kode_tagihan' => 'TGH-' . Str::upper(Str::random(10)),
                'pelanggan_id' => $request->pelanggan_id,
                'periode_tagihan' => $request->periode_tagihan,
                'meter_awal' => $request->meter_awal,
                'meter_akhir' => $request->meter_akhir,
                'pemakaian' => $pemakaian,
                'total_tagihan' => $total_tagihan,
                'status' => 'belum_bayar'
            ]);

            DB::commit();
            return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tagihan.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Tagihan $tagihan)
    {
        return response()->json($tagihan->load(['pelanggan', 'pelanggan.tarif']));
    }

    public function edit(Tagihan $tagihan)
    {
        return response()->json($tagihan);
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'pelanggan_id' => 'required|exists:pelanggans,id',
                'periode_tagihan' => 'required|date',
                'meter_awal' => 'required|numeric|min:0',
                'meter_akhir' => 'required|numeric|min:0|gt:meter_awal',
            ]);

            $pelanggan = Pelanggan::with('tarif')->find($request->pelanggan_id);
            $pemakaian = $request->meter_akhir - $request->meter_awal;
            $total_tagihan = $pemakaian * $pelanggan->tarif->harga_per_kwh;

            $tagihan->update([
                'pelanggan_id' => $request->pelanggan_id,
                'periode_tagihan' => $request->periode_tagihan,
                'meter_awal' => $request->meter_awal,
                'meter_akhir' => $request->meter_akhir,
                'pemakaian' => $pemakaian,
                'total_tagihan' => $total_tagihan,
            ]);

            DB::commit();
            return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tagihan.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Tagihan $tagihan)
    {
        DB::beginTransaction();
        try {
            $tagihan->delete();
            DB::commit();
            return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tagihan.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function bayar(Tagihan $tagihan)
    {
        DB::beginTransaction();
        try {
            $tagihan->update([
                'status' => 'sudah_bayar',
                'tanggal_bayar' => now()
            ]);

            DB::commit();
            return redirect()->route('tagihan.index')->with('success', 'Pembayaran berhasil diproses');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tagihan.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}