<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'petani_id', 'panen_id', 'status'
    ];

    public function petani()
    {
        return $this->belongsTo(User::class, 'petani_id');
    }

    public function panen()
    {
        return $this->belongsTo(Panen::class);
    }

    public function pembelian()
    {
        return $this->hasOne(Pembelian::class);
    }
}
