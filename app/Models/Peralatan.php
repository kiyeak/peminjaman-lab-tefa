<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    use HasFactory;

    protected $table = 'peralatans';
    protected $fillable = ['nama', 'kode', 'deskripsi', 'gambar', 'stok'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'peralatan_id');
    }

    public function isAvailable()
    {
        return $this->stok > 0;
    }
}