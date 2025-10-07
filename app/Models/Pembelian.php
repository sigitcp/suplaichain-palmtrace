<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'penjualan_id', 'pengepul_id', 'nomor_armada',
        'tanggal_jemput', 'jumlah_kg', 'harga_perkg', 'total_harga',
        'kualitas', 'status'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function pengepul()
    {
        return $this->belongsTo(User::class, 'pengepul_id');
    }
}
