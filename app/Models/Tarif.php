<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tarifs';
    
    protected $fillable = [
        'kode_tarif',
        'nama_tarif',
        'harga_per_kwh',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'harga_per_kwh' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationship
    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class);
    }

    // Business logic method
    public function hitungTagihan(float $pemakaian): float
    {
        return $pemakaian * $this->harga_per_kwh;
    }
}