<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    use HasFactory;

    protected $fillable = [
        'lahan_id', 
        'tanggal_panen', 
        'jumlah_pokok',
        'jumlah_perpokok',
        'kualitas',
    ];

    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
