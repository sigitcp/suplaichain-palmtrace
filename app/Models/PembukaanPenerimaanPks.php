<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembukaanPenerimaanPks extends Model
{
    use HasFactory;

    protected $table = 'pembukaan_penerimaan_pks';

    protected $fillable = [
        'pks_user_id',
        'harga_per_kg',
        'kapasitas_kg',
        'terms',
        'status',
    ];

    // Relasi ke user PKS
    public function pks()
    {
        return $this->belongsTo(User::class, 'pks_user_id');
    }

    // Relasi ke semua penawaran pengepul untuk penerimaan ini
    public function penawaranPengepul()
    {
        return $this->hasMany(PenawaranPengepulKePks::class, 'pks_id');
    }
}
