<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPetani extends Model
{
    use HasFactory;

    protected $table = 'profil_petanis';

    protected $fillable = [
        'user_id',
        'nama_petani',
        'varietas_bibit',
        'luasan_lahan_total',
        'alamat',
        'gmap_link',
        'latitude',
        'longitude',
    ];

    /**
     * Relasi ke user (petani)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
