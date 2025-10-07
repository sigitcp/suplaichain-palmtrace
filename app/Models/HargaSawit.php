<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaSawit extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'harga_perkg'];
}
