<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranPengepulKePks extends Model
{
    use HasFactory;

    protected $table = 'penawaran_pengepul_ke_pks';

    protected $fillable = [
        'pengepul_id',
        'pks_id',
        'estimasi_tbs_kg',
        'nomor_armada',
        'nama_supir',
        'varietas',
        'tanggal_pengantaran',
        'foto_tbs',
        'status',
    ];

    protected $casts = [
        'foto_tbs' => 'array',
    ];

    // Relasi ke pengepul
    public function pengepul()
    {
        return $this->belongsTo(User::class, 'pengepul_id');
    }

    // Relasi ke PKS
    public function pks()
    {
        return $this->belongsTo(User::class, 'pks_id');
    }

    // Relasi ke penimbangan PKS
    public function penimbangan()
    {
        return $this->hasOne(PenimbanganPks::class, 'penawaran_pengepul_id');
    }

    // Relasi ke penerimaan PKS (melalui pks_id)
    public function penerimaanPks()
    {
        return $this->belongsTo(PembukaanPenerimaanPks::class, 'pks_id', 'pks_user_id');
    }
}
