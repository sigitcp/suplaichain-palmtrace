<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaCpoMingguan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'harga_per_kg',
    ];
}
