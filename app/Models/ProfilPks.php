<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPks extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pks',
        'kapasitas_tbs_kg',
        'alamat',
        'gmap_link',
        'latitude',
        'longitude',
        'foto_kantor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
