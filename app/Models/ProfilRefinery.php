<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilRefinery extends Model
{
    use HasFactory;

    protected $table = 'profil_refinerys'; // ⬅️ sesuaikan dengan nama tabel di migration
    protected $fillable = [
        'user_id',
        'nama_refinery',
        'kapasitas_tbs_kg',
        'alamat',
        'gmap_link',
        'latitude',
        'longitude',
        'foto_kantor',
    ];
}
