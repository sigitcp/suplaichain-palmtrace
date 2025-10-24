<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'judul',
        'isi',
        'thumbnail',
        'published',
    ];

    // Relasi ke user (penulis)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
