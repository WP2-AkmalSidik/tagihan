<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $kode_tagihan
 * @property int $pelanggan_id
 * @property Carbon $periode_tagihan
 * @property float $meter_awal
 * @property float $meter_akhir
 * @property float $pemakaian
 * @property float $total_tagihan
 * @property string $status
 * @property Carbon|null $tanggal_bayar
 * @property-read Pelanggan $pelanggan
 */
class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihans';

    protected $fillable = [
        'kode_tagihan',
        'pelanggan_id',
        'periode_tagihan',
        'meter_awal',
        'meter_akhir',
        'pemakaian',
        'total_tagihan',
        'status',
        'tanggal_bayar',
    ];

    protected $casts = [
        'periode_tagihan' => 'date',
        'meter_awal' => 'decimal:2',
        'meter_akhir' => 'decimal:2',
        'pemakaian' => 'decimal:2',
        'total_tagihan' => 'decimal:2',
        'tanggal_bayar' => 'datetime',
    ];

    /**
     * Relasi ke model Pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    /**
     * Hitung jumlah pemakaian dari meter akhir - meter awal
     */
    public function hitungPemakaian(): void
    {
        $this->pemakaian = (float) ($this->meter_akhir - $this->meter_awal);
    }

    /**
     * Hitung total tagihan berdasarkan tarif pelanggan
     */
    public function hitungTotalTagihan(): void
    {
        $tarif = $this->pelanggan?->tarif?->harga_per_kwh ?? 0;
        $this->total_tagihan = (float) ($this->pemakaian * $tarif);
    }

    /**
     * Tandai tagihan sudah dibayar dan isi tanggal bayar
     */
    public function bayar(): void
    {
        $this->status = 'sudah_bayar';
        $this->tanggal_bayar = now();
        $this->save();
    }
}
