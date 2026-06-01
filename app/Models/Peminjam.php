<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Peminjam extends Authenticatable
{
    use HasFactory;

    protected $table = 'peminjams';
    protected $fillable = ['nama', 'email', 'password', 'no_hp', 'alamat', 'role'];
    protected $hidden = ['password'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'peminjam_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}