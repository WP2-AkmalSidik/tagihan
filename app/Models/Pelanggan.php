<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';
    
    protected $fillable = [
        'nomor_meter',
        'nama_pelanggan',
        'alamat',
        'no_telepon',
        'tarif_id',
        'daya',
        'is_active',
    ];

    protected $casts = [
        'daya' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    // Business methods
    public function getTagihanBelumBayar()
    {
        return $this->tagihan()->where('status', 'belum_bayar')->get();
    }
}