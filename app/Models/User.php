<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'phone',
        'role_id',
        'foto',
        'verified',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function lahans()
    {
        return $this->hasMany(Lahan::class);
    }

    public function profilPengepul()
    {
        return $this->hasOne(ProfilPengepul::class);
    }

    public function artikels()
    {
        return $this->hasMany(Artikel::class, 'created_by');
    }
}
