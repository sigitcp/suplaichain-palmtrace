<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPengepul extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kapasitas_tbs',
        'nama_koperasi',
        'alamat',
        'gmaps_link',
        'sertifikat_koperasi',
        'latitude',
        'longitude',
        'foto_kantor'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
