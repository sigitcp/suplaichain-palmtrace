<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'isi', 'gambar', 'created_by'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
