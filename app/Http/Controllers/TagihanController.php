<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    /**
     * Menampilkan daftar tagihan dengan pencarian
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Query dasar dengan eager loading relasi
        $query = Tagihan::with(['pelanggan', 'pelanggan.tarif']);

        // Jika ada parameter search, tambahkan kondisi pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('pelanggan', function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                    ->orWhere('nomor_meter', 'like', "%{$search}%");
            })->orWhere('kode_tagihan', 'like', "%{$search}%");
        }

        // Paginasi hasil query (10 item per halaman)
        $tagihan = $query->latest()->paginate(10);
        return view('tagihan.index', compact('tagihan'));
    }

    /**
     * Mengambil data pelanggan untuk form create (API)
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $pelanggan = Pelanggan::with('tarif')->get();
        return response()->json($pelanggan);
    }

    /**
     * Menyimpan tagihan baru
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi database
        try {
            // Validasi input
            $request->validate([
                'pelanggan_id' => 'required|exists:pelanggans,id',
                'periode_tagihan' => 'required|date',
                'meter_awal' => 'required|numeric|min:0',
                'meter_akhir' => 'required|numeric|min:0|gt:meter_awal',
            ]);

            // Hitung pemakaian dan total tagihan
            $pelanggan = Pelanggan::with('tarif')->find($request->pelanggan_id);
            $pemakaian = $request->meter_akhir - $request->meter_awal;
            $total_tagihan = $pemakaian * $pelanggan->tarif->harga_per_kwh;

            // Buat tagihan baru
            Tagihan::create([
                'kode_tagihan' => 'TGH-' . Str::upper(Str::random(10)), // Generate kode unik
                'pelanggan_id' => $request->pelanggan_id,
                'periode_tagihan' => $request->periode_tagihan,
                'meter_awal' => $request->meter_awal,
                'meter_akhir' => $request->meter_akhir,
                'pemakaian' => $pemakaian,
                'total_tagihan' => $total_tagihan,
                'status' => 'belum_bayar' // Status default
            ]);

            DB::commit(); // Commit transaksi jika sukses
            return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika terjadi error
            return redirect()->route('tagihan.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail tagihan (API)
     * @param Tagihan $tagihan
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Tagihan $tagihan)
    {
        return response()->json($tagihan->load(['pelanggan', 'pelanggan.tarif']));
    }

    /**
     * Mengambil data tagihan untuk edit (API)
     * @param Tagihan $tagihan
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Tagihan $tagihan)
    {
        return response()->json($tagihan);
    }

    /**
     * Memperbarui data tagihan
     * @param Request $request
     * @param Tagihan $tagihan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tagihan $tagihan)
    {
        DB::beginTransaction();
        try {
            // Validasi input
            $request->validate([
                'pelanggan_id' => 'required|exists:pelanggans,id',
                'periode_tagihan' => 'required|date',
                'meter_awal' => 'required|numeric|min:0',
                'meter_akhir' => 'required|numeric|min:0|gt:meter_awal',
            ]);

            // Hitung ulang pemakaian dan total tagihan
            $pelanggan = Pelanggan::with('tarif')->find($request->pelanggan_id);
            $pemakaian = $request->meter_akhir - $request->meter_awal;
            $total_tagihan = $pemakaian * $pelanggan->tarif->harga_per_kwh;

            // Update data tagihan
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

    /**
     * Menghapus tagihan
     * @param Tagihan $tagihan
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Memproses pembayaran tagihan
     * @param Tagihan $tagihan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bayar(Tagihan $tagihan)
    {
        DB::beginTransaction();
        try {
            $tagihan->update([
                'status' => 'sudah_bayar',
                'tanggal_bayar' => now() // Set tanggal bayar ke waktu sekarang
            ]);

            DB::commit();
            return redirect()->route('tagihan.index')->with('success', 'Pembayaran berhasil diproses');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tagihan.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}