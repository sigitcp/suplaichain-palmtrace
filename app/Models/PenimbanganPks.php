<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenimbanganPks extends Model
{
    use HasFactory;

    protected $table = 'penimbangan_pks';

    protected $fillable = [
        'penawaran_pengepul_id',
        'tanggal_penerimaan',
        'bruto',
        'tara',
        'netto',
        'harga_beli_per_kg',
        'potongan',
        'total_transaksi',
        'catatan',
    ];

    // Relasi ke penawaran pengepul
    public function penawaran()
    {
        return $this->belongsTo(PenawaranPengepulKePks::class, 'penawaran_pengepul_id');
    }
}
