<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanPetaniKePengepul extends Model
{
    use HasFactory;

    protected $table = 'penjualan_petani_ke_pengepul';

    protected $fillable = [
        'petani_id',
        'pengepul_id',
        'pembukaan_penerimaan_id',
        'estimasi_tbs_kg',
        'is_pickup',
        'tanggal_pengantaran',
        'nomor_armada_pengantaran',
        'tanggal_penjemputan',
        'nomor_armada_penjemputan',
        'status',
    ];

    public function pengepul()
    {
        return $this->belongsTo(User::class, 'pengepul_id');
    }

    public function petani()
    {
        return $this->belongsTo(User::class, 'petani_id');
    }

    public function penerimaanPengepul()
    {
        return $this->belongsTo(PembukaanPenerimaanPengepul::class, 'pembukaan_penerimaan_id');
    }
}
