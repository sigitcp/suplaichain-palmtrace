<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembukaanPenerimaanPengepul extends Model
{
    use HasFactory;

    protected $table = 'pembukaan_penerimaan_pengepul';

    protected $fillable = [
        'pengepul_user_id',
        'harga_per_kg',
        'kapasitas_kg',
        'terms',
        'status',
    ];

    public function pengepul()
    {
        return $this->belongsTo(User::class, 'pengepul_user_id');
    }

    public function penjualanDariPetani()
    {
        return $this->hasMany(PenjualanPetaniKePengepul::class, 'pembukaan_penerimaan_id');
    }
}
