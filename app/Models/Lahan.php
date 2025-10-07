<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nama_lahan', 'alamat', 'gmaps_link'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasOne(DetailLahan::class);
    }

    public function panens()
    {
        return $this->hasMany(Panen::class);
    }
}
