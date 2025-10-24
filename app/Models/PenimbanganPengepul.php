<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenimbanganPengepul extends Model
{
    use HasFactory;

    protected $table = 'penimbangan_pengepul';

    protected $fillable = [
        'penawaran_tbs_id',
        'penjualan_id',        // diaktifkan untuk menautkan penjualan
        'tbs_baik_kg',
        'harga_baik_per_kg',
        'total_baik',
        'tbs_reject_kg',
        'harga_reject_per_kg',
        'total_reject',
        'tanggal_penimbangan',
        'catatan',
    ];

    public function penawaran()
    {
        return $this->belongsTo(PenawaranTbs::class, 'penawaran_tbs_id');
    }

    public function penjualan()
    {
        return $this->belongsTo(PenjualanPetaniKePengepul::class, 'penjualan_id');
    }
}
