<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaTbsMingguan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'harga_per_kg',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
