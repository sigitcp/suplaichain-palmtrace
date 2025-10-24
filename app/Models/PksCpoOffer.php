<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PksCpoOffer extends Model
{
    use HasFactory;

    protected $table = 'pks_cpo_offers';

    protected $fillable = [
        'pks_user_id',
        'kapasitas_tahunan_kg',
        'palmitat',
        'oleat',
        'linoleat',
        'stearat',
        'myristat',
        'trigliserida',
        'ffa',
        'fosfatida',
        'karoten',
        'dokumen_lab',
        'status',
    ];

    public function pks()
    {
        return $this->belongsTo(User::class, 'pks_user_id');
    }
}
