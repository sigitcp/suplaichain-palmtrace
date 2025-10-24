<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranTbs extends Model
{
    use HasFactory;

    protected $fillable = [
        'petani_user_id',
        'lahan_id',
        'estimasi_tbs_kg',
        'status',
        'reserved_by_pengepul_id',
        'is_pickup',
        'tanggal_pengantaran',
        'nomor_armada_pengantaran',
        'tanggal_penjemputan',
        'nomor_armada_penjemputan',
        'expired_at',
    ];

    public function petani()
    {
        return $this->belongsTo(User::class, 'petani_user_id');
    }

    public function pengepul()
    {
        return $this->belongsTo(User::class, 'reserved_by_pengepul_id');
    }

    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }
}
