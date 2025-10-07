<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'lahan_id', 'penanggung_jawab', 'nama_kebun', 'luas_kebun',
        'sertifikat', 'file_geojson'
    ];

    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }
}
